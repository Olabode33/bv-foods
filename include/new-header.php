<?php
	//Personalize per restuarant
	$r_theme = "bg-dark-blue-grey";
	$theme_light = "bg-blue-grey";
	$theme_text = "text-blue-grey";
	$theme_hex = "#607D8B";
	
	$theme = 0;
	
	if(isset($_SESSION['theme_id']))
		$theme = $_SESSION['theme_id'];
	
	switch($theme){
		case '1':
			//red         #F44336 
			$theme_color = "bg-dark-red";
			$theme_light = "bg-red";
			$theme_text = "text-dark-red";
			$theme_text_light = "text-red";
			$theme_hex = "#F44336";
			break;
		case '2':
			//pink        #E91E63  
			$theme_color = "bg-dark-pink";
			$theme_light = "bg-pink";
			$theme_text = "text-dark-pink";
			$theme_text_light = "text-pink";
			$theme_hex = "#E91E63";
			break;
		case '3':
			//purple      #9C27B0  
			$theme_color = "bg-dark-purple";
			$theme_light = "bg-purple";
			$theme_text = "text-dark-purple";
			$theme_text_light = "text-purple";
			$theme_hex = "#9C27B0";
			break;
		case '4':
			//deep-purple #673AB7  
			$theme_color = "bg-dark-deep-purple";
			$theme_light = "bg-deep-purple";
			$theme_text = "text-dark-deep-purple";
			$theme_text_light = "text-deep-purple";
			$theme_hex = "#673AB7";
			break;
		case '5':
			// indigo      #3F51B5  
			$theme_color = "bg-dark-indigo";
			$theme_light = "bg-indigo";
			$theme_text = "text-dark-indigo";
			$theme_text_light = "text-indigo";
			$theme_hex = "#3F51B5";
			break;
		case '6':
			//blue        #2196F3  
			$theme_color = "bg-dark-blue";
			$theme_light = "bg-blue";
			$theme_text = "text-dark-blue";
			$theme_text_light = "text-blue";
			$theme_hex = "#2196F3";
			break;
		case '7':
			//light-blue  #03A9F4  
			$theme_color = "bg-dark-light-blue";
			$theme_light = "bg-light-blue";
			$theme_text = "text-dark-light-blue";
			$theme_text_light = "text-light-blue";
			$theme_hex = "#03A9F4";
			break;
		case '8':
			//cyan        #00BCD4  
			$theme_color = "bg-dark-cyan";
			$theme_light = "bg-cyan";
			$theme_text = "text-dark-cyan";
			$theme_text_light = "text-cyan";
			$theme_hex = "#00BCD4";
			break;
		case '9':
			//teal        #009688  
			$theme_color = "bg-dark-teal";
			$theme_light = "bg-teal";
			$theme_text = "text-dark-teal";
			$theme_text_light = "text-teal";
			$theme_hex = "#009688";
			break;
		case '10':
			//green       #4CAF50  
			$theme_color = "bg-dark-green";
			$theme_light = "bg-green";
			$theme_text = "text-dark-green";
			$theme_text_light = "text-green";
			$theme_hex = "#4CAF50";
			break;
		case '11':
			//light-green #8BC34A  
			$theme_color = "bg-dark-light-green ";
			$theme_light = "bg-light-green";
			$theme_text = "text-dark-light-green ";
			$theme_text_light = "text-light-green ";
			$theme_hex = "#8BC34A";
			break;
		case '12':
			//lime        #CDDC39  
			$theme_color = "bg-dark-lime";
			$theme_light = "bg-lime";
			$theme_text = "text-dark-lime";
			$theme_text_light = "text-lime";
			$theme_hex = "#CDDC39";
			break;
		case '13':
			//yellow      #FFEB3B  
			$theme_color = "bg-dark-yellow";
			$theme_light = "bg-yellow";
			$theme_text = "text-dark-yellow";
			$theme_text_light = "text-yellow";
			$theme_hex = "#FFEB3B";
			break;
		case '14':
			//amber       #FFC107  
			$theme_color = "bg-dark-amber";
			$theme_light = "bg-amber";
			$theme_text = "text-dark-amber";
			$theme_text_light = "text-amber";
			$theme_hex = "#FFC107";
			break;
		case '15':
			//orange      #FF9800  
			$theme_color = "bg-dark-orange";
			$theme_light = "bg-orange";
			$theme_text = "text-dark-orange";
			$theme_text_light = "text-orange";
			$theme_hex = "#FF9800";
			break;
		case '16':
			//deep-orange #FF5722  
			$theme_color = "bg-dark-deep-orange";
			$theme_light = "bg-deep-orange";
			$theme_text = "text-dark-deep-orange";
			$theme_text_light = "text-deep-orange";
			$theme_hex = "#FF5722";
			break;
		case '17':
			//brown       #795548  
			$theme_color = "bg-dark-brown";
			$theme_light = "bg-brown";
			$theme_text = "text-dark-brown";
			$theme_text_light = "text-brown";
			$theme_hex = "#795548";
			break;
		case '18':
			//grey        #9E9E9E  
			$theme_color = "bg-dark-grey ";
			$theme_light = "bg-grey";
			$theme_text = "text-dark-grey";
			$theme_text_light = "text-grey";
			$theme_hex = "#9E9E9E";
			break;
		case '19':
			// light-grey  #f0f3f4
			$theme_color = "bg-dark-light-grey ";
			$theme_light = "bg-light-grey ";
			$theme_text = "text-dark-light-grey ";
			$theme_text_light = "text-light-grey ";
			$theme_hex = "#f0f3f4";
			break;
		case '20':
			//blue-grey   #607D8B 
			$theme_color = "bg-dark-blue-grey";
			$theme_light = "bg-blue-grey";
			$theme_text = "text-dark-blue-grey";
			$theme_text_light = "text-blue-grey";
			$theme_hex = "#607D8B";
			break;
		
		default:
			$theme_color = "bg-dark-blue-grey";
			$theme_light = "bg-blue-grey";
			$theme_text = "text-dark-blue-grey";
			$theme_text_light = "text-blue-grey";
			$theme_hex = "#607D8B";
			break;
	}
	// End Personalization per restaurant
	
	// Customize header per page
		$page_desc = "Enjoy the experience";
	// End page customization
