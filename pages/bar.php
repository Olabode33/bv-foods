<?php
	include 'app/cls-menu.php';
	include 'app/cls-order.php';
	include 'utility/utility.php';
	$utility_obj = New Utility();
	$order_obj = New Order();
	$menu_obj = New Menu();
	
	$view = 'none';
	if(isset($_GET['v'])){
		$view = $_GET['v'];
		//$order_obj->updateOrderStatus($view, 2);
		
		if(isset($_GET['s']) && $_GET['s'] == 3){
			$order_obj->updateOrderStatus($view, 3);
			$view = 'none';
		}
	}
	
?>
	<div class="container page">
		<div class="col-sm-12">
			<div class="">
				<img src="assets/icons/restaurant_set/chef.svg" height="70px" class="pull-left"/>
			</div><br>
			<h3>&nbsp; Bar/Chef</h3>
			<div class="<?php echo $theme_color; ?> line"></div>
			<div class="col-sm-5">
				<h3>Orders</h3><hr>
				<table class="table table-hover">
					<thead>
						<th class="col-sm-1">S/n</th>
						<th class="col-xs-3 col-sm-3">Table</th>
						<th class="col-xs-2 col-sm-2"> </th>
					</thead>
					<tbody>
						<?php
							$count = 1;
							$total = 0;
							
							$orders = $order_obj->getOrderSummary();
							if(count($orders) > 0){
								foreach($orders as $order){
									echo '<tr '.(($view == $order['order_key'])?'class="active"':'').'>
												<td>'.$count.'</td>
												<td>'.$utility_obj->getObjectFromID('tbl_tables', 'table_name', 'table_id', $order['table_id']).' <span class="small">('.$utility_obj->time_elapsed_string($order['date']).')</span></td>
												<td>
													<button class="btn btn-sm btn-primary pull-right '.	$theme_color.'" onclick="loadDetails('.$order['order_key'].');" >
														<span class="fa fa-eye"></span> View Details
													</button>
												</td>
											 </tr>';
									$count++;
								}
							}
							else {
								echo '<tr><td colspan="3">No order has been placed yet.</td></tr>';
							}
							
						?>
					</tbody>
				</table>
			</div>
			<div class="col-sm-7" id="table_orders">
				<h3 class="text-primary">Order Details</h3><hr>
				<?php
					if($view == 'none'){
						echo '<p>Please select an order</p>';
					}
					else {
						$order_items = $order_obj->getAllFor('k', $view);
						
						echo '<div id="">
									<p>Table:</p>
									<h4 class="'.$theme_text.'">'.$utility_obj->getObjectFromID('tbl_tables', 'table_name', 'table_id', $order_items[0]['table_id']).' <span class="small">('.$utility_obj->time_elapsed_string($order_items[0]['order_date']).')</span></h4>
									<p><b>Estimated Time: </b> '.$order_items[0]['etime'].' minutes</p>
									<h4 class="text-primary">Orders</h4>
									<table class="table table-border">
										<thead>
											<th class="col-xs-9">Items</th>
											<th class="col-xs-3">Quantity</th>
											<th class="col-xs-5">Perference</th>											
										</thead>
										<tbody>';
										foreach($order_items as $order_item){
											echo '<tr>
														<td>'.$order_item['menu_item'].'</td>
														<td>'.$order_item['quantity'].'</td>
														<td>'.$order_item['pref'].'</td>
											 	</tr>';
										}
										
						echo 		'</tbody>
									</table>
								</div>';
						?>
						<div>
							<a href="index.php?a=bar&v=<?php echo $view ?>&s=3" class="btn btn-lg btn-primary <?php echo $theme_color; ?>"><span class="fa fa-beer"></span> Serve</a>
						</div>
						<?php
					}
				?>
			</div>
			<!--a href="index.php?a=menu" class="btn btn-lg btn-primary pull-left"><span class="fa fa-chevron-circle-left"></span> Back to Menu</span></a>
			<button type="submit" class="btn btn-lg btn-primary pull-right" name="order" id="order" value="update">Continue <span class="fa fa-chevron-circle-right"></span></button-->
		</div>
	</div>
	
	<script>
	if (window.webkitNotifications) {
		console.log('Your web browser does support notifications!');
	} else {
		console.log('Your web browser does not support notifications!');
	}
	</script>
