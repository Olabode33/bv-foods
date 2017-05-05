<?php
/**
* 
*/

	class Dashboard
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
		
		function getQuickFacts(){
			
		}
		
		function randomLabel() {
			$random_label = array();
			
			for($i=0; $i<10; $i++){
				$random_label[$i] = $this->util_obj->random_string();
			}
			
			return array_filter($random_label);
		}
		
		function randomDataPoint() {
			$random_data_points = array();
			
			for($i = 0; $i<10; $i++){
				$random_data_points[$i] = rand(1, 100);
			}
			
			return array_filter($random_data_points);
		}
		
		function getDataForQuestion($question_id, $age_filter='none', $gender_filter='none') {
			$restaurant_id = 0;
			
			if(isset($_SESSION['restaurant_id']))
				$restaurant_id = $_SESSION['restaurant_id'];
			
			$data = array();
			$labels = array();
			$points = array();
			$totals = array();
			
			// if($_SESSION['role_id'] == 5){
				// $sql = "SELECT option_choice, count(r.option_id) as 'freq', sum(r.option_id) as 'sum'
							 // FROM tbl_option_choices oc
								// LEFT JOIN tbl_option_groups og ON oc.option_group_id = og.option_group_id
								// LEFT JOIN tbl_questions q ON og.option_group_id = q.option_group_id
								// LEFT OUTER JOIN tbl_responses r ON q.question_id = r.question_id and oc.option_value = r.option_id 
								// ".($age_filter != 'none'?' and r.age_group_id = ? ': ' ')." 
								// ".($gender_filter != 'none'? ' and r.gender = ? ': ' ')."
							 // WHERE q.question_id = ?
							 // GROUP BY option_value
							 // ORDER BY option_value";
			// }
			// else 
				$sql = "SELECT option_choice, count(r.option_id) as 'freq', sum(r.option_id) as 'sum'
							 FROM tbl_option_choices oc
								LEFT JOIN tbl_option_groups og ON oc.option_group_id = og.option_group_id
								LEFT JOIN tbl_questions q ON og.option_group_id = q.option_group_id 
								LEFT OUTER JOIN tbl_responses r ON q.question_id = r.question_id and oc.option_value = r.option_id and r.restaurant_id = ?
								".($age_filter != 'none'?' and r.age_group_id = ? ': ' ')." 
								".($gender_filter != 'none'? ' and r.gender = ? ': ' ')."
							 WHERE q.question_id = ? 
							 GROUP BY option_value
							 ORDER BY option_value";
						 
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			
			// if($_SESSION['role_id'] == 5){
				// if($age_filter != 'none' && $gender_filter == 'none')
					// $stmt->bind_param('dd', $age_filter, $question_id);
				// elseif($gender_filter != 'none' && $age_filter == 'none')
					// $stmt->bind_param('sd', $gender_filter, $question_id);
				// elseif($age_filter != 'none' && $gender_filter != 'none')
					// $stmt->bind_param('dsd', $age_filter, $gender_filter, $question_id);
				// else
					// $stmt->bind_param('d', $question_id);
			// }
			// else {
				if($age_filter != 'none' && $gender_filter == 'none')
					$stmt->bind_param('ddd', $restaurant_id, $age_filter, $question_id);
				elseif($gender_filter != 'none' && $age_filter == 'none')
					$stmt->bind_param('dsd', $restaurant_id, $gender_filter, $question_id);
				elseif($age_filter != 'none' && $gender_filter != 'none')
					$stmt->bind_param('ddsd', $restaurant_id, $age_filter, $gender_filter, $question_id);
				else
					$stmt->bind_param('dd', $restaurant_id, $question_id);
			//}
							
			$stmt->execute();
			$stmt->bind_result($option, $freq, $total);
			
			while($stmt->fetch()){
				//echo $option.' '.$freq.' '.$total;
				array_push($labels, $option);
				array_push($points, $freq);
				array_push($totals, $total);
			}
			
			$percentage = array();
			
			//Get sum & average
			$sum = array_sum($totals);
			
			if(array_sum($points) == 0)
				$avg = 0;
			else
				$avg = $sum / array_sum($points);
			
			$max_label = '';
			$max_point = 0;
			
			//Get Max point
			$count = 0;
			$max_point = max($points);
			
			//Get index for max point
			$max_index  = 0;
			foreach($points as $point){
				if($max_point == $point)
					$max_index = $count;
				$count++;
			}
			//Get label for max point
			$max_label = $labels[$max_index];
			
			//Calculate Pertage
			foreach($points as $point){
				if(array_sum($points) == 0)
					$percent = 0;
				else
					$percent = number_format(($point/array_sum($points)) * 100, 1);
				
				array_push($percentage, $percent);
			}
			
			//Build return array
			$data['labels'] = $labels;
			$data['points'] = $percentage;
			$data['max_label'] = $max_label;
			$data['max_point'] = $max_point;
			$data['avg'] = round($avg);
			
			$stmt->close();
			
			return array_filter($data);
		}
		
		function getDashboardSummary(){
			$summary = array();
			
			$time = array();
			$quality = array();
			$customer = array();
			
			//build time
			$time_data[0] = $this->getDataForQuestion(3);
			$time_data[1] = $this->getDataForEstimatedTime();
			
			$quality_data[0] = $this->getDataForQuestion(4);
			$quality_data[1] = $this->getDataForQuestion(5);
			$quality_data[2] = $this->getDataForQuestion(7);
			$quality_data[3] = $this->getDataForQuestion(9);
			
			$customer_data[0] = $this->getDataForQuestion(11);
			$customer_data[1] = $this->getDataForQuestion(12);
			$customer_data[2] = $this->getDataForQuestion(15);
			$customer_data[3] = $this->getDataForQuestion(16);
			
			$time['waittime_max_l'] = isset($time_data[0]['max_label'])?$time_data[0]['max_label']:0;
			$time['waittime_max_p'] = isset($time_data[0]['max_point'])?$time_data[0]['max_point']:0;
			$time['etime'] = isset($time_data[1]['etime'])?$time_data[1]['etime']:0;
			$time['atime'] = isset($time_data[1]['atime'])?$time_data[1]['atime']:0;
			$time['avg'] = $this->summaryAvg($time_data);
			
			$quality['avg'] = $this->summaryAvg($quality_data);
			$quality['attendant_max_l'] =  isset($customer_data[0]['max_label'])?$customer_data[0]['max_label']:0;
			$quality['attendant_max_p'] =  isset($customer_data[0]['max_point'])?$customer_data[0]['max_point']:0;
			$quality['employee_max_l'] =  isset($customer_data[1]['max_label'])?$customer_data[1]['max_label']:0;
			$quality['employee_max_p'] = isset( $customer_data[1]['max_point'])?$customer_data[1]['max_point']:0;
			$quality['customer_max_l'] =  isset($customer_data[2]['max_label'])?$customer_data[2]['max_label']:0;
			$quality['customer_max_p'] =  isset($customer_data[2]['max_point'])? $customer_data[2]['max_point']: 0;
			$quality['meal_max_l'] =  isset($customer_data[3]['max_label'])?$customer_data[3]['max_label']:0;
			$quality['meal_max_p'] =  isset($customer_data[3]['max_point'])?$customer_data[3]['max_point']:0;
			
			$customer['avg'] = $this->summaryAvg($customer_data);
			$customer['beverage_max_l'] =  isset($quality_data[0]['max_label'])?$quality_data[0]['max_label']:0;
			$customer['beverage_max_p'] =  isset($quality_data[0]['max_point'])?$quality_data[0]['max_point']:0;
			$customer['food_max_l'] =  isset($quality_data[0]['max_label'])?$quality_data[0]['max_label']:0;
			$customer['food_max_p'] =  isset($quality_data[0]['max_point'])?$quality_data[0]['max_point']:0;
			$customer['value_max_l'] =  isset($quality_data[0]['max_label'])?$quality_data[0]['max_label']:0;
			$customer['value_max_p'] =  isset($quality_data[0]['max_point'])?$quality_data[0]['max_point']:0;
			$customer['ambassador_max_l'] =  isset($quality_data[0]['max_label'])?$quality_data[0]['max_label']:0;
			$customer['ambassador_max_p'] =  isset($quality_data[0]['max_point'])?$quality_data[0]['max_point']:0;
			
			$summary['time'] = $time;
			$summary['quality'] = $quality;
			$summary['customer'] = $customer;
			
			return array_filter($summary);
		}
		
		function summaryAvg($array_data){
			$avg = 0;
			$sum = 0;

			foreach($array_data as $data){
				$sum += (isset($data['avg'])?$data['avg']:0);
			}
			
			$avg = $sum/count($array_data);
			
			return round($avg);
		}
	
		function getDataForEstimatedTime(){
			$data = array();
			
			$restaurant_id = 0;
			
			if(isset($_SESSION['restaurant_id']))
				$restaurant_id = $_SESSION['restaurant_id'];
			
			// if($_SESSION['role_id'] == 5){
				// $sql = "SELECT avg(etime) as 'etime', avg(atime) as 'atime'
							 // FROM (
							 	// SELECT restaurant_id, order_key, max(served_date), max(order_date), max(estimated_d_time) as 'etime', 
											// cast((time_to_sec(timediff(max(served_date), max(order_date)))/60) as decimal(5,0)) as 'atime',  
											// timediff(max(served_date), max(order_date))
								// FROM restaurants.tbl_orders
								// WHERE order_status_id > 2 AND estimated_d_time IS NOT NULL
								// GROUP BY order_key 
							 // ) x";
			// }
			// else 
				$sql = "SELECT  avg(etime) as 'etime', avg(atime) as 'atime', order_date
							 FROM (
								SELECT restaurant_id, order_key, max(served_date), max(order_date) as order_date, max(estimated_d_time) as 'etime', 
											cast((time_to_sec(timediff(max(served_date), max(order_date)))/60) as decimal(5,0)) as 'atime',  
											timediff(max(served_date), max(order_date))
								FROM restaurants.tbl_orders
								WHERE order_status_id > 2 AND estimated_d_time IS NOT NULL
								GROUP BY order_key 
							 ) x
							 WHERE restaurant_id = ? and datediff(now(), order_date) <= 30";
						 
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			
			// if($_SESSION['role_id'] == 5){
				//$stmt->bind_param('d', $restaurant_id);
			// }
			// else {
				$stmt->bind_param('d', $restaurant_id);
			// }
							
			$stmt->execute();
			$stmt->bind_result($etime, $atime, $date);
			
			while($stmt->fetch()){
				$data['etime'] = $etime;
				$data['atime'] = $atime;
				$data['date'] = $date;
			}
			
			$data['avg'] = ($data['etime']> $data['atime'])?5:($data['etime'] < $data['atime'])?1:3;
			
			return array_filter($data);
		}
		
		function getDetailsForEstimatedTime(){
			$data = array();
			
			$etime_arr = array();
			$atime_arr = array();
			$date_arr = array();
			
			$restaurant_id = 0;
			
			if(isset($_SESSION['restaurant_id']))
				$restaurant_id = $_SESSION['restaurant_id'];
			
			$sql = "SELECT  avg(etime) as 'etime', avg(atime) as 'atime', date(order_date)
						 FROM (
							SELECT restaurant_id, order_key, max(served_date), max(order_date) as 'order_date', max(estimated_d_time) as 'etime', 
										cast((time_to_sec(timediff(max(served_date), max(order_date)))/60) as decimal(5,0)) as 'atime',  
										timediff(max(served_date), max(order_date))
							FROM restaurants.tbl_orders
							WHERE order_status_id > 2 AND estimated_d_time IS NOT NULL
							GROUP BY order_key 
						 ) x
						 WHERE restaurant_id = ? and datediff(now(), order_date) <= 30
						 GROUP BY day(order_date)
						 ORDER BY order_date";
						 
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('d', $restaurant_id);							
			$stmt->execute();
			$stmt->bind_result($etime, $atime, $date);
			
			while($stmt->fetch()){
				array_push($etime_arr, $etime);
				array_push($atime_arr, $atime);
				array_push($date_arr, $date);
			}
			
			$data['etime'] = $etime_arr;
			$data['atime'] = $atime_arr;
			$data['date'] = $date_arr;
			
			return array_filter($data);
		}
		
	}
	
?>
