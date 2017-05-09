<?php
/**
* 
*/
	class Menu
	{
		private $db_obj;
		private $util_obj;
		function __construct()
		{
			require_once 'utility/db.php';
			require_once 'utility/utility.php';
			
			$this->db_obj = new DBConfig();
			$this->util_obj = new Utility();
		}
		
		function add_menu() {
			$returner = 0;
			
			$new_menu_id = 0;
			$menu = filter_input(INPUT_POST, 'menu_name');
			//$img = $_FILES['img'];
			//$dataX = filter_input(INPUT_POST, 'dataX');
			//$dataY = filter_input(INPUT_POST, 'dataY');
			//$dataH = filter_input(INPUT_POST, 'dataH');
			//$dataW = filter_input(INPUT_POST, 'dataW');
			
			 //if(isset($_FILES['img'])) {
				 
				//$location = 'assets/images/menu-bgs/';  //Location / Restaurant/menu/img
				
				//Insert New Menu 
				$sql = "INSERT INTO tbl_menus (menu_name, menu_img)
							 VALUES (?, ?);";
					
				try {
					$file_name = "";
					
					// if($_FILES['img']['error'] == 0){
						// $upload = $this->util_obj->upload_image($location, $img);
					
						// if($upload['code'] == 1){
							// $file_name = $upload['msg'];
							
							// $actual_img = $location.'orig_'.$file_name;
							// $crop_img = $location.$file_name;
								
							// $source = false;
							
							// $this->util_obj->crop_image($crop_img, $actual_img, $dataX, $dataY, $dataW, $dataH);
						// }
						// else {
							// $returner = $upload['msg'];
						// }
					// }
					// else {
						// $returner = $_FILES['img']['error'];
					// }
						
					$conn = $this->db_obj->db_connect();
					$stmt = $conn->prepare($sql);
					$stmt->bind_param('ss', $menu, $file_name);
					$stmt->execute();
						
					$new_menu_id = mysqli_insert_id($conn);
						
					//Map Menu to selected restaurant
					$sql2 = "INSERT INTO tbl_restaurant_menus (restaurant_id, menu_id)
									VALUES (?, ?);";
					try {
						$conn = $this->db_obj->db_connect();
						$stmt = $conn->prepare($sql2);
						$stmt->bind_param('dd', $_SESSION['restaurant_id'], $new_menu_id);
						$stmt-> execute();
							
						$new_map_id = mysqli_insert_id($conn);
					
						$returner = $new_menu_id;
					}
					catch (Exception $e){
						echo $e->message();
					}
					
				}
				catch(Exception $e){
					echo $e->message();
				}		
			 // }
			 // else{
				 // $returner = 'No Image Found';
			 // }
			 
			 return $returner;
		}
		
		function update_menu() {
			$menu = filter_input(INPUT_POST, 'menu_name');
			$menu_id = filter_input(INPUT_POST, 'mid');
			echo $menu_id;
			
			$affected_rows = 0;
			$sql = "UPDATE tbl_menus
						 SET menu_name = ?
						 WHERE menu_id = ?";
						
			try{
				$conn = $this->db_obj->db_connect();
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('sd', $menu, $menu_id);
				$stmt->execute();
				
				$affected_rows  = mysqli_affected_rows($conn);
				
				return $affected_rows;
			}
			catch (Exception $e){
				Echo $e->message();
			}
		}
		
		function remove_menu($menu_id) {
			$affected_rows = 0;
			
			//Check if Menu has items
			$menus = $this->getMenusFor($_SESSION['restaurant_id']);
			
			foreach($menus as $menu){
				if($menu_id == $menu['id']){
					if($menu['items'] != 0){
						return -1;
					}
				}
			}
			
			$sql = "DELETE FROM tbl_menus
						 WHERE menu_id = ?";
						 
			try{
				$conn = $this->db_obj->db_connect();
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('d', $menu_id);
				$stmt->execute();
				
				$affected_rows = mysqli_affected_rows($conn);
				echo $affected_rows;
				
				if($affected_rows > 0){
					$sql2 = "DELETE FROM tbl_restaurant_menus
									WHERE menu_id = ?";
									
					try{
						$conn = $this->db_obj->db_connect();
						$stmt = $conn->prepare($sql2);
						$stmt->bind_param('d', $menu_id);
						$stmt->execute();
						
						$affected_maps = mysqli_affected_rows($conn);
						

						return $affected_rows;
						
					}
					catch(Exception $e){
						echo $e->message();
					}
				}
			}
			catch(Exception $e) {
				echo $e->message();
			}
		}
		
		function getItemDetails($menu_item_id) {
			$item = array();

			$sql = "SELECT menu_item_id, mi.menu_id, menu_item, price, notes, image, estimated_time, is_special
						 FROM tbl_menu_items mi
						 WHERE menu_item_id = ?";

			try{
				$conn = $this->db_obj->db_connect();
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('d', $menu_item_id);
				$stmt->execute();
				$stmt->bind_result($id, $menu_id, $menu_item, $price, $notes, $image, $time, $is_special);

				while ($stmt->fetch()) {
					$item['id'] = $id;
					$item['menu_id'] = $menu_id;
					$item['menu_item'] = $menu_item;
					$item['price'] = $price;
					$item['note'] = $notes;
					$item['image'] = $image;
					$item['time'] = $time;
					$item['special'] = $is_special;
				}

				$stmt->close();

				return array_filter($item);
			}
			catch (Exception $e) {
				die ('Error: '.$e->message());
			}
		}
		
		function getItemsFor($menu_id) {
			$all = array();

			$sql = "SELECT menu_item_id, mi.menu_id, menu_item, price, notes, image, estimated_time, is_special
						 FROM tbl_menu_items mi
						 WHERE menu_id = ?
						 ORDER BY is_special desc, menu_item";

			try{
				$conn = $this->db_obj->db_connect();
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('d', $menu_id);
				$stmt->execute();
				$stmt->bind_result($id, $menu_id, $menu_item, $price, $notes, $image, $time, $is_special);

				while ($stmt->fetch()) {
					$tmp = array();
					$tmp['id'] = $id;
					$tmp['menu_id'] = $menu_id;
					$tmp['menu_item'] = $menu_item;
					$tmp['price'] = $price;
					$tmp['note'] = $notes;
					$tmp['image'] = $image;
					$tmp['time'] = $time;
					$tmp['special'] = $is_special;
					
					array_push($all, $tmp);
				}

				$stmt->close();

				return array_filter($all);
			}
			catch (Exception $e) {
				die ('Error: '.$e->message());
			}
		}
		
		function getMenusFor($restaurant_id) {
			$all = array();

			$sql = "SELECT m.menu_id, m.menu_name, count(menu_item_id) as qty
						 FROM tbl_menus m
							LEFT JOIN tbl_restaurant_menus rm ON m.menu_id = rm.menu_id
							LEFT JOIN tbl_menu_items mi ON m.menu_id = mi.menu_id
						 WHERE restaurant_id = ?
						 GROUP BY m.menu_id";

			try{
				$conn = $this->db_obj->db_connect();
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('d', $restaurant_id);
				$stmt->execute();
				$stmt->bind_result($id, $menu, $qty);

				while ($stmt->fetch()) {
					$tmp = array();
					$tmp['id'] = $id;
					$tmp['menu'] = $menu;
					$tmp['items'] = $qty;
					
					array_push($all, $tmp);
				}

				$stmt->close();

				return array_filter($all);
			}
			catch (Exception $e) {
				die ('Error: '.$e->message());
			}
		}
	
		function remove_item($item_id) {
			$affected_rows = 0;
			
			//delete uploaded image...
			
			$sql = "DELETE FROM tbl_menu_items
						 WHERE menu_item_id = ?";
						 
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('d', $item_id);
			$stmt->execute();
			
			$affected_rows = mysqli_affected_rows($conn);
			
			$stmt->close();
			
			return $affected_rows;
		}
		
		function set_special_item($item_id, $sp) {
			$affected_rows = 0;
			
			//delete uploaded image...
			
			$sql = "UPDATE tbl_menu_items 
						 SET is_special = ".(($sp == 'y')?1:0)."
						 WHERE menu_item_id = ?";
						 
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('d', $item_id);
			$stmt->execute();
			
			$affected_rows = mysqli_affected_rows($conn);
			
			$stmt->close();
			
			return $affected_rows;
		}
	
		function add_item($menu_id) {
			$returner = '';
			
			$new_menu_id = 0;
			$error = '';
			//$menu_id = '??';
			$item = filter_input(INPUT_POST, 'item_name');
			$price = filter_input(INPUT_POST, 'price');
			$note = filter_input(INPUT_POST, 'note');
			$img = $_FILES['img'];
			$e_time = filter_input(INPUT_POST, 'time');
			$dataX = filter_input(INPUT_POST, 'dataX');
			$dataY = filter_input(INPUT_POST, 'dataY');
			$dataH = filter_input(INPUT_POST, 'dataH');
			$dataW = filter_input(INPUT_POST, 'dataW');
			
			 if(isset($_FILES['img'])) {
				 
				$location = 'assets/images/menu-items/';  //Location / Restaurant/menu/img
				
				//echo $item.'<br>'.$price.'<br>'.$note.'<br><br>'.$e_time;
						
				$sql = "INSERT INTO tbl_menu_items (menu_id, menu_item, price, notes, image, estimated_time)
							  VALUES (?, ?, ?, ?,  ?, ?);";
				try{
					$img_upload = $this->util_obj->upload_image($location, $img, $_SESSION['restaurant'].'_'.$menu_item);
					
					if($img_upload['code'] == 1){						
						$file_name = $img_upload['msg'];
						
						$actual_img = $location.'orig_'.$file_name;
						$crop_img = $location.$file_name;
							
						$source = false;
						
						$this->util_obj->crop_image($crop_img, $actual_img, $dataX, $dataY, $dataW, $dataH);
							
						$conn = $this->db_obj->db_connect();
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('dsdssd', $menu_id, $item, $price, $note, $file_name, $e_time);
						$stmt->execute();
								
						$new_menu_id = mysqli_insert_id($conn);
							
						$stmt->close();
						
						$returner = $new_menu_id;
					}
					else {
						$returner = $img_upload['msg'];
					}
				}
				catch (Exception $e){
					$returner =  $e->message();
				}
			}
			else {
				$returner = 'No image found';
			}
			
			return $returner;
		}
	
		function update_item() {
			$menu_id = filter_input(INPUT_POST, 'mid');
			$item_id = filter_input(INPUT_POST, 'iid');
			$item = filter_input(INPUT_POST, 'item_name');
			$price = filter_input(INPUT_POST, 'price');
			$note = filter_input(INPUT_POST, 'note');
			$time = filter_input(INPUT_POST, 'time');
			
			echo $menu_id;
			
			
			$affected_rows = 0;
			$sql = "UPDATE tbl_menu_items
						 SET menu_id = ?,
								 menu_item = ?,
								 price = ?,
								 notes = ?,				
								 estimated_time = ?
						 WHERE menu_item_id = ?";
						
			try{
				$conn = $this->db_obj->db_connect();
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('dsdsdd', $menu_id, $item, $price, $note, $time, $item_id);
				$stmt->execute();
				
				$affected_rows  = mysqli_affected_rows($conn);
				
				$stmt->close();
				
				return $affected_rows;
			}
			catch (Exception $e){
				Echo $e->message();
			}
		}
		
	}	

?>
