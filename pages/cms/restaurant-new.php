<?php
	include 'app/cls-restaurant.php';
	include 'utility/utility.php';
	$utility_obj = New Utility();
	$restaurant_obj = New Restaurant();
	
	$mode = 'new';
	$rid = 0;
	
	if(isset($_GET['rid'])) {
		$rid = $_GET['rid'];
		$restaurant_info = $restaurant_obj->getAll($rid);
		$restaurant_info = $restaurant_info[0];
		//print_r($restaurant_info);
		$mode = 'get';
	}
	
	if(isset($_POST['r'])){
		if($_POST['r'] == 'new'){
			$newid = $restaurant_obj->add_restaurant();
			if($newid > 0){
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-success">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>New</strong> record added.
															  </div>';
				header('Location: index.php?a=cms&s=restaurants');
			}
			else {
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-danger">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																Error adding new record: '.$newid.'
															  </div>';
				header('Location: index.php?a=cms&s=restaurants');
			}
		}
		if($_POST['r'] == 'edit'){
			$rows = $restaurant_obj->update_restaurant($rid);
			if($rows > 0){
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-success">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>'.$rows.'</strong> record(s) updated.
															  </div>';
				header('Location: index.php?a=cms&s=restaurants');
			}
			else {
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-danger">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																Error update record: '.$rows.'
															  </div>';
				header('Location: index.php?a=cms&s=restaurants');
			}
		}
	}

