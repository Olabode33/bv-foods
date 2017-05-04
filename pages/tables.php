<?php 
	include 'app/cls-table.php';
	include 'app/cls-login-mgr.php';
	include 'app/cls-order.php';
	include 'utility/utility.php';
	
	$tbl_obj = new Table();	
	$login_obj = new LoginMgr();
	$order_obj = new Order();
	$utility_obj = new Utility();
	
	$stp = 1;
	if(isset($_GET['stp'])) {
		$stp = $_GET['stp'];
		$mode = $_GET['m'];
	}
	
	if(isset($_GET['st'])){
		//echo 'Potter';
		//echo $login_obj->setTable($_GET['st']);
		if($login_obj->setTable($_GET['st'])){
			//echo 'James';
			if(isset($_GET['for'])){
				if($_GET['for'] == 'bill')
					header ('Location: index.php?a=bill&for=bill');
				elseif($_GET['for'] == 'order')
					header ('Location: index.php?a=menu&for=order');
			}				
			else
				header ('Location: index.php?a=menu');
		}
	}
	
	if(isset($_SESSION['table_id']) && !isset($_GET['st'])){
		unset($_SESSION['table_id']);
		unset($_SESSION['table']);
		header ('Location: index.php?a=tables');
	}
	
	$orders = $order_obj->getOrderSummary(3);
?>
<div class="container page">
		 <div class="" >
			<img src="assets/icons/restaurant_set2/table.svg" height="50px" class="pull-left"/>
			<?php
				if(isset($_GET['for']) && $_GET['for'] == 'bill')
					echo '<img src="assets/icons/restaurant_set/bill-1.svg" height="50px" class="pull-right"/>';
				else
					echo '<img src="assets/icons/restaurant_set/dish.svg" height="50px" class="pull-right"/>';
			?>
		</div>
		<h3 class="">&nbsp;Tables - <?php echo ucfirst((isset($_GET['for']))?$_GET['for']:'order').'ing'; ?></h3>
		<div class="<?php echo $theme_color; ?> line"></div>
		<br>
		<div class="row">
			<div class="col-xs-offset-1 col-xs-3">
				<ul class="nav nav-pills nav-stacked sidebar" >
					<li><h4><span class="fa fa-glass"></span> Tables</h4></li>
					<?php
					if(isset($_GET['for']) && $_GET['for'] == 'bill'){
						$orders = $order_obj->getOrderSummary(3);
						
						$count = count($orders);
						
						if($count > 0)
							foreach($orders as $order){
								echo '<li>
											<a href="index.php?a=bill&ok='.$order['order_key'].'" style="font-size: medium">
												<span class="fa fa-cheque"></span></span>
												'.$utility_obj->getObjectFromID('tbl_tables', 'table_name', 'table_id', $order['table_id']).'
											</a>
										</li>';
							}
						else
							echo '<li>No tables available for billing</li>';
					}
					else {
						$tables = $tbl_obj->getAllFor($_SESSION['restaurant_id']);
						foreach($tables as $table){
							$ordered_table = array();
							foreach($orders as $order)
								array_push($ordered_table, $order['table_id']);
								
							//if(!in_array($table['id'], $ordered_table))
							echo '<li>
										<a class="" href="index.php?a=tables&st='.$table['id'].'&for='.((isset($_GET['for']))?$_GET['for']:'order').'" style="font-size: medium">
											'.$table['table'].'
										</a>
									 </li>';
						}
					}
				?>
				</ul>
			</div>
			
			<!--div class="col-xs-3" >
				<ul class="nav nav-pills nav-stacked sidebar" >
					<li><h4><span class="fa fa-money"></span> Ocuppied Tables</h4></li>
					<?php 
						// foreach($orders as $order){
							// echo '<li>
										// <a href="index.php?a=bill&ok='.$order['order_key'].'" class="">
											// '.$utility_obj->getObjectFromID('tbl_tables', 'table_name', 'table_id', $order['table_id']).'
											// <span class="pull-right">Status</span>
										// </a>
									// </li>';
						// }	
					?>					
				</ul>				
			</div-->
			
			<div class="col-xs-3">
				<ul class="nav nav-pills nav-stacked sidebar" >
					<li><h4><span class="fa fa-checked"></span> Reserved Tables<h4></li>
					<li>No tables has been reserved</li>
				</ul>
			</div>
		
		</div>
</div>
<?php 
		//break;
//}
?>