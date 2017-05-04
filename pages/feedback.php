<?php
	include_once 'app/cls-survey.php';
	include_once 'utility/utility.php';

	$util_obj = new Utility();
	$survey_obj = new Survey();

	$surveys = $survey_obj->getSurveys();
	 ///echo $surveys[0]['survey_id'];
	 
	 $s_index = 0;
	 if(isset($_GET['s']))
		 $s_index = $_GET['s']++;
	 
	 //echo $s_index;
	 
	 if(isset($_POST['q']) && $_POST['q'] == 'submit'){
		 $rows = $survey_obj->recordResponse();
		 
		 if($rows > 0){
			 // $_SESSION['feedback'] = '<div class="alert alert-dismissible alert-success">
																// <button type="button" class="close" data-dismiss="alert">&times;</button>
																// Response recorded.
															  // </div>';
				header('Location: index.php?a=message&m=feedback');
				//echo '<script></script>';
		 }
		 else {
			 $_SESSION['feedback'] = '<div class="alert alert-dismissible alert-danger">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																Error recording response.
															  </div>';
				header('Location: index.php?a=survey');
		 }
	 }
	 
	$questions = $survey_obj->getQuestions($surveys);		
	echo '';
?>
<div class="container page">
	<div class="">
		<img src="assets/icons/extra_set/clipboard.svg" height="70px" class="pull-left"/>
	</div><br>
	<h3><?php echo 'Feedback';//$question['survey']; ?></h3>
	<div class="<?php echo $theme_color; ?> line"></div>
	<div class="">
		<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?a=feedback&s='.$s_index; ?>" method="post" enctype="application/x-www-form-urlencoded" name="form" id="form">
			<fieldset>
				<br>
				<div class="form-group">
					<label class="col-sm-2">Age Group</label>
					<div class="col-sm-2">
						<select id="age" name="age" class="form-control input-sm" required="true">
							<option value="">- Select an Option -</option>
							<option value="1"><12</option>
							<option value="2">13 - 19</option>
							<option value="3">20 - 40</option>
							<option value="4">41 - 58</option>
							<option value="5">>59</option>
						</select>
					</div>
					<div class="col-sm-4">
						&nbsp;
					</div>
					<label class="col-sm-1">Gender</label>
					<div class="col-sm-1">
						<input type="radio" value="M" name="gender" required="true"> Male <span class="fa fa-male <?php echo $theme_text; ?>"></span>
					</div>
					<div class="col-sm-2">
						<input type="radio" value="F" name="gender" required="true"> Female <span class="fa fa-female <?php echo $theme_text; ?>"></span>
					</div>
				</div>
			</fieldset>
			<hr>
			<?php
				$count = 1;
				foreach ($questions as $question){
					echo '<fieldset>';
								// <legend>&nbsp;';
								//	.$question['subgroup'];
					// echo '</legend>';

						echo '<div class="form-group">';
						echo '<label class="col-sm-10">'.$question['question'].'</label>
									<input type="hidden" name = "q'.$count.'_id" id = "q'.$count.'_id" value = "'.$question['question_id'].'">
									<div class="col-sm-10">';
										$opts = $survey_obj->getOptions($question['option_group']);
										//print_r($opts);
										if($question['option_group'] == 1 || $question['option_group'] == 5){
											echo '<div class="GF_contentContainer">
														<div class="GF_labelColumn">
															<div class="GF_labelPlaceholder"></div>
															<div class="GF_labelContainer">
																<div class="GF_contentRangeLabel">
																	'.$opts['0']['opt'].'
																</div>
															</div>
														</div>';
											foreach($opts as $opt){
												//echo '<pre>';print_r($opt);echo '</pre>';
												echo '<label class="GF_contentColumn">
															<div class="GF_contentLabel">'.$opt['opt_value'].'&nbsp;&nbsp;</div>
															<div class="GF_contentInput">
																<div class="radio radio-info radio-inline">
																	<input type="'.$question['type'].'" name="'.((isset($question['multiple']) && $question['multiple'] == 1)?'q'.$count.'_opt[]':'q'.$count.'_opt').'" value="'.$opt['opt_value'].'">
																</div>
															</div>
														 </label>';
											}
											
											echo '	<div class="GF_labelColumn">
															<div class="GF_labelPlaceholder"></div>
															<div class="GF_labelContainer">
																<div class="GF_contentRangeLabel">
																	'.$opts['4']['opt'].'
																</div>
															</div>
														</div>
													</div>';
										}
										else {
											foreach($opts as $opt){
												echo '<div class="'.$question['type'].'">&nbsp;&nbsp;
															<label>
																<input type="'.$question['type'].'" name="'.((isset($question['multiple']) && $question['multiple'] == 1)?'q'.$count.'_opt[]':'q'.$count.'_opt').'" value="'.$opt['opt_value'].'">
																'.$opt['opt'].'
															</label>
														 </div>';
											}
										}
						echo  	'</div>
								 </div>';
					
					echo '</fieldset><hr>';
					$count++;
				}
			?>			
				
				<div class="form-group">
		        	<div class="col-sm-12">
		            	<button type="reset" class="btn btn-default btn-sm" <?php echo $theme_color; ?>><i class="glyphicon glyphicon-erase"></i> Clear</button>
		                <button type="submit" class="btn btn-primary btn-sm <?php echo $theme_color; ?>" name="q" value="submit">Submit <i class="fa fa-send"></i></button>
					</div>
				</div>
		</form>
	</div>
</div>
	
<?php
//}
?>
