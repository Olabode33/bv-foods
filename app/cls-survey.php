<?php
/**
* 
*/
class Survey
{
	private $db_obj;
	function __construct()
	{
		require_once '/../utility/db.php';
		$this->db_obj = new DBConfig();
	}
	
	function getSurveys() {
		$all = array();
		
		$sql = "SELECT survey_id, survey_name, instruction
					 FROM tbl_survey
					 ORDER BY rand()";

		try{
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$stmt->bind_result($id, $survey, $instruction);

			while ($stmt->fetch()) {
				$tmp = array();
				$tmp['survey_id'] = $id;
				$tmp['title'] = $survey;
				$tmp['instruction'] = $instruction;
				
				array_push($all, $tmp);
			}
			$stmt->close();
			return array_filter($all);
		}
		catch (Exception $e) {
			die ('Error: '.$e->message());
		}
	}
	
	function getQuestion($sid){
		$all = array();
		
		$sql = "SELECT s.survey_id, survey_name, ssg.subgroup_id, subgroup_title, question_id, question, input_type, required, q.option_group_id, allow_multiple_options
					 FROM tbl_survey s
						LEFT JOIN tbl_survey_subgroup ssg ON s.survey_id = ssg.survey_id
						LEFT JOIN tbl_questions q ON ssg.subgroup_id = q.subgroup_id
						LEFT JOIN tbl_input_types it ON q.input_type_id = it.input_type_id
						WHERE s.survey_id = ?
						ORDER BY rand()
						LIMIT 1";
						
		try{
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('d', $sid);
			$stmt->execute();
			$stmt->bind_result($sid, $survey, $sub_id, $subgroup, $qid, $question, $input_type, $require, $option_group, $multiple);

			while ($stmt->fetch()) {
				//$all = array();
				$all['survey_id']  = $sid;
				$all['survey'] = $survey;
				$all['sub_id'] = $sub_id;
				$all['subgroup'] = $subgroup;
				$all['question_id'] = $qid;
				$all['question'] = $question;
				$all['type'] = $input_type;
				$all['required'] = $require;
				$all['option_group'] = $option_group;
				$all['multiple'] = $multiple;
				
				//array_push($all, $tmp);
			}
			$stmt->close();
			return array_filter($all);
		}
		catch (Exception $e) {
			die ('Error: '.$e->message());
		}

	}

	function getOptions($optgroup){
		$all =array();
		
		$sql = "SELECT option_choice_id, option_choice, option_value
					 FROM tbl_option_choices
					 WHERE option_group_id = ?";
					 
		try {
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('d', $optgroup);
			$stmt->execute();
			$stmt->bind_result($opt_id, $opt_choice, $opt_value);
			
			while($stmt->fetch()){
				$tmp = array();
				$tmp['opt_id'] = $opt_id;
				$tmp['opt'] = $opt_choice;
				$tmp['opt_value'] = $opt_value;
				
				array_push($all, $tmp);
			}
			
			$stmt->close();
			
			return array_filter($all);
		}
		catch (Exception $e){
			die('Error: '.$e->message());
		}
	}

	function recordResponse(){
		$affected_rows = 0;
		
		$age = FILTER_INPUT(INPUT_POST, 'age');
		$gender = FILTER_INPUT(INPUT_POST, 'gender');
		$q1_id = FILTER_INPUT(INPUT_POST, 'q1_id');
		$q1_opt = FILTER_INPUT(INPUT_POST, 'q1_opt');
		$q2_id = FILTER_INPUT(INPUT_POST, 'q2_id');
		$q2_opt = FILTER_INPUT(INPUT_POST, 'q2_opt');
		$q3_id = FILTER_INPUT(INPUT_POST, 'q3_id');
		$q3_opt = FILTER_INPUT(INPUT_POST, 'q3_opt');
		
		$sql = "INSERT INTO tbl_responses (restaurant_id, table_id, question_id, option_id, age_group_id, gender)
					  VALUES (?, ?, ?, ?, ?, ?)";
					  
		try {
			$conn = $this->db_obj->db_connect();
			$stmt = $conn->prepare($sql);
			
			if (is_array($q1_opt)){
				foreach($q1_opt as $id=>$value){
					$stmt->bind_param('ddddds', $_SESSION['restaurant_id'], $_SESSION['table_id'], $q1_id, $value, $age, $gender);
					$stmt->execute();
				}
			}
			else {
				$stmt->bind_param('ddddds', $_SESSION['restaurant_id'], $_SESSION['table_id'], $q1_id, $q1_opt, $age, $gender);
				$stmt->execute();
			}
			
			if (is_array($q2_opt)){
				foreach($q2_opt as $id=>$value){
					$stmt->bind_param('ddddds', $_SESSION['restaurant_id'], $_SESSION['table_id'], $q2_id, $value, $age, $gender);
					$stmt->execute();
				}
			}
			else {
				$stmt->bind_param('ddddds', $_SESSION['restaurant_id'], $_SESSION['table_id'], $q2_id, $q3_opt, $age, $gender);
				$stmt->execute();
			}
			
			if (is_array($q3_opt)){
				foreach($q3_opt as $id=>$value){
					$stmt->bind_param('ddddds', $_SESSION['restaurant_id'], $_SESSION['table_id'], $q3_id, $value, $age, $gender);
					$stmt->execute();
				}
			}
			else {
				$stmt->bind_param('ddddds', $_SESSION['restaurant_id'], $_SESSION['table_id'], $q3_id, $q3_opt, $age, $gender);
				$stmt->execute();
			}
			
			$affected_rows = mysqli_affected_rows($conn);
			
			$stmt->close();
			
			return $affected_rows;
		}
		catch (Exception $e){
			die ('Error: '.$e->message());
		}
		
	}

	function getQuestions($sids){
		$questions = array();
		
		foreach($sids as $sid){
			array_push($questions,  $this->getQuestion($sid['survey_id']));
		}
		
		return array_filter($questions);		
	}
	
}	