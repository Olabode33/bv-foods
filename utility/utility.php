<?php

/**
* 
*/
class Utility
{
	private $db_obj;
	function __construct()
	{
		require_once 'db.php';
		$this->db_obj = new DBConfig();
	}

	function LoadSelect($table, $select_name, $value, $option, $selected = 0)
	{ 
		$type = '';
		$qry = "SELECT ".$value.", ".$option."  FROM ".$table."";
		$conn = $this->db_obj->db_connect();
		//echo $qry.'<br>';
		
		try {
			$stmt =  $conn->prepare($qry);// or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error(), E_USER_ERROR);
			$stmt->execute() or trigger_error("Execution Failed: ".mysqli_error()); 
			$stmt->bind_Result($id, $op);
			
			//echo $selected;
			 
			echo '<select name="'.$select_name.'" id="'.$select_name.'" class ="form-control">';
			echo '<option value=""> -- Select -- </option>';
				while ($stmt->fetch()) 
	    	    {
					if ($id == $selected)
			        	echo '<option selected value = "'.$id.'">'.$op.'</option>';
					else
						echo '<option value = "'.$id.'">'.$op.'</option>';
				}
			echo '</select>';
						
			$stmt->close();	 
		}
		catch (Exception $e)
		{
			die($e->message());
		}    
	}
	
	function getObjectFromID($table, $col_text, $col_id, $id){
		$text = '';
		$sql = "SELECT ".$col_text."
					 FROM ".$table."
					 WHERE ".$col_id." = '".$id."';";
		
		$conn = $this->db_obj->db_connect();
		$stmt = $conn->prepare($sql);
		$stmt->execute() or trigger_error("Execution Failed: ".mysqli_error()); 
		$stmt->bind_Result($txt);
		
		while($stmt->fetch()){
			$text = $txt;
		}
		return $text;
	}
	
	function random_string($len = 10){
		$alphanum_string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$new_string = '';

		for ($i=0; $i < $len; $i++) { 
			$new_string .=  $alphanum_string[rand(0, strlen($alphanum_string) -1 )];
		}
		
		return $new_string;
	}
	
	function encrypt_pass($pword)
    {
		$hash_pword = hash('sha256', $pword);		
		$new_pword = substr($hash_pword, 10, 45);
		
		return $new_pword;
	}
	
	function upload_image($location, $image, $name) {
		$return_array = array();
			
		if(isset($image)) {
			// MenuId and image
			$errors = "";
			$file_name = $image['name'];
			$file_size = $image['size'];
			$file_tmp = $image['tmp_name'];
			$file_type = $image['type'];

			//$location = 'assets/images/menu-items/';  //Location / Restaurant/menu/img
			
			$tmp_1 = explode('.',$image['name']);
			$tmp_1 = end($tmp_1);
			$file_ext = strtolower($tmp_1);
			
			$img_info = getimagesize($file_tmp);
			echo '<pre>';
			//print_r($img_info);
			echo '</pre>';
			$img_width = $img_info[0];
			$img_height = $img_info[1];

			$extentions = array("jpg", "jpeg", "png");
			
			if(in_array($file_ext, $extentions)===false)
			{
				$errors .= "Extention not allowed, Please choose a JPG, JPEG or PNG file.<br/>";
			}
			if(file_exists($location.$file_name))
			{
				$errors .= "File already exists.<br/>";
			}
			if($file_size > 2000000)
			{
				$errors .= "Picture size should not be more than 2MB.<br/>";
			}
			// if($img_width != 400 || $img_height != 350){
				// $errors .= "Picture size should be 400 by 350<br/>";
			// }
			
			if($errors === "") { 
				if(move_uploaded_file($file_tmp, $location.'orig_'.preg_replace("/[^a-zA-Z]+/", "", $name).'_'.$file_name)){
					$return_array['code'] = 1;
					$return_array['msg'] = preg_replace("/[^a-zA-Z]+/", "", $name).'_'.$file_name;
				}
				else {
					$return_array['code'] = 0;
					$return_array['msg'] = 'Error Uploading File.';
				}
			}
			else {
				$return_array['code'] = 0;
				$return_array['msg'] = 'Error: '.$errors;
			}
		}	
		else {
			$return_array['code'] = 0;
			$return_array['msg'] = 'No Image Found';
		}
			
		return array_filter($return_array);
	}
		
	function crop_image($dst_img, $source_img, $dst_x, $dst_y, $dst_width, $dst_height){
		$returner = false;

		$cropped = imagecreatetruecolor($dst_width, $dst_height);
							
		switch(exif_imagetype($source_img)){
			case 2:
				$source = imagecreatefromjpeg($source_img);
				break;
			case 3:
				$source = imagecreatefrompng($source_img);
				break;
			default:
				$source = imagecreatefrompng($source_img);
				break;
		}
							
		$returner = imagecopyresampled($cropped, $source, 0, 0, $dst_x, $dst_y, $dst_width, $dst_height, $dst_width, $dst_height);
					
		switch(exif_imagetype($source_img)){
			case 2:
				$returner = imagejpeg($cropped, $dst_img, 100);
				break;
			case 3:
				$returner = imagepng($cropped, $dst_img, 0);
				break;
			default:
				$returner = imagepng($cropped, $dst_img, 0);
				break;
		}
						
		unlink($source_img);
			
		return $returner;
	}
	
