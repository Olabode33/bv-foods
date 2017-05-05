<?php
/**
* 
*/
	class LoginMgr
	{
		private $db_obj;
		private $util_obj;
		private $rtr_obj;
		private $tbl_obj;
		private $user_obj;
		
		function __construct()
		{
			require_once './utility/db.php';
			require_once './utility/utility.php';
			require_once 'cls-restaurant.php';
			require_once 'cls-table.php';
			require_once 'cls-users.php';
			
			$this->db_obj = new DBConfig();
			$this->util_obj = new Utility();
			$this->rtr_obj = new Restaurant();	
			$this->tbl_obj = new Table();
			$this->user_obj = new User();
		}
		
		function login (){
			$returner = false;
			$uname = FILTER_INPUT(INPUT_POST, 'uname');
			$pass = FILTER_INPUT(INPUT_POST, 'pass');
			
			$epass = $this->util_obj->encrypt_pass($pass);
			
			$users = $this->user_obj->getAll();
			
			foreach($users as $user) {
				if($uname == $user['uname'] && $epass == $user['pass']){
					$_SESSION['user_id'] = $user['user_id'];
					$_SESSION['user'] = $user['uname'];
					$_SESSION['fname'] = $user['fname'];
					$_SESSION['lname'] = $user['lname'];
					$_SESSION['role_id'] = $user['role_id'];
					$_SESSION['role'] = $user['role'];
					$_SESSION['restaurant_id'] = $user['restaurant_id'];
					$_SESSION['restaurant'] = $user['restaurant'];
					$_SESSION['theme_id'] = $user['theme'];
					$_SESSION['logo_name'] = $user['restaurant_logo'];
					$_SESSION['bg_image'] = $user['restaurant_bg_image'];
					$returner = true;
				}
			}
			
			return $returner;
		}
		
		function setTable ($table = 0) {
			$returner = false;
			
			if($table == 0)
				$table = FILTER_INPUT(INPUT_POST, 'table');
			
			$tables = $this->tbl_obj->getAllFor($_SESSION['restaurant_id']);
			
			foreach($tables as $t){
				if($table == $t['id']){
					$_SESSION['table_id'] = $t['id'];
					$_SESSION['table'] = $t['table'];
					$returner = true;
				}
			}
			
			return $returner;
		}
		
		function unsetTable() {
			unset($_SESSION['table_id']);
			unset($_SESSION['table']);
		}
		
		function logout() {
			session_unset();
		}
		
		function isLoggedin() {
			$returner = false;
			
			if(isset($_SESSION['restaurant_id'])){
				if(isset($_SESSION['table_id'])){
					$returner = true;
				}
				else
					$returner = false;
			}
			else
				$returner = false;
			
		}
		
		function setRestaurant ($restaurant = 0) {
			$returner = false;
			
			if($restaurant == 0)
				$restaurant = FILTER_INPUT(INPUT_POST, 'restaurant');
			
			$restaurants = $this->rtr_obj->getAll($restaurant);
			
			foreach($restaurants as $restaurant){
				//if($table == $t['id']){
					$_SESSION['restaurant_id'] = $restaurant['id'];
					$_SESSION['restaurant'] = $restaurant['restaurant'];
					$_SESSION['theme_id'] = $restaurant['theme_id'];
					$_SESSION['logo_name'] = $restaurant['logo'];
					$_SESSION['bg_image'] = $restaurant['bg_image'];
					$returner = true;
				//}
			}
			
			return $returner;
		}
	}	

?>
