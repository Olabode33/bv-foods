<?php
/**
* 
*/
class Restaurant
{
	private $db_obj;
	private $util_obj;
	
	function __construct()
	{
		require 'utility/db.php';
		require 'utility/utility.php';
		
		$this->db_obj = new DBConfig();
		$this->util_obj = new Utility();
	}
	
	function add_restaurant() {
		$returner = 0;
		
		$new_menu_id = 0;
		$restaurant = filter_input(INPUT_POST, 'restaurant_name');
		$theme = filter_input(INPUT_POST, 'theme_id');
		$logo = $_FILES['logo'];
		$bg_image = $_FILES['bg_image'];
		$address = filter_input(INPUT_POST, 'address');
		$region = filter_input(INPUT_POST, 'region');
		$phone = filter_input(INPUT_POST, 'phone');
		$email = filter_input(INPUT_POST, 'email');
		
		echo '<pre>';
			print_r($_POST);
		echo '</pre>';
		
		$logo_location = 'assets/images/restaurants-logo/';
		$bg_location = 'assets/images/restaurants-bg/';
		
		$sql = "INSERT INTO tbl_restaurants (restaurants, theme_id, logo, bg_image, address, region_id, phone, email)
					 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		
		try{
			$logo_img = '';
			$bg_image = '';
			
			echo '<pre>';
			print_r($_FILES['logo']);
			echo '</pre>';
			echo '<pre>';
			print_r($_FILES['bg_image']);
			echo '</pre>';
			
			if($_FILES['logo']['error'] == 0){
				$logo_upload = $this->util_obj->upload_image($logo_location, $logo);
				
				if($logo_upload['code'] == 1){
					$logo_img = 'orig_'.$logo_upload['msg'];
				}
				else
					$returner .= $logo_upload['msg'];
			}
			
			if($_FILES['bg_image']['error'] == 0){
				$bg_upload = $this->util_obj->upload_image($bg_location, $bg_image);
				
				if($bg_upload['code'] == 1)
					$bg_image = 'orig_'.$bg_upload['msg'];
				else
					$returner .= $logo_upload['msg'];
			}
			
			//echo $logo_img;
			//echo $bg_image;
			
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('ssssssss', $restaurant, $theme, $logo_img, $bg_image, $address, $region, $phone, $email);
			$stmt->execute();
						
			$new_id = mysqli_insert_id($conn);
						
			$returner = $new_id;
						
		}
		catch(Exception $e){
			echo $e->message();
		}	
					
		return $returner;
	}
	
	function update_restaurant($restaurant_id) {
		$returner = 0;
		
		$new_menu_id = 0;
		$restaurant = filter_input(INPUT_POST, 'restaurant_name');
		$theme = filter_input(INPUT_POST, 'theme_id');
		$address = filter_input(INPUT_POST, 'address');
		$region = filter_input(INPUT_POST, 'region');
		$phone = filter_input(INPUT_POST, 'phone');
		$email = filter_input(INPUT_POST, 'email');
		
		
		echo $restaurant_id.'<pre>';
			print_r($_POST);
		echo '</pre>';
				
		$sql = "UPDATE tbl_restaurants 
					SET restaurants = ?, 
						   theme_id = ?, 
						   address = ?, 
						   region_id = ?, 
						   phone = ?, 
						   email = ?
					WHERE id = ?";
		
		try{			
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('sdsdssd', $restaurant, $theme, $address, $region, $phone, $email, $restaurant_id);
			$stmt->execute();
						
			$affected_rows = mysqli_affected_rows($conn);
						
			$returner = $affected_rows;
						
		}
		catch(Exception $e){
			echo $e->message();
		}	
					
		return $returner;
	}
	
	function remove_restaurant($restaurant_id) {
		$affected_rows = 0;
			
		$sql = "UPDATE tbl_restaurants
					 SET is_deleted = 1
					 WHERE id = ?";
						 
		try{
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('d', $restaurant_id);
			$stmt->execute();
					
			$affected_rows = mysqli_affected_rows($conn);
			echo $affected_rows;
			
			return $affected_rows;
		}
		catch(Exception $e) {
			echo $e->message();
		}
	}
	
	function getTables($restaurant_id, $table = 0) {
		$tables = array();
		
		if($table == 0)
			$sql = "SELECT t.table_id, table_name, seats, rt.restaurant_id
						 FROM tbl_tables t
							LEFT JOIN tbl_restaurant_tables rt ON t.table_id = rt.table_id
						 WHERE rt.restaurant_id = ?";
		else 
			$sql = "SELECT t.table_id, table_name, seats, rt.restaurant_id
						 FROM tbl_tables t
							LEFT JOIN tbl_restaurant_tables rt ON t.table_id = rt.table_id
						 WHERE rt.restaurant_id = ? and t.table_id = ?";
		
		try{
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			
			if($table == 0)
				$stmt->bind_param('d', $restaurant_id);
			else
				$stmt->bind_param('dd', $restaurant_id, $table);
			
			$stmt->execute();
			$stmt->bind_result($table_id, $table_name, $no_seats, $restaurant_id);
			
			while($stmt->fetch()){
				$tmp = array();
				$tmp['table_id'] = $table_id;
				$tmp['table_name'] = $table_name;
				$tmp['no_seats'] = $no_seats;
				$tmp['restaurant_id'] = $restaurant_id;
				
				array_push($tables, $tmp);
			}
			
			$stmt->close();
			
			
			return array_filter($tables);
		}
		catch(Exception $e){
			echo $e->message();
		}
	}
	
