<?php 
	include 'utility/utility.php';
	$utility_obj = New Utility();
	
	$stp = 1;
	if(isset($_GET['stp'])) {
		$stp = $_GET['stp'];
		$mode = $_GET['m'];
	}

	if(isset($_SESSION['table_id'])){
		unset($_SESSION['table_id']);
		unset($_SESSION['table']);
		header ('Location: index.php?a=actions');
		// echo "<script type='text/javascript'>
						// document.location.href='index.php?a=actions';
				  // </script>";
	}
echo '<div class="container page">';
	echo '<div class="">
				<br>
				<img src="assets/icons/restaurant_set/restaurant.svg" height="50px" class="pull-left"/>
			</div>';
	echo '<h3 >&nbsp;Actions</h3>
                  <div class="'.$theme_color.' line"></div>';
				  
	echo '<div class="row">';
				if($utility_obj->has_access('order'))
					echo '<div class="col-xs-4 col-sm-3 col-md-2">
								<a class="btn btn-custom btn-lg btn-block" href="index.php?a=tables&for=order">
									<div class="action-icon">
										<img src="assets/icons/restaurant_set/dish.svg" height="50px"/>
									</div>
									Orders
								</a>
							</div>';
							
				if($utility_obj->has_access('bill'))
					echo '<div class="col-xs-4 col-sm-3 col-md-2">
								<a class="btn btn-custom btn-lg btn-block" href="index.php?a=tables&for=bill">    
									<div class="action-icon">
										<img src="assets/icons/restaurant_set/bill-1.svg" height="50px"/>
									</div>
									Bills
								</a>
							</div>';
							
				if($utility_obj->has_access('feedback'))
					echo '<div class="col-xs-4 col-sm-3 col-md-2">
								<a class="btn btn-custom btn-lg btn-block" href="index.php?a=feedback">
									<div class="action-icon">
										<img src="assets/icons/extra_set/clipboard.svg" height="50px"/>
									</div>
									Feedback
								</a>
							</div>';
	echo '</div>';

	if($utility_obj->has_access('order') || $utility_obj->has_access('bill') || $utility_obj->has_access('feedback'))
         echo '<hr>';

	echo '<div class="row">';
				if($utility_obj->has_access('chef'))
					echo '<div class="col-xs-4 col-sm-3 col-md-2">
								<a class="btn btn-custom btn-lg btn-block" href="index.php?a=bar">
									<div class="action-icon">
										<img src="assets/icons/restaurant_set/chef.svg" height="50px"/>
									</div>
									Bar/Chef
								</a>
							</div>';
				
				if($utility_obj->has_access('dashboard'))
					echo '<div class="col-xs-4 col-sm-3 col-md-2">
								<a class="btn btn-custom btn-lg btn-block" href="index.php?a=cms&s=dashboard">
									<div class="action-icon">
										<img src="assets/icons/restaurant_set2/app.svg" height="50px"/>
									</div>
									Dashboard
								</a>
							</div>';
	echo '</div>';
	
	if($utility_obj->has_access('chef') || $utility_obj->has_access('dashboard'))
		echo '<hr>';

	echo '<div class="row">';
				if($utility_obj->has_access('restaurant'))
					echo '<div class="col-xs-4 col-sm-3 col-md-2">
								<a class="btn btn-custom btn-lg btn-block" href="index.php?a=cms&s=restaurants">
									<div class="action-icon">
										<img src="assets/icons/restaurant_set/open.svg" height="50px"/>
									</div>
									Restaurants
								</a>
							</div>';
							
				if($utility_obj->has_access('menu'))
					echo '<div class="col-xs-4 col-sm-3 col-md-2">
								<a class="btn btn-custom btn-lg btn-block" href="index.php?a=cms&s=menu">
									<div class="action-icon">
										<img src="assets/icons/restaurant_set/menu.svg" height="50px"/>
									</div>
									Menus
								</a>
							</div>';
							
				if($utility_obj->has_access('users'))
					echo '<div class="col-xs-4 col-sm-3 col-md-2">
								<a class="btn btn-custom btn-lg btn-block" href="index.php?a=cms&s=user">
									<div class="action-icon">
										<img src="assets/icons/restaurant_set/waiter.svg" height="50px"/>
									</div>
									Users
								</a>
							</div>';
	echo '</div>';
	
	if($utility_obj->has_access('restaurant') || $utility_obj->has_access('menu') || $utility_obj->has_access('users'))
		echo '<hr>';

echo '</div>';