?>
<h3><?php echo (($rid > 0)? '<span class="fa fa-pencil"></span> Edit Restaurant\'s Information': '<span class="fa fa-plus"></span> Add New Restaurant'); ?></h3>
<div class="<?php echo $theme_color; ?> line"></div>	
<a class="btn btn-sm btn-primary pull-right <?php echo $theme_color; ?>" href="index.php?a=cms&s=restaurants"><span class="fa fa-reply"></span> Go Back</a>
<div class="col-lg-10">
<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?a=cms&s=restaurant-new'.((isset($_GET['rid']))?'&rid='.$rid:''); ?>" method="post" enctype="multipart/form-data" name="form_menu" id="form_menu">
	<fieldset>		
		<div class="form-group">
			<label for="restaurant_name" class="col-lg-2 control-label">Restaurant Name</label>
			<div class="col-lg-10">
				<input type="text" class="form-control" id="restaurant_name" name="restaurant_name" placeholder="*Restaurant Name"  required
					value="<?php  echo ((isset($_POST['r']))?$_POST['restaurant_name']:((isset($_GET['rid']))?$restaurant_info['restaurant']:'')); ?>"/>
				<input type="hidden" name="rid" id="rid" value="<?php  echo ((isset($_POST['r']))?$_POST['rid']:((isset($_GET['rid']))?$rid:'')); ?>" />
				<span class="help-block">
				</span>
			</div>
		</div>
		
		<!-- Hide Upload Image on Edit -->
		<?php 
			if($rid == 0 || (isset($_POST['r']) && $_POST['r'] == 'new')){
		?>
				<div class="form-group">
					<label for="logo" class="col-lg-2 control-label">Logo</label>
					<div class="col-lg-4">
						<input type="file" name="logo" id="logo" class="form-control" value="<?php echo ((isset($_POST['r']) && isset($_POST['r']))?$_POST['logo']:((isset($_GET['rid']))?$restaurant_info['logo']:''))?>">
						<span class="help-block">
							Ensure that you use a vector image or a .png format
						</span>
					</div>
					<label for="bg_image" class="col-lg-2 control-label">Background Image</label>
					<div class="col-lg-4">
						<input type="file" name="bg_image" id="bg_image" class="form-control" value="<?php echo ((isset($_POST['r']) && isset($_POST['r']))?$_POST['bg_image']:((isset($_GET['rid']))?$restaurant_info['bg_image']:''))?>" >
						<span class="help-block">
							Ensure that you use a vector image / .png format with high quality and small size
						</span>
					</div>
				</div>
		<?php
			}
			else{
				//echo '<a class="btn btn-sm btn-primary pull-right '.$theme_color.' disabled" href="#" disabled><span class="fa fa-file-image-o"></span> Change Logo</a>
					//	  <a class="btn btn-sm btn-primary pull-right '.$theme_color.' disabled" href="#" disabled><span class="fa fa-picture-o"></span> Change Background Image</a>';
			}
		?>
		
		<div class="form-group">
			<label for="theme_id" class="col-lg-2 control-label">Theme Color</label>
			<div class="col-lg-10">
				<?php
					$get_colors = $utility_obj->get_theme_colors();
					
					foreach($get_colors as $theme){
						echo '<div class="col-xs-1">
									<div class="form-animate-radio">
										<label class="radio">
											<input id="theme'.$theme['theme_id'].'" type="radio" name="theme_id" value="'.$theme['theme_id'].'" '.((isset($_POST['r']) || isset($_GET['rid']) && $restaurant_info['theme_id'] == $theme['theme_id'])?'checked':'').' >
											<span class="outer" style="background-color: '.$theme['theme_hex'].'">
												<span class="inner" style="background-color: '.$theme['theme_hex'].'"></span>
											</span>
										</label>
									</div>
								 </div>';
					}
				?>
			</div>
		</div>
		
		<div class="form-group">
			<label for="crop_img" class="col-lg-2 control-label">Address</label>
			<div class="col-lg-10">
				<textarea name="address" id="address" rows="3" class="form-control">
					<?php echo ((isset($_POST['r']))?$_POST['address']:((isset($_GET['rid']))?$restaurant_info['address']:''))?>
				</textarea>
			</div>
		</div>

		<div class="form-group">
			<label for="state" class="col-lg-2 control-label">State</label>
			<div class="col-lg-4">
				<?php
					if(isset($restaurant_info))
						$e_state_id = $utility_obj->getObjectFromID('tbl_regions', 'state_id', 'region', $restaurant_info['region']);
					$utility_obj->LoadSelect('tbl_states', 'state', 'state_id', 'state', ((isset($_POST['r']))?$_POST['state']:((isset($_GET['rid']))?$e_state_id:'')));
				?>
			</div>
			<label for="region" class="col-lg-2 control-label">Region</label>
			<div class="col-lg-4">
				<?php
					if(isset($restaurant_info))
						$e_region_id = $utility_obj->getObjectFromID('tbl_regions', 'region_id', 'region', $restaurant_info['region']);
					$utility_obj->LoadSelect('tbl_regions', 'region', 'region_id', 'region', ((isset($_POST['r']))?$_POST['region']:((isset($_GET['rid']))?$e_region_id:'')));
				?>
				<span class="help-block">
					Filtered based on state
				</span>
			</div>
		</div>
		
		<div class="form-group">
			<label for="phone" class="col-lg-2 control-label">Phone</label>
			<div class="col-lg-4">
				<input type="text" class="form-control" id="phone" name="phone" placeholder="xxxx-xxx-xxxx"  pattern="\d{4}[\-]\d{3}[\-]\d{4}"
					value="<?php  echo ((isset($_POST['r']))?$_POST['phone']:((isset($_GET['rid']))?$restaurant_info['phone']:'')); ?>"/>
			</div>
			<label for="email" class="col-lg-2 control-label">Email</label>
			<div class="col-lg-4">
				<input type="email" class="form-control" id="email" name="email" placeholder="Email" 
					value="<?php  echo ((isset($_POST['r']))?$_POST['email']:((isset($_GET['rid']))?$restaurant_info['email']:'')); ?>"/>
			</div>
		</div>
		
		<div class="form-group">
		   	<div class="col-lg-10 col-lg-offset-2">
				<button type="submit" class="btn btn-primary btn-sm <?php echo $theme_color; ?>" name="r" id="r" value="<?php echo ((isset($_GET['rid']) || isset($_POST['r']))?'edit':'new'); ?>">
					<?php echo ((isset($_GET['rid']) || isset($_POST['r']))?'Save':'Add'); ?> <i class="fa fa-send"></i>
				</button>
			</div>
		</div>
	</fieldset>

</form>
</div>

<script>
	$('#state')
</script>

