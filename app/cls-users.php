<?php
/**
* 
*/
	class User
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
		
		function add_user() {
			$new_user_id = 0;
			
			$f_name = filter_input(INPUT_POST, 'fname');
			$l_name = filter_input(INPUT_POST, 'lname');
			$u_name = filter_input(INPUT_POST, 'uname');
			$pass = filter_input(INPUT_POST, 'pass');
			$role_id = filter_input(INPUT_POST, 'role');
			
			$epass = $this->util_obj->encrypt_pass($pass);
			
			echo $l_name;
			
			$sql = "INSERT INTO tbl_users (restaurant_id, f_name, l_name, login_name, password, created_by)
						 VALUES (?, ?, ?, ?, ?, ?);";
						 
			try{
				$conn = $this->db_obj->db_connect();
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('dssssd', $_SESSION['restaurant_id'], $f_name, $l_name, $u_name, $epass, $_SESSION['user_id']);
				$stmt->execute();
				
				$new_user_id = mysqli_insert_id($conn);
				
				//Map User to Role
				$map_role = "INSERT INTO tbl_user_roles (user_id, role_id)
										VALUES (?,?);";
										
				try {
					$conn = $this->db_obj->db_connect();
					$stmt = $conn->prepare($map_role);
					$stmt->bind_param('dd', $new_user_id, $role_id);
					$stmt->execute();
					
					$new = mysqli_insert_id($conn);
					
					//$stmt->close();
				}
				catch(Exception $e){
					die ('Error: '.$e->message());
				}
				
				$stmt->close();
				
				return $new_user_id;
			}
			catch (Exception $e){
				die ('Error: '.$e->message());
			}
		}
		
		function update_user($user_id) {
			$affected_rows = 0;
			
			$f_name = filter_input(INPUT_POST, 'fname');
			$l_name = filter_input(INPUT_POST, 'lname');
			$u_name = filter_input(INPUT_POST, 'uname');
			// $pass = filter_input(INPUT_POST, 'pass');
			$role_id = filter_input(INPUT_POST, 'role');
			
			//$epass = $this->util_obj->encrypt_pass($pass);
			
			echo $l_name;
			
			$sql = "UPDATE tbl_users 
						  SET f_name = ?, 
								  l_name = ?, 
								  login_name = ?
						 WHERE user_id = ?;";
						 
			try{
				$conn = $this->db_obj->db_connect();
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('sssd', $f_name, $l_name, $u_name, $user_id);
				$stmt->execute();
				
				$affected_rows = mysqli_affected_rows($conn);
				
				//Map User to Role
				$map_role = "UPDATE tbl_user_roles 
										SET role_id = ?
										WHERE user_id = ?;";
										
				try {
					$conn = $this->db_obj->db_connect();
					$stmt = $conn->prepare($map_role);
					$stmt->bind_param('dd', $role_id, $user_id);
					$stmt->execute();
					
					$new = mysqli_affected_rows($conn);
					
					if($affected_rows == 0)
						$affected_rows = $new;
					//$stmt->close();
				}
				catch(Exception $e){
					die ('Error: '.$e->message());
				}
				
				$stmt->close();
				
				return $affected_rows;
			}
			catch (Exception $e){
				die ('Error: '.$e->message());
			}
		}
		
		function remove_user($user_id) {
			echo $user_id;
			
			$affected_rows = 0;

			$sql = "UPDATE tbl_users 
						  SET is_deleted = 1
						 WHERE user_id = ?";
						 
			try{
				$conn = $this->db_obj->db_connect();
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('s', $user_id);
				$stmt->execute();
				
				$affected_rows = mysqli_affected_rows($conn);
				
				$stmt->close();
			}
			catch (Exception $e){
				die ('Error: '.$e->message());
			}
			
			return $affected_rows;
		}
		
		function getDetails($user_id) {
			$user = array();
			
			$sql = "SELECT u.user_id, f_name, l_name, login_name, password, ur.role_id, r.role, restaurant_id, rst.restaurants
						 FROM tbl_users u
							LEFT JOIN tbl_user_roles ur ON u.user_id = ur.user_id
							LEFT JOIN tbl_roles r ON ur.role_id = r.role_id
							LEFT JOIN tbl_restaurants rst ON u.restaurant_id = rst.id
						 WHERE u.restaurant_id = ? and u.user_id = ?";
						 
			try{
				$conn = $this->db_obj->db_connect();
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('dd', $_SESSION['restaurant_id'], $user_id);
				$stmt->execute();
				$stmt->bind_result($user_id, $f_name, $l_name, $login_name, $pass, $role_id, $role, $restaurant_id, $restaurant);

				while ($stmt->fetch()) {
					//$tmp = array();
					$user['user_id'] = $user_id;
					$user['fname'] = $f_name;
					$user['lname'] = $l_name;
					$user['uname'] = $login_name;
					//$user['pass'] = $pass;
					$user['role_id'] = $role_id;
					$user['role'] = $role;
					$user['restaurant_id'] = $restaurant_id;
					$user['restaurant'] = $restaurant;
					//$user['theme'] = $theme;
					
					//array_push($all, $tmp);
				}

				$stmt->close();

				return array_filter($user);
			}
			catch (Exception $e) {
				die ('Error: '.$e->message());
			}
		}
		
		function getAll($for = '') {
			$all = array();

			if($for == 'r'){
				$sql = "SELECT u.user_id, f_name, l_name, login_name, password, ur.role_id, r.role, restaurant_id, rst.restaurants, theme_id, rst.logo, rst.bg_image
							 FROM tbl_users u
								LEFT JOIN tbl_user_roles ur ON u.user_id = ur.user_id
								LEFT JOIN tbl_roles r ON ur.role_id = r.role_id
								LEFT JOIN tbl_restaurants rst ON u.restaurant_id = rst.id
							WHERE u.restaurant_id = ? and u.is_deleted = 0 and ur.role_id != 5";
			}
			else {
				$sql = "SELECT u.user_id, f_name, l_name, login_name, password, ur.role_id, r.role, restaurant_id, rst.restaurants, theme_id, rst.logo, rst.bg_image
							 FROM tbl_users u
								LEFT JOIN tbl_user_roles ur ON u.user_id = ur.user_id
								LEFT JOIN tbl_roles r ON ur.role_id = r.role_id
								LEFT JOIN tbl_restaurants rst ON u.restaurant_id = rst.id
							 WHERE u.is_deleted = 0";
			}

			try{
				$conn = $this->db_obj->db_connect();
				$stmt = $conn->prepare($sql);
				if($for == 'r'){
					$stmt->bind_param('d', $_SESSION['restaurant_id']);
				}
				$stmt->execute();
				$stmt->bind_result($user_id, $f_name, $l_name, $login_name, $pass, $role_id, $role, $restaurant_id, $restaurant, $theme, $logo, $bg_image);

				while ($stmt->fetch()) {
					$tmp = array();
					$tmp['user_id'] = $user_id;
					$tmp['fname'] = $f_name;
					$tmp['lname'] = $l_name;
					$tmp['uname'] = $login_name;
					$tmp['pass'] = $pass;
					$tmp['role_id'] = $role_id;
					$tmp['role'] = $role;
					$tmp['restaurant_id'] = $restaurant_id;
					$tmp['restaurant'] = $restaurant;
					$tmp['theme'] = $theme;
					$tmp['restaurant_logo'] = $logo;
					$tmp['restaurant_bg_image'] = $bg_image;
					
					array_push($all, $tmp);
				}

				$stmt->close();

				return array_filter($all);
			}
			catch (Exception $e) {
				die ('Error: '.$e->message());
			}
		}
	
		function change_password() {
			$affected_rows = 0;
			
			$old_pass = filter_input(INPUT_POST, 'opass');
			$new_pass = filter_input(INPUT_POST, 'npass');
			
			$e_opass = $this->util_obj->encrypt_pass($old_pass);
			$e_npass = $this->util_obj->encrypt_pass($new_pass);
			
			echo '<pre>';
			print_r($_SESSION);
			echo '</pre>';
			
			$sql = "UPDATE tbl_users 
						  SET password = ?
						 WHERE user_id = ?;";
						 
			try{
				$conn = $this->db_obj->db_connect();
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('sd', $e_npass, $_SESSION['user_id']);
				$stmt->execute();
				
				$affected_rows = mysqli_affected_rows($conn);
				
				$stmt->close();
				
				return $affected_rows;
			}
			catch (Exception $e){
				die ('Error: '.$e->message());
			}
		}
		
	}	

?>
