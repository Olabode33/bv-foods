	<!--div class="row"-->
<?php
	include 'app/cls-table.php';
	include 'app/cls-order.php';
	include 'utility/utility.php';
	include 'app/cls-login-mgr.php';
	include 'app/cls-restaurant.php';
	$login_obj = new LoginMgr();
	$tbl_obj = new Table();
	$order_obj = new Order();
	$utility_obj = new Utility();
	$restaurant_obj = new Restaurant();
	
	$step = 1;
	if(isset($_GET['s'])){
		$step = $_GET['s'];
		
		//echo $step;
		
		//Change password
		if(isset($_POST['change_pass'])){
			//include 'app/cls-users.php';
			$user_obj = new User();
			
			$change = $user_obj->change_password();
			
			echo $_POST['action'].'<br>'.$_POST['step'];
			
			
			if($change > 0){
				$login_obj->logout();
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-success">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																Password changed successfully. Please login again
															 </div>';				
				header('Location: index.php');
			}
			else {
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-danger">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																Error: Unable to change password.
														  </div>';
				header('Location: index.php?a='.$_POST['action'].'&s='.$_POST['step']);
			}
		}
		else{
			//echo 'Not changing password';
		}
		
		//Logout
		if($step == 'exit'){
			$login_obj->logout();
			header ('Location: index.php');
		}
	}
	else 
		$step = 1;
	
	if(isset($_POST['login']) && $_GET['a'] == 'login'){
		
		//Set Restaurant
		if ($_POST['login'] == 'r'){			
			if($login_obj->login()){
				if($_SESSION['role_id'] == 5)
					header ('Location: index.php?a=login&s=2');
				else
					header ('Location: index.php?a=actions');
			}
			else {
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-warning">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																Wrong Username or password.
															  </div>';				
				header('Location: index.php');
			}
		}
		
		//Set Table
		if($_POST['login'] == 't'){
			if($login_obj->setRestaurant()){
				header ('Location: index.php?a=actions');
			}
			else
				header ('Location: index.php?a=login&s=2');
		}
		
		unset($_POST['login']);
	}
?>		
<div class="container page">
	<div class="col-md-6 col-md-offset-3 well">
		<form class="form-horizontal" action="index.php?a=login" method="post">
			<field>
				<legend>
					<span class=""><?php echo ($step == 1?'Enter Login Details':'Select a restaurant'); ?></span>
				</legend>
				<?php 
					if($step == 1) {
					?>
						<div class="form-group">
							<div class="col-lg-12">
								<div class="input-group">
									<span class="input-group-addon" ><span class="fa fa-user"></span></span>
									<input type="text" class="form-control" id="uname" name="uname" placeholder="Enter Your Username" required="true">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12">
								<div class="input-group">
									<span class="input-group-addon" ><span class="fa fa-key"></span></span>
									<input type="password" class="form-control" id="pass" name="pass" placeholder="Enter Your Password" required="true">
								</div>
							</div>
						</div>
					<?php
					}
					elseif($step == 2) {
					?>
						<div class="form-group">
							<div class="col-lg-12">
								<div class="input-group">
									<span class="input-group-addon" ><span class="fa fa-cutlery"></span></span>
									<input type="hidden" id="type" name="type" value="<?php echo ((isset($_GET['ref']))?$_GET['ref']:'order')?>" >
									<select  name="restaurant" id="restaurant" class="form-control" required>
										<option value="">-- Select a restuarant --</option>
										<?php
											$restaurants = $restaurant_obj->getAll();
												
											foreach($restaurants as $restaurant) {
												if($restaurant['id'] != 4) 	// Exclude BV Foods 
													echo '<option value="'.$restaurant['id'].'">'.$restaurant['restaurant'].'</option>';
											}
										?>
									</select>
								</div>
							</div>
						</div>
					<?php
					}
					elseif($step == 3) {
						$orders = $order_obj->getOrderSummary(3);
						foreach($orders as $order){
							echo '<a href="index.php?a=bill&ok='.$order['order_key'].'" class="btn btn-primary btn-block btn-lg">
										<span class="fa fa-cutlery"></span>
										'.$utility_obj->getObjectFromID('tbl_tables', 'table_name', 'table_id', $order['table_id']).'
									 </a><br>';
						}					
					}
					
					if($step != 3)
						echo '<div class="form-group">
									<div class="col-lg-12">
										<button type="submit" class="btn btn-primary pull-right '.$theme_color.'" name="login" id="login" value="'. (($step == 1)?'r':'t').'">
											'. (($step == 1)?'Login':'Select').'
											<span class="fa fa-chevron-circle-right"></span>
										</button>
									</div>
								</div>';
				?>
				
				<!--div class="form-group">
					<div class="input-group">
						<span class="input-group-addon" ><span class="fa fa-key"></span></span>
						<input type="password" class="form-control" id="inputPassword" placeholder="Password">
					</div>
				</div-->
			</field>
		</form>
	</div>
</div>
		