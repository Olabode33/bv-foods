<?php
	include 'app/cls-restaurant.php';
	include 'app/cls-order.php';
	include 'utility/utility.php';
	$utility_obj = New Utility();
	$order_obj = New Order();
	$restaurant_obj = New Restaurant();

	$rid = 0;
	if(isset($_GET['rid'])){
		$rid = $_GET['rid'];
		$restaurants_details = $restaurant_obj->getAll($rid);
		$restaurant_details = $restaurants_details[0];
	}
	
	if(isset($_GET['drid'])){
		$rows = $restaurant_obj->remove_table($_GET['drid']);
		//echo $rows
		if($rows > 0){
			$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-success">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>'.$rows.'</strong> records deleted.
														  </div>';
			header('Location: index.php?a=cms&s=restaurant-view&rid='.$rid);
		}
		else{
			$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-warning">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>'.$rows.'</strong> records deleted.
														  </div>';
			header('Location: index.php?a=cms&s=restaurant-view&rid='.$rid);
		}
		
	}
	
?>
<h3><span class="fa fa-cutlery"></span> Restaurant's Tables</h3>
<div class="<?php echo $theme_color; ?> line"></div>	
<p style="width: 100%">
	<a class="btn btn-sm btn-primary pull-right <?php echo $theme_color; ?>" href="index.php?a=cms&s=restaurants"><span class="fa fa-reply"></span> Go Back</a> 
	<span class="pull-right">&nbsp;</span>
	<a class="btn btn-sm btn-primary pull-right <?php echo $theme_color; ?>" href="index.php?a=cms&s=table-new&rid=<?php echo $rid; ?>"><span class="fa fa-plus-square-o"></span> Add Table</a><br>
</p>


<div class="row">
	<div class="col-md-4">
		<h4>Restaurant Details:</h4>
		<h5>Name: <span class="<?php echo $theme_text; ?>"><?php echo $restaurant_details['restaurant']?></h5>
		<?php
			if($restaurant_details['logo'])
				echo '<img src="assets/images/restaurants-logo/'.$restaurant_details['logo'].'" class="img-thumbnail img-rounded" width="45%"/>';
			else
				echo '<br>-- No Logo --<br><br>';
			
			echo '<h5>'.$restaurant_details['address'].'</h5>';
			echo '<h5>'.$restaurant_details['region'].'</h5>';
			echo '<h5>'.$restaurant_details['state'].', Nigeria.</h5>';
			echo '<h5><span class="fa fa-phone"></span> '.$restaurant_details['phone'].'</h5>';
			echo '<h5><span class="fa fa-envelope"></span> '.$restaurant_details['email'].'</h5>';
			
			if($restaurant_details['bg_image'])
				echo '<img src="assets/images/restaurants-bg/'.$restaurant_details['bg_image'].'" class="img-thumbnail img-rounded" width="75%"/>';
			else
				echo '<br>-- No Back --<br>';
		?>		
	</div>

	<div class="col-md-8">
		<h4>Tables</h4>
		<table class="table table-hover">
			<thead>
				<th class="col-sm-1">S/n</th>
				<th class="col-xs-3">Tables</th>
				<th class="col-xs-2">No. of Seats</th>
				<!--th class="hidden-xs hidden-sm hidden-md">Note</th-->
				<th class="col-xs-3">Actions</th>
			</thead>
			<tbody>
			<?php
				//<td>'.$item['note'].'</td>
			
				$tables = $restaurant_obj->getTables($rid);
				$count = 1;
				
				if(count($tables) > 0){
					foreach($tables as $table){
						echo '<tr>
									<td>'.$count.'</td>
									<td>'.$table['table_name'].'</td>
									<td>'.$table['no_seats'].'</td>
									
									<td>
										<a href="index.php?a=cms&s=table-new&tid='.$table['table_id'].'&rid='.$rid.'" class="btn btn-sm btn-primary '.$theme_color.'"><span class="fa fa-pencil"></span> Edit</a>
										<!--a href="index.php?a=cms&s=restaurant-view&drid='.$table['table_id'].'&rid='.$rid.'" class="btn btn-sm btn-primary '.$theme_color.'"><span class="fa fa-trash"></span> Delete</a-->
										<button class="btn btn-sm btn-primary '.$theme_color.'" data-toggle="modal" data-target="#deleteItem" data-title="Delete Table" 
											data-msg="Are you sure you want to delete the table '.$table['table_name'].'?" 
											data-link="index.php?a=cms&s=restaurant-view&drid='.$table['table_id'].'&rid='.$rid.'">
											<span class="fa fa-trash"></span> Delete
										</button>
									</td>
								 </tr>';
						
						$count++;
					}
				}
				else {
					echo '<tr><td colspan="4">No tables has been created for this restaurant. <br>Click the Add Table button to add tables</td></tr>';
				}
			?>
				
			</tbody>
		</table>
	</div>
</div>