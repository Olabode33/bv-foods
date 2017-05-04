<?php 
$stp = 1;
if(isset($_GET['stp'])) {
	$stp = $_GET['stp'];
	$mode = $_GET['m'];
}

// switch ($stp){
	// case 2:
		// switch ($mode) {
			// case 'm':
				// echo '<h3 class="text-primary">Menu Actions</h3>
						 // <a class="btn btn-primary" href="#"><span class="fa fa-plus"></span>Add New Menu</a><br>
						 // <a class="btn btn-primary" href="#"><span class="fa fa-plus"></span>View Available Menu</a><br>';
				// break;
			// case 's':
				// break;
		// }
		// break;
		
	// default :
?>
		<h3 class="text-primary">Available Actions</h3>
		<a class="btn btn-primary" href="index.php?a=cms&s=dashboard"><span class="fa fa-dashboard"></span> Dashboard</a>
		<a class="btn btn-primary" href="index.php?a=cms&s=menu"><span class="fa fa-cutlery"></span> Menu</a>
		<a class="btn btn-primary" href="index.php?a=cms&s=user"><span class="fa fa-users"></span> Users</a>
		<a class="btn btn-primary" href="#" disabled><span class="fa fa-check"></span> Survey</a><br>
		
<?php 
		//break;
//}
?>