<?php
	include 'app/cls-menu.php';
	include 'app/cls-order.php';
	include 'utility/utility.php';
	$utility_obj = New Utility();
	$order_obj = New Order();
	$menu_obj = New Menu();

	$mid = 0;
	if(isset($_GET['mid'])){
		$mid = $_GET['mid'];
	}
	
	if(isset($_GET['diid'])){
		$rows = $menu_obj->remove_item($_GET['diid']);
		//echo $rows
		if($rows > 0){
			$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-success">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>'.$rows.'</strong> records deleted.
														  </div>';
			header('Location: index.php?a=cms&s=menu-view&mid='.$mid);
		}
		else{
			$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-warning">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>'.$rows.'</strong> records deleted.
														  </div>';
			header('Location: index.php?a=cms&s=menu-view&mid='.$mid);
		}
		
	}
	if(isset($_GET['siid'])){
		$rows = $menu_obj->set_special_item($_GET['siid'], $_GET['sp']);
		//echo $rows
		if($rows > 0){
			$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-success">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>'.$rows.'</strong> records updated.
														  </div>';
			header('Location: index.php?a=cms&s=menu-view&mid='.$mid);
		}
		else{
			$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-warning">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>Error updating menu item'.$rows.'</strong> records deleted.
														  </div>';
			header('Location: index.php?a=cms&s=menu-view&mid='.$mid);
		}
		
	}
	
?>
<h3><span class="fa fa-cutlery"></span> Menu - <span class="<?php echo $theme_text.'">'.$utility_obj->getObjectFromID('tbl_menus', 'menu_name', 'menu_id', $mid)?></span></h3>
<div class="<?php echo $theme_color; ?> line"></div>	
<a class="btn btn-sm btn-primary pull-right <?php echo $theme_color; ?>" href="index.php?a=cms&s=menu"><span class="fa fa-reply"></span> Go Back</a> 
<span class="pull-right">&nbsp;</span>
<a class="btn btn-sm btn-primary pull-left <?php echo $theme_color; ?>" href="index.php?a=cms&s=menu-item&mid=<?php echo $mid; ?>"><span class="fa fa-plus-square-o"></span> Add Menu Item</a>


<div class="row">
	<!--div class="col-md-4">
		<h4>Menu:</h4>
		<h3></h3>
		<img src="assets/images/menu-bgs/<?php //echo $utility_obj->getObjectFromID('tbl_menus', 'menu_img', 'menu_id', $mid)?>" class="img-thumbnail img-rounded" width="75%"/> 
	</div-->

	<div class="col-md-12">
		<h4>Items under this menu</h4>
		<table class="table table-hover">
			<thead>
				<th class="col-sm-1">S/n</th>
				<th class="col-xs-3">Item</th>
				<th class="col-xs-2">Price (₦)</th>
				<th class="col-xs-1">Special</th>
				<!--th class="hidden-xs hidden-sm hidden-md">Note</th-->
				<th class="col-xs-3">Actions</th>
			</thead>
			<tbody>
			<?php
				//<td>'.$item['note'].'</td>
			
				$items = $menu_obj->getItemsFor($mid);
				$count = 1;
				
				foreach($items as $item){
					echo '<tr>
								<td>'.$count.'</td>
								<td>'.$item['menu_item'].'</td>
								<td>'.$item['price'].'</td>
								
								<td>
									<button class="btn-menu-select '.$theme_text.'" data-toggle="modal" data-target="#deleteItem" data-title="Set as Special" 
										data-msg="Are you sure you want to make the menu item '.$item['menu_item'].' a '.(($item['special'] == 1)?'regular':'special').'?" 
										data-link="index.php?a=cms&s=menu-view&siid='.$item['id'].'&mid='.$mid.'&sp='.(($item['special'] == 1)?'n':'y').'">
										<span class="fa fa-toggle-'.(($item['special'] == 1)?'on':'off').'" style="font-size: 30px;"></span>
									</button>
								</td>
								<td>
									<a href="index.php?a=cms&s=menu-item&iid='.$item['id'].'&mid='.$mid.'" class="btn btn-sm btn-primary '.$theme_color.'"><span class="fa fa-pencil"></span> Edit</a>
									<!--a href="index.php?a=cms&s=menu-view&diid='.$item['id'].'&mid='.$mid.'" class="btn btn-sm btn-primary '.$theme_color.'" ><span class="fa fa-trash"></span> Delete</a-->
									<button class="btn btn-sm btn-primary '.$theme_color.'" data-toggle="modal" data-target="#deleteItem" data-title="Delete Menu Item" 
										data-msg="Are you sure you want to delete the menu item '.$item['menu_item'].'?" 
										data-link="index.php?a=cms&s=menu-view&diid='.$item['id'].'&mid='.$mid.'">
										<span class="fa fa-trash"></span> Delete
									</button>
								</td>
							 </tr>';
					
					$count++;
				}
			?>
				
			</tbody>
		</table>
	</div>
</div>