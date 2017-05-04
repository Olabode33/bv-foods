<?php 
	include 'app/cls-restaurant.php';
	include 'app/cls-order.php';
	include 'utility/utility.php';
	$utility_obj = New Utility();
	$order_obj = New Order();
	$restaurant_obj = New Restaurant();
	
	if(isset($_GET['drid'])){
		$rows = $restaurant_obj->remove_restaurant($_GET['drid']);
		//echo $rows
		if($rows > 0){
			$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-success">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>'.$rows.'</strong> record deleted.
														  </div>';
			header('Location: index.php?a=cms&s=restaurants');
		}
		elseif($rows == -1){
			$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-danger">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>Record cannot be deleted</strong> <br>
																Please delete menu items first.
														  </div>';
			header('Location: index.php?a=cms&s=restaurants');
		}
		else{
			$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-warning">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>'.$rows.'</strong> record deleted.
														  </div>';
			header('Location: index.php?a=cms&s=restaurants');
		}
		
	}
	
?>
<h3><span class="fa fa-cutlery"></span> Restaurants</h3>
<div class="<?php echo $theme_color; ?> line"></div>	
<a class="btn btn-primary btn-sm pull-right <?php echo $theme_color; ?>" href="index.php?a=actions"><span class="fa fa-reply"></span> Back</a>
<a class="btn btn-primary btn-sm <?php echo $theme_color; ?>" href="index.php?a=cms&s=restaurant-new"><span class="fa fa-plus"></span> Add New Restaurant</a><br>
<table class="table table-hover">
	<thead>
		<th class="col-xs-1 col-sm-1">S/n</th>
		<th class="col-xs-3 col-sm-3">Restaurants</th>
		<th class="col-xs-2 col-sm-2">State</th>
		<th class="col-xs-2 col-sm-2">Phone</th>
		<th class="col-xs-2 col-sm-2">E-Mail</th>
		<th class="col-xs-3 col-sm-3">Actions</th>
	</thead>
	<tbody>
	<?php 
		$restaurants = $restaurant_obj->getAll();
		$count = 1;
		
		foreach($restaurants as $restaurant){
			echo '<tr>
						<td>'.$count.'</td>
						<td>'.$restaurant['restaurant'].'</td>
						<td>'.$restaurant['state'].'</td>
						<td>'.$restaurant['phone'].'</td>
						<td>'.$restaurant['email'].'</td>
						<td>
							<a href="index.php?a=cms&s=restaurant-view&rid='.$restaurant['id'].'" class="btn btn-sm btn-primary '.$theme_color.'"><span class="fa fa-eye"></span> View</a>
							<a href="index.php?a=cms&s=restaurant-new&rid='.$restaurant['id'].'" class="btn btn-sm btn-primary '.$theme_color.'"><span class="fa fa-pencil"></span> Edit</a>
							<!--a href="index.php?a=cms&s=restaurants&drid='.$restaurant['id'].'" class="btn btn-sm btn-primary '.$theme_color.'"><span class="fa fa-trash"></span> Delete</a-->
							<button class="btn btn-sm btn-primary '.$theme_color.'" data-toggle="modal" data-target="#deleteItem" data-title="Delete Restaurant" 
								data-msg="Are you sure you want to delete the restaurant '.$restaurant['restaurant'].'?" 
								data-link="index.php?a=cms&s=restaurants&drid='.$restaurant['id'].'">
								<span class="fa fa-trash"></span> Delete
							</button>
						</td>
					</tr>';
					
			$count++;
		}
	?>
	</tbody>
</table>