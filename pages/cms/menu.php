<?php 
	include 'app/cls-menu.php';
	include 'app/cls-order.php';
	include 'utility/utility.php';
	$utility_obj = New Utility();
	$order_obj = New Order();
	$menu_obj = New Menu();
	
	if(isset($_GET['dmid'])){
		$rows = $menu_obj->remove_menu($_GET['dmid']);
		//echo $rows
		if($rows > 0){
			$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-success">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>'.$rows.'</strong> records deleted.
														  </div>';
			header('Location: index.php?a=cms&s=menu');
		}
		elseif($rows == -1){
			$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-danger">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>Record cannot be deleted</strong> <br>
																Please delete menu items first.
														  </div>';
			header('Location: index.php?a=cms&s=menu');
		}
		else{
			$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-warning">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>'.$rows.'</strong> records deleted.
														  </div>';
			header('Location: index.php?a=cms&s=menu');
		}
		
	}
	
?>
<h3><span class="fa fa-cutlery"></span> Available Menus</h3>
<div class="<?php echo $theme_color; ?> line"></div>	
<a class="btn btn-sm btn-primary pull-right <?php echo $theme_color; ?>" href="index.php?a=actions"><span class="fa fa-reply"></span> Back</a>
<a class="btn btn-sm btn-primary <?php echo $theme_color; ?>" href="index.php?a=cms&s=menu-new"><span class="fa fa-plus"></span> Add New Menu</a><br>
<table class="table table-hover">
	<thead>
		<th class="col-sm-1">S/n</th>
		<th class="col-xs-3 col-sm-3">Menu</th>
		<th class="col-xs-2 col-sm-2">Items</th>
		<th class="col-xs-2 col-sm-2">Actions</th>
	</thead>
	<tbody>
	<?php 
		$menus = $menu_obj->getMenusFor($_SESSION['restaurant_id']);
		$count = 1;
		
		foreach($menus as $menu){
			echo '<tr>
						<td>'.$count.'</td>
						<td>'.$menu['menu'].'</td>
						<td>'.$menu['items'].'</td>
						<td>
							<a href="index.php?a=cms&s=menu-view&mid='.$menu['id'].'" class="btn btn-sm btn-primary '.$theme_color.'"><span class="fa fa-eye"></span> View</a>
							<a href="index.php?a=cms&s=menu-new&mid='.$menu['id'].'" class="btn btn-sm btn-primary '.$theme_color.'"><span class="fa fa-pencil"></span> Edit</a>
							<!--a href="index.php?a=cms&s=menu&dmid='.$menu['id'].'" class="btn btn-sm btn-primary '.$theme_color.'"><span class="fa fa-trash"></span> Delete</a-->
							<button class="btn btn-sm btn-primary '.$theme_color.'" data-toggle="modal" data-target="#deleteItem" data-title="Delete Menu" 
								data-msg="Are you sure you want to delete the menu '.$menu['menu'].'?" 
								data-link="index.php?a=cms&s=menu&dmid='.$menu['id'].'">
								<span class="fa fa-trash"></span> Delete
							</button>
						</td>
					</tr>';
					
			$count++;
		}
	?>
	</tbody>
</table>