	function getAll($id = 0) {
		$all = array();
		
		if($id == 0)
			$sql = "SELECT id, restaurants, theme_id, logo, bg_image, address, region, state, phone, email
						 FROM tbl_restaurants r
							LEFT JOIN tbl_regions lga ON r.region_id = lga.region_id
							LEFT JOIN tbl_states s ON lga.state_id = s.state_id
						 WHERE is_deleted = 0";
		else 
			$sql = "SELECT id, restaurants, theme_id, logo, bg_image, address, region, state, phone, email
						 FROM tbl_restaurants r
							LEFT JOIN tbl_regions lga ON r.region_id = lga.region_id
							LEFT JOIN tbl_states s ON lga.state_id = s.state_id
						 WHERE is_deleted = 0 and r.id = ?";

		try{
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			if($id != 0)
				$stmt->bind_param('d', $id);
			$stmt->execute();
			$stmt->bind_result($id, $restaurant, $theme_id, $logo, $bg_image, $address, $region, $state, $phone, $email);

			while ($stmt->fetch()) {
				$tmp = array();
				$tmp['id'] = $id;
				$tmp['restaurant'] = $restaurant;
				$tmp['theme_id'] = $theme_id;
				$tmp['logo'] = $logo;
				$tmp['bg_image'] = $bg_image;
				$tmp['address'] = $address;
				$tmp['region'] = $region;
				$tmp['state'] = $state;
				$tmp['phone'] = $phone;
				$tmp['email'] = $email;
				array_push($all, $tmp);
			}

			$stmt->close();

			return array_filter($all);
		}
		catch (Exception $e) {
			die ('Error: '.$e->message());
		}
	}
	
	function add_table(){
		$returner = 0;
		
		$new_menu_id = 0;
		$restaurant_id = filter_input(INPUT_POST, 'rid');
		$table_name = filter_input(INPUT_POST, 'table_name');
		$no_seats = filter_input(INPUT_POST, 'no_seats');
		
		$sql = "INSERT INTO tbl_tables (table_name, seats)
					 VALUES (?, ?)";
		
		// echo '<pre>';
		// print_r($_POST);
		// echo '</pre>';
		
		// echo $table_name;
		// echo $no_seats;
		
		try{
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('ss', $table_name, $no_seats);
			$stmt->execute();
						
			$new_id = mysqli_insert_id($conn);
			
			$sql_rest = "INSERT INTO tbl_restaurant_tables (restaurant_id, table_id)
								  VALUES(?, ?)";
								  
			try{
				$conn = $this->db_obj->db_connect();
				$stmt_r = $conn->prepare($sql_rest);
				$stmt_r->bind_param('dd', $restaurant_id, $new_id);
				$stmt_r->execute();
				
				$new_table_mp = mysqli_insert_id($conn);
			}
			catch(Exception $e){
				
			}
			
			$stmt->close();
						
			$returner = $new_id;
						
		}
		catch(Exception $e){
			echo $e->message();
		}	
					
		return $returner;
	}
	
	function remove_table($table_id) {
		$affected_rows = 0;
			
		$sql = "DELETE FROM tbl_tables
					 WHERE table_id = ?";
						 
		try{
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('d', $table_id);
			$stmt->execute();
					
			$affected_rows = mysqli_affected_rows($conn);
			echo $affected_rows;
			
			return $affected_rows;
		}
		catch(Exception $e) {
			echo $e->message();
		}
	}

	function update_table($table_id) {
		$returner = 0;
		
		$new_menu_id = 0;
		$table_name = filter_input(INPUT_POST, 'table_name');
		$no_seats = filter_input(INPUT_POST, 'no_seats');
		
		$sql = "UPDATE tbl_tables 
					SET table_name = ?,
							seats = ?
					WHERE table_id = ?;";
		
		try{
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('ssd', $table_name, $no_seats, $table_id);
			$stmt->execute();
						
			$new_id = mysqli_affected_rows($conn);
			
			$stmt->close();
						
			$returner = $new_id;				
		}
		catch(Exception $e){
			echo $e->message();
		}	
					
		return $returner;
	}
	
	function replace_image($type, $restaurant_id){
		//type = logo; bg; menu;
		$original = filter_input(INPUT_POST, 'orig_img');
		$new_img = $_FILES['image'];
		
		if($type = "bg")
			$location =  'assets/images/restaurants-bg/'; 
		else
			$location = 'assets/images/restaurants-logo/';
		
		$replace_image = $util->replace_image($original, $new_img, $location);
		
		if($replace_image['code'] == 1){
			$sql = "UPDATE tbl_restaurants 
						SET ".($type == "bg"?'bg_image':'logo')." = ?
						WHERE id = ?;";
			
			try{
				$conn = $this->db_obj->db_connect();
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('sd', $replace_image['msg'], $restaurant_id);
				$stmt->execute();
							
				$new_id = mysqli_affected_rows($conn);
				
				$stmt->close();
							
				$returner = $new_id;				
			}
			catch(Exception $e){
				echo $e->message();
			}	
		}
		
		return $returner;
	}
}	

?>
