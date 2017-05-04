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
	
	?>
	<!--div class="row"-->
		<div class="col-sm-12">
			<span class="pull-right"><a href="index.php?a=place-order" class="btn btn-lg btn-primary">Place Order <i class="fa fa-chevron-circle-right"></i></a></span>
			<h3><i class="fa fa-cutlery"></i> Menu - <span class="text-primary"><?php echo $m; ?></span></h3>
			<div class="orange line"></div>
		</div>
		
		<div data-spy="scroll" data-target="#myScrollspy" data-offset="15">
		<div class="col-sm-3 col-md-2" id="myScrollspy">
			<h5>Our Menus</h5>
			<?php
				$menus = $menu_obj->getMenusFor($_SESSION['restaurant_id']);
				
				//print_r($menus);
				echo '<ul class="nav nav-pills nav-stacked" data-spy="affix" data-offset-top="205">';
				foreach($menus as $menu){
					echo '<li><a href="#'.$menu['id'].'" class="'.(($m_id == $menu['id'])?'active':'').' truncate"  onclick="loading();" style="text-align: left;">'.$menu['menu'].'</a></li>';
				}
				echo '</ul>';
			?>
		</div>
		
		<div class="col-sm-9 col-md-10">
			<?php
				foreach($menus as $menu){
					echo '<section id="'.$menu['id'].'" >';
					echo '<h3>'.$menu['menu'].'<h3>';
						$items = $menu_obj->getItemsFor($menu['id']);
						$count = 0;
				
						echo '<div class="row">';
						
						foreach($items as $item){
							$selected = false;
							if(isset($_SESSION['order'][$item['id']]))
								$selected = true;
							//$mod = $count % 3;
							//echo '<script>console.log('.$mod.')</script>';
							// if($count%5 == 0){
								 //echo '</div><div class="row">';
							// }
							
							echo '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
										<div class="thumbnail">
											<img src="assets/images/menu-items/'.$item['image'].'" class="img-responsive"/>
											<hr style="margin-top: 8px; margin-bottom:-10px;">
											<div class="caption">
												<h4 class="truncate">'.$item['menu_item'].'</h4>
												<span>
												<p class="">
													₦'.number_format($item['price'], 2).'
												</p>
												<p class="">
													<button type="button" class="btn btn-primary btn-xs"  data-toggle="modal" data-target="'.(($selected)?'#removeOrder':'#yourOrder').'" data-img="'.$item['image'].'" 
														data-item="'.$item['menu_item'].'" data-id="'.$item['id'].'" data-price="'.$item['price'].'" data-tprice="'.number_format($item['price'], 2).'" data-qty="'.(($selected)?$_SESSION['order'][$item['id']]['quantity']:0).'">
														'.(($selected)?'Selected ':'Select ').'<i class="fa fa-'.(($selected)?'check-':'').'square-o"></i>
													</button>
												</p>
												</span>
											</div>
										 </div>
									 </div>';
							
							if($count%3 == 1){
								
							}
							
							$count++;
						}		
						
						echo '</div>';
						echo '</section>';
				// echo '<pre>';
				// print_r($_SESSION['order']);
				// echo '</pre>';
				}
			?>
			
			<div id="one">
				ONE
			</div>
			
		</div>
	</div>
		
		
		<script>
			
		</script>
	<!--/div-->