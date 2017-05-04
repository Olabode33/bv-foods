<?php
	/**
	* By Olabodde33
	*/
	class DBConfig
	{
		function __construct(){}

		function db_connect($user='bvuser', $password='bvUserP@ss', $db='bvfoods_db')
		{
			$conn = mysqli_connect('127.0.0.1', $user, $password);
			if(!$conn) {
				return 'Error connecting to database'; 
			}
			mysqli_select_db($conn, $db);
			date_default_timezone_set("Africa/Lagos");
			
			return $conn;
		}

		function getObjId($id_col, $table, $obj_col, $obj)
		{
			$sql = "SELECT ".$id_col." FROM ".$table." WHERE ".$obj_col." = ?";

			try {
				$conn = $this->db_connect();
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('s', $obj);
				$stmt->execute();
				$stmt->bind_result($id);
				
				While($stmt->fetch()){
					return $id;
				}

				$stmt->close();
			}
			catch (Exception $e){
				print_r($e);
			}
		}

	}
?>
