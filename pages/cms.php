<?php	
	$view = 'actions';
	if(isset($_GET['s'])){
		$view = $_GET['s'];
	}
	$admin_title = ucfirst($view);
?>
	<div class="container page">
		<div class="col-sm-12">
			<?php
				//if($_SESSION['role_id'] != 1)
					//echo '<a href="index.php?a=cms" class="btn btn-primary pull-right"><span class="fa fa-home"></span></a>';
			
				// echo '<ul class="breadcrumb">
							// <li><a href="index.php?a=actions" class="'.$theme_text.'"><i class="fa fa-home"></i> Actions</a></li>';
							
							// if(isset($_GET['s'])){							
								// switch($_GET['s']){
									// case 'menu-new':
										// if(isset($_GET['mid']))
											// echo '<li><a href="index.php?a=cms&s=menu" class="'.$theme_text.'"><i class="fa fa-cutlery"></i> Menu</a></li>
													 // <li class="active"><i class="fa fa-edit" class="'.$theme_text.'"></i> Edit Menu</li>';
										// else
											// echo '<li><a href="index.php?a=cms&s=menu" class="'.$theme_text.'"><i class="fa fa-cutlery"></i> Menu</a></li>
													 // <li class="active"><i class="fa fa-plus" class="'.$theme_text.'"></i> New Menu</li>';
										// break;
									// case 'menu-view':
										// echo '<li><a href="index.php?a=cms&s=menu" class="'.$theme_text.'"><i class="fa fa-cutlery"></i> Menu</a></li>
												 // <li class="active"><i class="fa fa-eye" class="'.$theme_text.'"></i> View Menu</li>';
										// break;
									// case 'menu':
										// if(isset($_GET['dmid']))
											// echo '<li><a href="index.php?a=cms&s=menu" class="'.$theme_text.'"><i class="fa fa-cutlery"></i> Menu</a></li>
													 // <li class="active"><i class="fa fa-trash"></i> Delete Menu</li>';
										// else
											// echo '<li class="active"><i class="fa fa-cutlery"></i> Menus</li>';
										// break;
									// case 'menu-item':
										// if(isset($_GET['iid']))
											// echo '<li><a href="index.php?a=cms&s=menu" class="'.$theme_text.'"><i class="fa fa-cutlery"></i> Menu</a></li>
													 // <li><a href="index.php?a=cms&s=menu-view&mid='.$_GET['mid'].'" class="'.$theme_text.'"><i class="fa fa-th"></i> Menu Item</a></li>
													 // <li class="active"><i class="fa fa-edit"></i> Edit Menu Item</li>';
										// else
											// echo '<li><a href="index.php?a=cms&s=menu" class="'.$theme_text.'"><i class="fa fa-cutlery"></i> Menu</a></li>
													 // <li><a href="index.php?a=cms&s=menu-view&mid='.$_GET['mid'].'" class="'.$theme_text.'"><i class="fa fa-th"></i> Menu Item</a></li>
													 // <li class="active"><i class="fa fa-plus-square-o"></i> New Menu Item</li>';
										// break;										
									// case 'dashboard':
										// if(isset($_GET['m']) && $_GET['m'] != 'default')
											// echo '<li><a href="index.php?a=cms&s=dashboard" class="'.$theme_text.'"><i class="fa fa-dashboard"></i> Dashboard</a></li>
													  // <li class="active">'.ucfirst($_GET['m']).'</li>';
										// else
											// echo '<li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>';
										// break;
									// case 'user':
										// if(isset($_GET['duid']))
											// echo '<li><a href="index.php?a=cms&s=user" class="'.$theme_text.'"><i class="fa fa-users"></i> User</a></li>
													 // <li class="active"><i class="fa fa-user-times"></i> Delete User</li>';
										// else
											// echo '<li class="active"><i class="fa fa-users"></i> Users</li>';
										// break;
									// case 'user-new':
										// if(isset($_GET['uid']))
											// echo '<li><a href="index.php?a=cms&s=user" class="'.$theme_text.'"><i class="fa fa-users"></i> User</a></li>
													 // <li class="active"><i class="fa fa-edit"></i> Edit User</li>';
										// else
											// echo '<li><a href="index.php?a=cms&s=user" class="'.$theme_text.'"><i class="fa fa-users"></i> User</a></li>
													 // <li class="active"><i class="fa fa-user-plus"></i> New User</li>';
										// break;
									// case 'restaurants':		
										// if(isset($_GET['drid']))
											// echo '<li><a href="index.php?a=cms&s=restaurants" class="'.$theme_text.'"><i class="fa fa-cutlery"></i> Restaurant</a></li>
													 // <li class="active"><i class="fa fa-times"></i> Delete Restaurant</li>';
										// else
											// echo '<li class="active"><i class="fa fa-cutlery"></i> Restaurant</li>';
										// break;
									// case 'restaurant-new':
										// if(isset($_GET['rid']))
											// echo '<li><a href="index.php?a=cms&s=restaurants" class="'.$theme_text.'"><i class="fa fa-cutlery"></i> Restaurant</a></li>
													 // <li class="active"><i class="fa fa-edit"></i> Edit Restaurant</li>';
										// else
											// echo '<li><a href="index.php?a=cms&s=restaurants" class="'.$theme_text.'"><i class="fa fa-cutlery"></i> Restaurant</a></li>
													 // <li class="active"><i class="fa fa-plus"></i> New Restaurant</li>';
										// break;
									// case 'restaurant-view':
										// echo '<li><a href="index.php?a=cms&s=restaurants" class="'.$theme_text.'"><i class="fa fa-cutlery"></i> Restaurant</a></li>
												 // <li class="active"><i class="fa fa-eye" class="'.$theme_text.'"></i> View Restaurant</li>';
										// break;
									// case 'table-new':
										// if(isset($_GET['iid']))
											// echo '<li><a href="index.php?a=cms&s=restaurants" class="'.$theme_text.'"><i class="fa fa-cutlery"></i> Restaurant</a></li>
													 // <li><a href="index.php?a=cms&s=restaurant-view&rid='.$_GET['rid'].'" class="'.$theme_text.'"><i class="fa fa-th"></i> Restaurant Table</a></li>
													 // <li class="active"><i class="fa fa-edit"></i> Edit Restaurant Table</li>';
										// else
											// echo '<li><a href="index.php?a=cms&s=restaurants" class="'.$theme_text.'"><i class="fa fa-cutlery"></i> Restaurant</a></li>
													 // <li><a href="index.php?a=cms&s=restaurant-view&rid='.$_GET['rid'].'" class="'.$theme_text.'"><i class="fa fa-th"></i> Restaurant Table</a></li>
													 // <li class="active"><i class="fa fa-plus-square-o"></i> New Restaurant Table</li>';
										// break;	
								// }
							// }
							
				// echo '</ul>';
			
				include 'pages/cms/'.$view.'.php';
			?>
		</div>
	</div>