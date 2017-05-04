<?php
	include 'app/cls-menu.php';
	include 'app/cls-order.php';
	include 'utility/utility.php';
	$utility_obj = New Utility();
	$menu_obj = New Menu();
	$order_obj = New Order();
	
	$m=$utility_obj->getObjectFromID('tbl_menus m INNER JOIN tbl_restaurant_menus rm ON m.menu_id = rm.menu_id', 'menu_name', 'restaurant_id', $_SESSION['restaurant_id'].' LIMIT 1');
	$m_id = $utility_obj->getObjectFromID('tbl_menus m INNER JOIN tbl_restaurant_menus rm ON m.menu_id = rm.menu_id', 'm.menu_id', 'restaurant_id', $_SESSION['restaurant_id'].' LIMIT 1');
	if(isset($_GET['m'])){
		$m = $utility_obj->getObjectFromID('tbl_menus', 'menu_name', 'menu_id', $_GET['m']);
		$m_id = $_GET['m'];
	}
	
	if(isset($_POST['menu']) && $_POST['menu'] == 'order'){
		$order_obj->addToPlate();
		//echo '<pre>';
		//print_r($_SESSION['order']);
		//echo '</pre>';
	}
	
	if(isset($_POST['menu']) && $_POST['menu'] == 'remove'){
		$order_obj->removeFromPlate();
	}
	
	if(isset($_GET['st'])) {
		
	}
	
	$menus = $menu_obj->getMenusFor($_SESSION['restaurant_id']);
	?>
	<!--Horizontal Navbar-->
	
		<nav class="navbar navbar-default topnav hidden-sm hidden-md hidden-lg <?php echo $theme_color; ?>" data-spy="affix" data-offset-top="197" style="100%">
			<div class="container">
				<!-- Restaurant Name and Menu List -->
				<div class="navbar-header pull-left">
					<!--button type="button" class="navbar-toggle collapsed text-white navbar-right" data-toggle="collapse" data-target="#navMenu" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="fa fa-cutlery"></span> Plate <span class="badge">3</span>
					</button-->
					<a href="#" class="navbar-brand dropdown" data-toggle="dropdown">
						
						<?php 
							$logo = $utility_obj->getObjectFromID('tbl_restaurants', 'logo', 'id', $_SESSION['restaurant_id']);
							
							echo ((isset($logo))?'<img src="assets/images/restaurants-logo/'.$logo.'" id="HeaderLogo" height="25" width="15"/>':
										((isset($_SESSION['restaurant_id']))?$_SESSION['restaurant']: 'BV Foods')
									 ); 
						?> 
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu <?php echo $theme_light; ?>" id="topmenunav" role="menu" style="width: 100%">
						<li class="dropdown-header"><h4 class="text-white">Menus</h4></li>
						<?php
							foreach($menus as $menu)
								echo '<li><a href="#'.$menu['id'].'" class="truncate"  onclick="loading();" >'.$menu['menu'].'</a></li>';
						?>
                  </ul>
				</div>
				<!-- End Restaurant Name and Menu List -->
				
				<!-- List of Placed Orders -->
				<a href="#" class="navbar-brand dropdown pull-right" data-toggle="dropdown" data-target="navMenu" style="margin-left:30px;">
					<span class="fa fa-cutlery"></span> Plate 
					<span class="badge"><?php echo ((isset($_SESSION['order']))?count($_SESSION['order']):' 0'); ?></span>
					<span class="caret"></span>
				</a>
				<div class="dropdown-menu dropdown-menu-right" id="navMenu" style="margin: 3%; padding: 2%;">
					<a href="index.php?a=place-order" class="btn btn-block btn-default <?php echo $theme_color; ?>">Complete Order</a>
					
					<h4 class="dropdown-header <?php echo $theme_text; ?>">Orders</h4>
					
					<div class="">
						<?php include "pages/mini-includes/current_order_list.php"; ?>
					</div>
				</div>
				<!-- End of List of placed orders -->
				
			</div>
		</nav>
		<!-- End Horizontal Navbar -->
		
		<!-- Main Content -->
		<main class="container page" >
			<div class="">
				<!-- Vertical Affix Navigator -->
				<nav class="hidden-xs col-sm-2 <?php echo $theme_text; ?>" id="myScrollspy">
					<ul class="nav nav-pills nav-stacked sidebar" >
						<li>Menu List</li>
						<?php
							foreach($menus as $menu)
								echo '<li><a href="#'.$menu['id'].'" class="truncate"  onclick="loading();" >'.$menu['menu'].'</a></li>';
						?>
					</ul>
				</nav>
				<!-- End Vertical Navigator -->
				
				<!-- Menu List -->
				<div class="col-sm-7" style="margin-top: -15px;">
					<?php 
						foreach($menus as $menu) {
							//Menu Item List
							echo '<section class="row" id="'.$menu['id'].'">
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="'.$theme_text.'">'.$menu['menu'].'</h4>
											</div>
											<div class="panel-body">';
												//List of Items
												$items = $menu_obj->getItemsFor($menu['id']);
												$count = 0;
												
												foreach($items as $item){
													$selected = false;
													if(isset($_SESSION['order'][$item['id']]))
													$selected = true;
												
												echo '<div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
															<div class="thumbnail">
																'.(($item['special'] != 1)?'':
																'
																<div class="badges-ribbon">
																	<div class="badges-ribbon-content" style="background-color: '.$theme_hex.'">Special</div>
																</div>
																').'
																<img src="assets/images/menu-items/'.$item['image'].'" class="img-responsive"/>
																<hr style="margin-top: 8px; margin-bottom:-10px;">
																<div class="caption">
																	<h5 class="truncate">'.$item['menu_item'].'</h5>
																	<span>
																		<span class="pull-right">
																			<button type="button" class="btn-menu-select '.$theme_text.'"  data-toggle="modal" data-target="'.(($selected)?'#removeOrder':'#yourOrder').'" data-img="'.$item['image'].'" 
																				data-item="'.$item['menu_item'].'" data-id="'.$item['id'].'" data-price="'.$item['price'].'" data-tprice="'.number_format($item['price'], 2).'" 
																				data-qty="'.(($selected)?$_SESSION['order'][$item['id']]['quantity']:0).'" data-etime="'.$item['time'].'">
																				<i class="fa fa-'.(($selected)?'check-':'').'square-o"></i>
																			</button>
																		</span>
																		<p class="">
																			₦'.number_format($item['price'], 2).'
																		</p>
																	</span>
																</div>
															</div>
														</div>';
												}
												//End List of Items
							echo 		'</div>
										</div>
									</section>';
							//End Menu Item List
						}
					?>
				</div>	
				<!-- End Menu List -->
				
				<!-- Orders-->
				<div class="hidden-xs col-sm-3">
					<div class="sidebar orders">
						<div class="panel panel-default" >
							<div class="panel-heading <?php echo $theme_color; ?>">
								<h4 class="text-white">Orders</h4>
							</div>
							<div class="panel-body">
								<?php include "pages/mini-includes/current_order_list.php"; ?>
							</div>
							<div class="panel-footer">
								<?php 
									if(isset($_SESSION['order'])){
										echo '<h5>Estimated Delivery Time:</h5>
										<p class="'.$theme_text.'">'.number_format($order_obj->estimate_time(), 0).' minutes</p>';
									}
									
								?>
							</div>
						</div>
						
						<a href="index.php?a=place-order" class="btn btn-block btn-default <?php echo $theme_color; ?> text-right" >Complete Order <span class="fa fa-chevron-circle-right"></span></a>
					</div>
				</div>
				<!-- End Orders -->
			</div>
		</main>
		<!-- End Main Content -->
		
		<script>
			$('.sidebar').affix({
				offset: {
					top: 235
				}
			});
			
			var offset = 100;
			
			$('.sidebar li a').click(function(event) {
				event.preventDefault();
				$($(this).attr('href'))[0].scrollIntoView();
				scrollBy(0, -offset);
			});
			
			$('#topmenunav li a').click(function(event) {
				event.preventDefault();
				$($(this).attr('href'))[0].scrollIntoView();
				scrollBy(0, -60);
			});
			
		</script>
	</div>
		
		
		