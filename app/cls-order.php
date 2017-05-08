<?php
/**
* 
*/
	class Order
	{
		private $db_obj;
		function __construct()
		{
			if(isset($_GET['data']))
				require_once '../utility/db.php';
			else
				require_once 'utility/db.php';
			$this->db_obj = new DBConfig();
		}
		
		function addToPlate() {
			$item = FILTER_INPUT(INPUT_POST, 'item');
			$price = FILTER_INPUT(INPUT_POST, 'price');
			$qty = FILTER_INPUT(INPUT_POST, 'qty');
			$time = $this->getOrderTime('item', $item);
			
			$item = intval($item);
			
			// if(isset($_SESSION['order'][$item])){
				//$_SESSION['order'][$item]['quantity']++;
			//}
			// foreach($_SESSION['order'] as $id=>$value){
				// if($value == ''){
					// unset($_SESSION['order'][$id]);
				// }
			// }
			
			if($qty != 0 && $item != ''){
				$_SESSION['order'][$item] = array("quantity" => $qty, "price" => $price, "time" => $time);
			}
			else {
				
			}
			//}			
		}
		
		function updatePlateQuantity($item, $qty) {
			$item = intval($item);
			
			if(isset($_SESSION['order'][$item])){
				$_SESSION['order'][$item]['quantity'] = $qty;
			}
			
			return $_SESSION['order'][$item]['quantity'];
		}
		
		function removeFromPlate() {
			$item = FILTER_INPUT(INPUT_POST, 'item');

			$item = intval($item);
			
			if(isset($_SESSION['order'][$item])){
				unset($_SESSION['order'][$item]);
			}
		}
		
		function add() {
			$max_order_key = 0;
			
			$pref = filter_input(INPUT_POST, 'pref');
			$pref = 'Tetst';
			
			$sql_max = "SELECT max(order_key) FROM tbl_orders";
			$conn = $this->db_obj->db_connect();
			$max_stmt = $conn->prepare($sql_max);
			$max_stmt->execute();
			$max_stmt->bind_result($max);
			
			while($max_stmt->fetch()){
				$max_order_key = $max;
			}
			
			$max_stmt->close();
			
			$max_order_key++;
			
			$count = 0;
			
			
			$avg_etime = $this->estimate_time();;
			
			$sql = "INSERT INTO tbl_orders (order_key, restaurant_id, table_id, menu_item_id, quantity, item_price, estimated_d_time, preference) 
						 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			
			foreach ($_SESSION['order'] as $id=>$value){
				$stmt->bind_param('ddddddds', $max_order_key, $_SESSION['restaurant_id'], $_SESSION['table_id'], $id, $_SESSION['order'][$id]['quantity'], $_SESSION['order'][$id]['price'], $avg_etime, $pref);
				$stmt->execute();
				$count++;
			}
			
			unset($_SESSION['order']);

			$stmt->close();
			return $max_order_key;
		}
		
		function getOrderStatus($order_key) {
			$status = '';
			
			$sql = "SELECT order_status
						 FROM tbl_orders o
							LEFT JOIN tbl_order_status os ON o.order_status_id = os.status_id
						 WHERE o.order_key = ?";
			
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('d', $order_key);
			$stmt->execute();
			$stmt->bind_result($sts);
			
			while($stmt->fetch()){
				$status = $sts;
			}
			
			return $status;
		}
		
		function getOrderTime($for, $id){
			$time = 0;
			
			If($for == 'item'){
				//echo 'Item';
				$sql = 'SELECT estimated_time 
							 FROM tbl_menu_items
							 WHERE menu_item_id = ?';
			}
			else{
				//echo 'Not Item';
				//echo $id;
				$sql = 'SELECT estimated_d_time
							 FROM tbl_orders
							 WHERE order_key = ?
							 LIMIT 1';
			}
			
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('d', $id);
			$stmt->execute();
			$stmt->bind_result($e_time);
			
			while($stmt->fetch()){
				$time = $e_time;
			}
			
			//echo 'Time: '.$time;
			
			$stmt->close();
			
			return $time;			
		}
		
		function updateOrderStatus($order_key, $status) {
			$affected_rows = 0;
			
			switch($status){
				case 2:
					$sql = "UPDATE tbl_orders 
								 SET order_status_id = ?,
										 process_date = NOW()
								 WHERE order_key = ?";
					break;
				case 3:
					$sql = "UPDATE tbl_orders 
								 SET order_status_id = ?,
										 served_date = NOW()
								 WHERE order_key = ?";
					break;
				case 4:
					$sql = "UPDATE tbl_orders 
								 SET order_status_id = ?,
										 paid_date = NOW()
								 WHERE order_key = ?";
					break;
				default:
					$sql = "UPDATE tbl_orders 
								 SET order_status_id = ?
								 WHERE order_key = ?";
					break;
			}
						 
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('dd', $status, $order_key);
			$stmt->execute();
			
			$affected_rows = mysqli_affected_rows($conn);
			
			$stmt->close();
			
			return $affected_rows;
		}
		
		function update($order_id) {
			
		}
		
		function remove($order_id) {
			
		}
		
		function getDetails($order_id) {
			
		}
		
		function getAllFor($type, $id) {
			$all = array();
			$sql = "";
			
			switch($type){
				case 't':
					$sql = "SELECT order_id, table_id, menu_item_id, menu_item, quantity, price, order_date, order_status_id, response_date
								 FROM tbl_orders o
									LEFT JOIN tbl_menu_items mi ON o.menu_item_id = mi.menu_item_id
								 WHERE table_id = ?";
					break;
					
				case 'r':
					$sql = "SELECT order_id, rm.restaurant_id, table_id, menu_item_id, menu_item, quantity, price, order_date, order_status_id, response_date, estimated_d_time
								 FROM tbl_orders o
									LEFT JOIN tbl_menu_items mi ON o.menu_item_id = mi.menu_item_id
									LEFT JOIN tbl_menus m ON mi.menu_id = m.menu_id
									LEFT JOIN tbl_restaurant_menus rm ON m.menu_id = rm.menu_id
								 WHERE restaurant_id = ?";
					break;
					
				case 'k':
					$sql = "SELECT order_id, table_id, mi.menu_item_id, menu_item, quantity, price, order_date, order_status_id, response_date, estimated_d_time
								 FROM tbl_orders o
									LEFT JOIN tbl_menu_items mi ON o.menu_item_id = mi.menu_item_id
								 WHERE order_key = ?";
					break;

				default:
					$sql = "SELECT order_id, table_id, menu_item_id, menu_item, quantity, price, order_date, order_status_id, response_date, estimated_d_time
								 FROM tbl_orders o
									LEFT JOIN tbl_menu_items mi ON o.menu_item_id = mi.menu_item_id
								 WHERE table_id = ?";
					break;
			}

			try{
				$conn = $this->db_obj->db_connect();
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('d', $id);
				$stmt->execute();
				$stmt->bind_result($id, $table_id, $menu_item_id, $menu_item, $quantity, $price, $order_date, $order_status_id, $response_date, $etime);

				while ($stmt->fetch()) {
					$tmp = array();
					$tmp['order_id'] = $id;
					$tmp['table_id'] = $table_id;
					$tmp['menu_item_id'] = $menu_item_id;
					$tmp['menu_item'] = $menu_item;
					$tmp['quantity'] = $quantity;
					$tmp['price'] = $price;
					$tmp['order_date'] = $order_date;
					$tmp['order_status_id'] = $order_status_id;
					$tmp['response_date'] = $response_date;
					$tmp['etime'] = $etime;
					
					array_push($all, $tmp);
				}

				$stmt->close();

				return array_filter($all);
			}
			catch (Exception $e) {
				die ('Error: '.$e->message());
			}
		}
		
		function getOrderSummary($status = 1) {
			$all = array();
			
			$sql = "SELECT order_id, o.table_id, order_key, count(menu_item_id) items, o.order_date
						 FROM tbl_orders o
							LEFT JOIN tbl_tables t ON o.table_id = t.table_id
						 WHERE order_status_id = ? and  restaurant_id = ?
						 GROUP BY o.order_key";
			
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('dd', $status, $_SESSION['restaurant_id']);
			$stmt->execute();
			$stmt->bind_result($order_id, $table_id, $order_key, $items, $date);
			
			while($stmt->fetch()){
				$tmp = array();
				$tmp['order_id'] = $order_id;
				$tmp['table_id'] = $table_id;
				$tmp['order_key'] = $order_key;
				$tmp['items'] = $items;
				$tmp['date'] = $date;
				
				array_push($all, $tmp);
			}
			
			$stmt->close();
			
			return array_filter($all);
		}
	
		function estimate_time () {
			$etime = 0;
			$avg_etime = 0;
			$ttl_etime = 0;
			$etime_count = 0;
			
			$count = count($_SESSION['order']);
			
			if($count < 2) {
				foreach($_SESSION['order'] as $id=>$value){
					$ttl_etime += $_SESSION['order'][$id]['time'];
					$etime_count++;
				}
				
				if($etime_count != 0)
					$avg_etime = $ttl_etime/$etime_count;
				else
					$avg_etime = 0;
				
				$etime = $avg_etime;
			}
			elseif($count == 2) {
				foreach($_SESSION['order'] as $id=>$value){
					$etime += $_SESSION['order'][$id]['time'];
				}
			}
			elseif($count == 3) {
				$max_etime = 0;
				foreach($_SESSION['order'] as $id=>$value){
					$ttl_etime += $_SESSION['order'][$id]['time'];
					
					if($_SESSION['order'][$id]['time'] > $max_etime)
						$max_etime = $_SESSION['order'][$id]['time'];
				}
				
				$etime = $max_etime + $ttl_etime;
			}
			else {
				$max_etime = 0;
				$min_etime = $_SESSION['order'][1]['time'];
				
				foreach($_SESSION['order'] as $id=>$value){
					$ttl_etime += $_SESSION['order'][$id]['time'];
					
					if($_SESSION['order'][$id]['time'] > $max_etime)
						$max_etime = $_SESSION['order'][$id]['time'];
					if($_SESSION['order'][$id]['time'] < $min_etime)
						$min_etime = $_SESSION['order'][$id]['time'];
				}
				
				$etime = $max_etime + $ttl_etime + $min_etime;
			}			
			
			return $etime;
		}
		
	}	

?>