	function replace_image($orig_image, $new_image, $location) {
		$returner = array();
				
		if($new_image['error'] == 0){
			$image_upload = $this->upload_image($location, $new_image);
			
			$returner['code'] = $image_upload['code']; 
			
			if($image_upload['code'] == 1){
				$returner['msg'] = 'orig_'.$image_upload['msg'];
				unlink($orig_image);
			}
			else
				$returner['msg'] = $image_upload['msg'];			
		}
			
		return array_filter($returner);
	}
	
	function has_access($content){
		//Roles:: 1-Admin; 2-Attendant; 3-Chef; 5-SuperAdmin
		
		$grant_access = false;
		
		switch($content){
			case 'order':
				if($_SESSION['role_id'] == 1)  		// Admin
					$grant_access = false;
				elseif($_SESSION['role_id'] == 2) 	// Attendant
					$grant_access = true;
				elseif($_SESSION['role_id'] == 3) 	// Chef
					$grant_access = false;
				elseif($_SESSION['role_id'] == 5)	// SuperAdmin
					$grant_access = true;
				else														// None of the above
					$grant_access = false;
				break;
			case 'bill':
				if($_SESSION['role_id'] == 1)  		// Admin
					$grant_access = false;
				elseif($_SESSION['role_id'] == 2) 	// Attendant
					$grant_access = true;
				elseif($_SESSION['role_id'] == 3) 	// Chef
					$grant_access = false;
				elseif($_SESSION['role_id'] == 5)	// SuperAdmin
					$grant_access = true;
				else														// None of the above
					$grant_access = false;
				break;
			case 'feedback':
				if($_SESSION['role_id'] == 1)  		// Admin
					$grant_access = false;
				elseif($_SESSION['role_id'] == 2) 	// Attendant
					$grant_access = true;
				elseif($_SESSION['role_id'] == 3) 	// Chef
					$grant_access = false;
				elseif($_SESSION['role_id'] == 5)	// SuperAdmin
					$grant_access = true;
				else														// None of the above
					$grant_access = false;
				break;
			case 'chef':
				if($_SESSION['role_id'] == 1)  		// Admin
					$grant_access = false;
				elseif($_SESSION['role_id'] == 2) 	// Attendant
					$grant_access = false;
				elseif($_SESSION['role_id'] == 3) 	// Chef
					$grant_access = true;
				elseif($_SESSION['role_id'] == 5)	// SuperAdmin
					$grant_access = true;
				else														// None of the above
					$grant_access = false;
				break;
			case 'dashboard':
				if($_SESSION['role_id'] == 1)  		// Admin
					$grant_access = true;
				elseif($_SESSION['role_id'] == 2) 	// Attendant
					$grant_access = false;
				elseif($_SESSION['role_id'] == 3) 	// Chef
					$grant_access = false;
				elseif($_SESSION['role_id'] == 5)	// SuperAdmin
					$grant_access = true;
				else														// None of the above
					$grant_access = false;
				break;
			case 'restaurant':
				if($_SESSION['role_id'] == 1)  		// Admin
					$grant_access = false;
				elseif($_SESSION['role_id'] == 2) 	// Attendant
					$grant_access = false;
				elseif($_SESSION['role_id'] == 3) 	// Chef
					$grant_access = false;
				elseif($_SESSION['role_id'] == 5)	// SuperAdmin
					$grant_access = true;
				else														// None of the above
					$grant_access = false;
				break;
			case 'menu':
				if($_SESSION['role_id'] == 1)  		// Admin
					$grant_access = true;
				elseif($_SESSION['role_id'] == 2) 	// Attendant
					$grant_access = false;
				elseif($_SESSION['role_id'] == 3) 	// Chef
					$grant_access = false;
				elseif($_SESSION['role_id'] == 5)	// SuperAdmin
					$grant_access = true;
				else														// None of the above
					$grant_access = false;
				break;
			case 'users':
				if($_SESSION['role_id'] == 1)  		// Admin
					$grant_access = true;
				elseif($_SESSION['role_id'] == 2) 	// Attendant
					$grant_access = false;
				elseif($_SESSION['role_id'] == 3) 	// Chef
					$grant_access = false;
				elseif($_SESSION['role_id'] == 5)	// SuperAdmin
					$grant_access = true;
				else														// None of the above
					$grant_access = false;
				break;
			default:
				$grant_access = false;
				break;
		}		
		
		return $grant_access;
	}

	function get_theme_colors(){
		$all = array();

		$sql = "SELECT theme_id, theme_name, color_code_hex
					 FROM tbl_themes";

		try{
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$stmt->bind_result($theme_id, $theme_name, $color_code_hex);

			while ($stmt->fetch()) {
				$tmp = array();
				$tmp['theme_id'] = $theme_id;
				$tmp['theme_name'] = $theme_name;
				$tmp['theme_hex'] = $color_code_hex;
				array_push($all, $tmp);
			}

			$stmt->close();

			return array_filter($all);
		}
		catch (Exception $e) {
			die ('Error: '.$e->message());
		}
	}
	
	function time_elapsed_string($datetime, $full = false) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
}
