<?php
/**
* 
*/
	class Table
	{
		private $db_obj;
		function __construct()
		{
			require_once '/../utility/db.php';
			$this->db_obj = new DBConfig();
		}
		
		function add() {
			$sql = "INSERT INTO ";
		}
		
		function update($table_id) {
			
		}
		
		function remove($table_id) {
			
		}
		
		function getDetails($table_id) {
			
		}
		
		function getAllFor($restaurant_id) {
			$all = array();

			$sql = "SELECT t.table_id, table_name
						 FROM tbl_tables t
							INNER JOIN tbl_restaurant_tables rt ON t.table_id = rt.table_id
						 WHERE restaurant_id = ?";

			try{
				$conn = $this->db_obj->db_connect();
				$stmt = $conn->prepare($sql);
				$stmt->bind_param('s', $restaurant_id);
				$stmt->execute();
				$stmt->bind_result($id, $table);

				while ($stmt->fetch()) {
					$tmp = array();
					$tmp['id'] = $id;
					$tmp['table'] = $table;
					array_push($all, $tmp);
				}

				$stmt->close();

				return array_filter($all);
			}
			catch (Exception $e) {
				die ('Error: '.$e->message());
			}
		}
	}	

?>