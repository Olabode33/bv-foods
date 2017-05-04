<?php
	include 'app/cls-menu.php';
	include 'app/cls-order.php';
	include 'app/cls-restaurant.php';
	include 'utility/utility.php';
	$utility_obj = New Utility();
	$order_obj = New Order();
	$menu_obj = New Menu();
	$restaurant_obj = New Restaurant();
	
	$order_key = 0;
	
	if(isset($_GET['ok'])){
		$order_key = $_GET['ok'];
	}
	
	$restaurants_details = $restaurant_obj->getAll($_SESSION['restaurant_id']);
	
	foreach($restaurants_details as $restaurant_details)
	
	//print_r($restaurant_details);
	// if(isset($_POST['menu']) && $_POST['menu'] == 'remove'){
		// $order_obj->removeFromPlate();
	// }
	
	// if(isset($_POST['order']) && $_POST['order'] == 'update'){
		// if(isset($_POST['qty'])){
			// foreach($_POST['qty']  as $key=>$val){
				// if($val==0) {
					// unset($_SESSION['order'][$key]);
				// }
				// else {
					// $_SESSION['order'][$key]['quantity'] = $val;
					// header('Location: index.php?a=message&m=wait');
				// }
			// }
		// }
		// else {
			// $_SESSION['feedback']
		// }
	// }
	
	// echo "<pre>";
		// print_r($_SESSION['order'][2]);
	// echo "</pre>";
	
	// $array = $_SESSION['order'];
	// foreach ($array as $element){
		// echo "<pre>";
		// print_r($element);
	// echo "</pre>";
	//}
	
	// include_once 'app/cls-projects.php';

	// $prj_obj = new Projects();
	// $prj_obj->scanCategory();
	// $categorys = $prj_obj->getCategorys();

	// if (isset($_GET['delete']) && $_GET['delete'] == 'true') {
		// $deleted_rows = $prj_obj->deleteProject($_GET['id']);
		// if ($deleted_rows > 0) {
			// $_SESSION['feedback'] = '<div class="alert alert-success alert-dismissible">
										// <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										// Project successfully deleted from database.<br>
										// Kindly delete the folder/file.
									 // </div>';
		// }
		// else {
			// $_SESSION['feedback'] = '<div class="alert alert-warning alert-dismissible">
										// <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										// Error deleting project
									 // </div>';
		// }
		// header('Location: index.php?a=view');
	// }
	date_default_timezone_set('Africa/Lagos');
?>
	<div class="container page"-->
		<div class="col-sm-12">
			<h3><i class="fa fa-credit-card"></i> Check Out</h3>
			<div class="<?php echo $theme_color; ?> line"></div><br>
				<span class="pull-left">
					<?php
					if(isset($_SESSION['logo_name']))
						echo '<img src="assets/images/restaurants-logo/'.$_SESSION['logo_name'].'" id="HeaderLogo" class="img-rounded" height="100px" width="auto"/>';
					else
						echo '<br><br><h4>'.((isset($_SESSION['restaurant_id']))?$_SESSION['restaurant']: 'BV Foods').'</h4>';
					?>
				</span><br><br>
				<h4 class="text-right">Order #<?php echo $order_key; ?></h4>
				<p class="text-right">Billed:  <?php  echo date('d/M/Y'); ?></p>
				<br>
				
				<!--h4><?php echo ((isset($_SESSION['restaurant_id']))?$_SESSION['restaurant']: 'BV Foods'); ?></h4-->
				<p class="">
					<?php
						$address = $restaurant_details['address'];
						$region = $restaurant_details['region'];
						$state = $restaurant_details['state'];
						$phone = $restaurant_details['phone'];
						$email = $restaurant_details['email'];
						
						$full_address = ((isset($address))?$address.' ':'');
						$full_address .= ((isset($region))?$region.' ':'');
						$full_address .= ((isset($state))?$state.', Nigeria.':'');
						
						$full_contact = ((isset($phone))?$phone.', ':'');
						$full_contact .= ((isset($email))?$email.'<br>':'');
						
						if($full_address != '')
							echo $full_address;
						else
							echo 'Nigeria';
					?>
				</p>
				</p>
					<?php
						if(isset($full_contact))
							echo $full_contact;
						else
							echo '--------------------------------------------------';
					?>
				</p>
				<div class="<?php echo $theme_color; ?> line"><hr></div>
			<table class="table table-hover">
				<thead>
					<th class="col-sm-1">S/n</th>
					<th class="col-xs-4 col-sm-5">Item</th>
					<th class="col-xs-2 col-sm-2">Price (₦)</th>
					<th class="col-xs-3 col-sm-2">Quantity</th>
					<th class="col-xs-2 col-sm-2">Total (₦)</th>
				</thead>
				<tbody>
					<?php
						$count = 1;
						$total = 0;
						if($order_key > 0){
							$orders = $order_obj->getAllFor('k', $order_key);
							// echo '<pre>';
							// print_r($orders);
							// echo '</pre>';
							foreach($orders as $order){
								//if($id != 0){
									echo '<tr>
												<td>'.$count.'</td>
												<td>'.$order['menu_item'].'</td>
												<td>'.number_format($order['price']).'</td>
												<td>'.$order['quantity'].'</td>
												<td>'.number_format($order['price'] * $order['quantity'], 2).'</td>
											  </tr>';
									$total += $order['price'] * $order['quantity'];
									$count++;
								//}
							}
							echo '<tr>
										<td>&nbsp;</td>
										<td colspan="3"><b>Total</b></td>
										<td><b>'.number_format($total,2).'</b></td>
										<td>&nbsp;</td>
									 </tr>';
						}
						else
							echo '<tr><td colspan="7">Cannot find order</td></tr>';
					?>
				</tbody>
			</table>
			<a href="index.php?a=message&m=bill&ok=<?php echo $order_key; ?>" class="btn btn-primary pull-right <?php echo $theme_color; ?>" name="order" id="order" value="update">Ok <span class="fa fa-chevron-circle-right"></span></a>
		</div>
	</div>