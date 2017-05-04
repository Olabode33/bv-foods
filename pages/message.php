<?php
	$msg = 'default';
	if(isset($_GET['m'])){
		$msg = $_GET['m'];
	}
	include 'app/cls-order.php';
	$order_obj = New Order();
						
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
?>
	<div class="container page">
		<div class="col-sm-12">
			<?php
				switch ($msg){
					case 'order':
				?>
						<h3><i class="fa fa-check-square-o"></i> Your order has been saved</h3>
						<div class="<?php echo $theme_color; ?> line"></div>
						<div class="">
							<p>Would you like to place another order?</p>
							<a href="index.php?a=menu" class="btn btn-lg btn-success"><span class="fa fa-check"></span> Yes</a>	
							<a href="index.php?a=check-out" class="btn btn-lg btn-danger"><span class="fa fa-close"></span> No</a>			
						</div>
				<?php
						break;
					
					case 'wait':
						$order_key = 0;
						
						if(isset($_SESSION['order']) && count($_SESSION['order']) > 0){
							$_SESSION['order_key'] = $order_obj->add();
							$order_key = $_SESSION['order_key'];
						}
						//echo $_SESSION['order_key'];
						//echo $order_key;
						//if($order_key > 0) {
				?>
							<h3><i class="fa fa-info-circle"></i> Order Placed</h3>
							<div class="<?php echo $theme_color; ?> line"></div>
							<div class="">
								<p>Estimated Delivery Time:</p>
								<h1><?php echo $order_obj->getOrderTime('order', $_SESSION['order_key']).' minutes';?></h1>
									
							</div>
				<?php
						//}
						// else {
							// echo '<h3><i class="fa fa-info-circle"></i>Error Placing Order</h3>
									 // <div class="orange line></div>
									 // <div>
										// <p>There was an error placing your order</p>
									 // </div>"';
						// }
					break;
					
					case 'feedback':
						echo '<h3><i class="fa fa-info-circle"></i> Feedback Submitted</h3>
								  <div class="'.$theme_color.' line"></div>
								  <h3>Thank you for taking the time to give us your feedback.</h3>
								  <p>Your feedback is important to us.';
						break;
						
					case 'bill':
						$order = '';
						
						if(isset($_GET['ok']))
							$order = $_GET['ok'];
						
						if($order == ''){
							
						}
						else{
							$order_obj->updateOrderStatus($order, 4);
							echo '<h3><i class="fa fa-info-circle"></i> Thank you for choosing to dine with us.</h3>
									 <div class="'.$theme_color.' line"></div><br>
									 <h4>Would you like to take a quick 3 minutes survey?</h4><p>This is to improve our service offering to you</p><br>
									 <a href="index.php?a=feedback" class="btn btn-success '.$theme_color.'"><span class="fa fa-check"></span> Yes</a>	
									 <a href="index.php?a=message&m=thk" class="btn btn-danger '.$theme_color.'"><span class="fa fa-close"></span> No</a>';
						}
						break;
						
					case 'thk':
						echo '<h3><i class="fa fa-info-circle"></i> Thank you for choosing to dine with us.</h3>
								  <div class="'.$theme_color.' line"></div>
								  <h4>Enjoy the rest of your day</h4>';
				}
				
				
				 
			?>
		</div>
	</div>
	