?>		
		
		
		<!--Header -->
		<header class="container-fluid" >
			<nav class="navbar navbar-default navbar-fixed-top <?php echo $theme_color; ?>" id="nav" <?php echo ((isset($_SESSION['logo_name']))?'style="height: 70px;"':''); ?>>
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navMenu" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="fa fa-bars"  style="color: #fff;"></span>
						</button>
					
						<a class="navbar-brand text-white" id="navBrand" href="#" <?php echo ((isset($_SESSION['logo_name']))?'style="padding: 5px;"':''); ?>>
						<?php 
								echo ((isset($_SESSION['logo_name']))?'<img src="assets/images/restaurants-logo/'.$_SESSION['logo_name'].'" id="HeaderLogo" class="img-rounded" height="55px" width="auto"/>':
											((isset($_SESSION['restaurant_id']))?$_SESSION['restaurant']: 'BV Foods')
										 ); 
						?> 
						</a>
					</div>
					
					<div  class="collapse navbar-collapse"  id="navMenu">   
						<ul class="nav navbar-nav navbar-right">
							<?php
								if($action != 'login' || $action != 'menu' || $action != 'place-order')
									echo '<li '.(($action == 'actions')?'class="active"': '').'>
												<a href="index.php?a=actions" style="text-align: center; '.((isset($_SESSION['logo_name']))?'height: 70px;"':'').'">
													<span class="fa fa-home"></span>'.((isset($_SESSION['logo_name']))?'<br>':'&nbsp;').'
													Home
												</a>
											 </li>';
								if(isset($_SESSION['table_id']) && $_SESSION['table_id'] != 0)
									echo '<li '.(($action == 'menu')?'class="active"': '').'>
												<a href="index.php?a=actions" style="text-align: center;  '.((isset($_SESSION['logo_name']))?'height: 70px;"':'').'">
													<span class="fa fa-glass"></span>'.((isset($_SESSION['logo_name']))?'<br>':'&nbsp;').'
													'.$_SESSION['table'].'
												</a>
											 </li>';
								// if(isset($_SESSION['table_id']) && $_SESSION['table_id'] != 0){
									// echo '<li '.(($action == 'place-order')?'class="active"': '').'>
												// <a href="index.php?a=place-order" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle" style="text-align: center;  '.((isset($_SESSION['logo_name']))?'height: 70px;"':'').'">
													// <span class="fa fa-cutlery"></span>'.((isset($_SESSION['logo_name']))?'<br>':'&nbsp;').'
													// Item'.((isset($_SESSION['order']) && count($_SESSION['order']) != 1)?'':'s').' <span id="order_count" class="badge"> '.((isset($_SESSION['order']))?count($_SESSION['order']):' 0').'</span>
												// </a>';
									// echo '</li>';
								// }
								if(isset($_SESSION['user']))
									echo '<li>
												<a href="#" style="text-align: center;  '.((isset($_SESSION['logo_name']))?'height: 70px;"':'').'" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
													<span class="fa fa-user"></span>'.((isset($_SESSION['logo_name']))?'<br>':'&nbsp;').'
													'.$_SESSION['fname'].' '.$_SESSION['lname'].' ('.$_SESSION['role'].') <span class="caret"></span>
												</a>
												<ul class="dropdown-menu '.$theme_light.' sidebar" role="menu">
													'.(($_SESSION['role_id'] == 5)?'<li><a href="index.php?a=login&s=2">Change Restaurant</a></li>':'').'
													<li><a href="#" data-toggle="modal" data-target="#changePass">Change Password</a></li>
													<li><a href="index.php?a=login&s=exit">Logout</a></li>
												</ul>
											 </li>';
							?>
						</ul>
					</div>
				</div>
			</nav>
		</header>
		<header class="container-fluid view"
				<?php
					if (isset($_SESSION['bg_image'])){
						echo 'style ="		background: url(assets/images/restaurants-bg/'.$_SESSION['bg_image'].') no-repeat center center fixed;
									background-size: cover;
									background-attachment: fixed;"';
					}
				?>
			>
				<div class="container-fluid overlay">
					<h3 class="text-center text-white">
						<?php echo ((isset($_SESSION['restaurant_id']))?$_SESSION['restaurant']: 'BV Foods'); ?>
					</h3>
					<div class="line <?php echo $theme_light; ?>" style="width: 15%; margin-left: auto; margin-right: auto;"></div>
					<p class="text-center text-white">
						<?php echo $page_desc; ?>
					</p>
				</div>
		</header>
		<?php
			if ($action == 'login' || $action == 'actions'){}
			else{
				echo '<div style="background-color: #FFFAFA; margin-bottom: -20px; ">
							<ul class="container breadcrumb '.$theme_text.'" style="background-color: #FFFAFA;">
								<li><a href="index.php?a=actions" class="'.$theme_text.'"> Actions</a></li>';
								switch($action){
									case 'actions':
										break;
									case 'cms':
										if(isset($_GET['s'])){							
											switch($_GET['s']){
												case 'menu-new':
													if(isset($_GET['mid']))
														echo '<li><a href="index.php?a=cms&s=menu" class="'.$theme_text.'">Menu</a></li>
																 <li class="active">Edit Menu</li>';
													else
														echo '<li><a href="index.php?a=cms&s=menu" class="'.$theme_text.'">Menu</a></li>
																 <li class="active">New Menu</li>';
													break;
												case 'menu-view':
													echo '<li><a href="index.php?a=cms&s=menu" class="'.$theme_text.'">Menu</a></li>
															 <li class="active">View Menu</li>';
													break;
												case 'menu':
													if(isset($_GET['dmid']))
														echo '<li><a href="index.php?a=cms&s=menu" class="'.$theme_text.'">Menu</a></li>
																 <li class="active">Delete Menu</li>';
													else
														echo '<li class="active">Menus</li>';
													break;
												case 'menu-item':
													if(isset($_GET['iid']))
														echo '<li><a href="index.php?a=cms&s=menu" class="'.$theme_text.'">Menu</a></li>
																 <li><a href="index.php?a=cms&s=menu-view&mid='.$_GET['mid'].'" class="'.$theme_text.'">Menu Item</a></li>
																 <li class="active">Edit Menu Item</li>';
													else
														echo '<li><a href="index.php?a=cms&s=menu" class="'.$theme_text.'">Menu</a></li>
																 <li><a href="index.php?a=cms&s=menu-view&mid='.$_GET['mid'].'" class="'.$theme_text.'">Menu Item</a></li>
																 <li class="active">New Menu Item</li>';
													break;										
												case 'dashboard':
													if(isset($_GET['m']) && $_GET['m'] != 'default')
														echo '<li><a href="index.php?a=cms&s=dashboard" class="'.$theme_text.'">Dashboard</a></li>
																  <li class="active">'.ucfirst($_GET['m']).'</li>';
													else
														echo '<li class="active">Dashboard</li>';
													break;
												case 'user':
													if(isset($_GET['duid']))
														echo '<li><a href="index.php?a=cms&s=user" class="'.$theme_text.'">User</a></li>
																 <li class="active">Delete User</li>';
													else
														echo '<li class="active">Users</li>';
													break;
												case 'user-new':
													if(isset($_GET['uid']))
														echo '<li><a href="index.php?a=cms&s=user" class="'.$theme_text.'">User</a></li>
																 <li class="active">Edit User</li>';
													else
														echo '<li><a href="index.php?a=cms&s=user" class="'.$theme_text.'">User</a></li>
																 <li class="active">New User</li>';
													break;
												case 'restaurants':		
													if(isset($_GET['drid']))
														echo '<li><a href="index.php?a=cms&s=restaurants" class="'.$theme_text.'">Restaurant</a></li>
																 <li class="active">Delete Restaurant</li>';
													else
														echo '<li class="active">Restaurant</li>';
													break;
												case 'restaurant-new':
													if(isset($_GET['rid']))
														echo '<li><a href="index.php?a=cms&s=restaurants" class="'.$theme_text.'">Restaurant</a></li>
																 <li class="active">Edit Restaurant</li>';
													else
														echo '<li><a href="index.php?a=cms&s=restaurants" class="'.$theme_text.'">Restaurant</a></li>
																 <li class="active">New Restaurant</li>';
													break;
												case 'restaurant-view':
													echo '<li><a href="index.php?a=cms&s=restaurants" class="'.$theme_text.'">Restaurant</a></li>
															 <li class="active">View Restaurant</li>';
													break;
												case 'table-new':
													if(isset($_GET['iid']))
														echo '<li><a href="index.php?a=cms&s=restaurants" class="'.$theme_text.'">Restaurant</a></li>
																 <li><a href="index.php?a=cms&s=restaurant-view&rid='.$_GET['rid'].'" class="'.$theme_text.'">Restaurant Table</a></li>
																 <li class="active"> Edit Restaurant Table</li>';
													else
														echo '<li><a href="index.php?a=cms&s=restaurants" class="'.$theme_text.'">Restaurant</a></li>
																 <li><a href="index.php?a=cms&s=restaurant-view&rid='.$_GET['rid'].'" class="'.$theme_text.'">Restaurant Table</a></li>
																 <li class="active">New Restaurant Table</li>';
													break;	
											}
										}									
										break;
									case 'place-order':
										echo '<li><a href="index.php?a=menu" class="'.$theme_text.'">Menu</a></li>';
										echo '<li class="active">Place Order</li>';
										break;
									case 'message':
										if(isset($_GET['m']) && $_GET['m'] == 'wait'){
											echo '<li><a href="index.php?a=menu" class="'.$theme_text.'">Menu</a></li>';
											echo '<li><a href="index.php?a=place-order" class="'.$theme_text.'">Place Order</a></li>';
											echo '<li class="active">Order Placed</li>';
										}
										if(isset($_GET['m']) && $_GET['m'] == 'bill'){
											echo '<li class="active">Bill</li>';
										}
										
										if(isset($_GET['m']) && $_GET['m'] == 'feedback'){
											echo '<li class="active">Feedback Sumbitted</li>';
										}
										break;
									default:
										echo '<li class="active">'.ucfirst($action).'</li>';
								}
				echo '	</ul>
						 </div>';
			}
?>
