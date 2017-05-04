<?php
	include 'app/cls-users.php';
	include 'utility/utility.php';
	
	$utility_obj = New Utility();
	$user_obj = New User();
	
	$mode = 'new';
	$uid = 0;
	
	if(isset($_GET['uid'])) {
		$uid = $_GET['uid'];
		$user_info = $user_obj->getDetails($uid);
		//$mode = 'get';
	}
	if(isset($_POST['m'])){
		if($_POST['m'] == 'new'){
			$newid = $user_obj->add_user();
			if($newid > 0){
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-success">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>New</strong> record added.
															  </div>';
				header('Location: index.php?a=cms&s=user');
			}
		}
		if($_POST['m'] == 'edit'){
			$rows = $user_obj->update_user($uid);
			if($rows > 0){
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-success">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>'.$rows.'</strong> record(s) updated.
															  </div>';
				header('Location: index.php?a=cms&s=user');
			}
		}
	}

?>

<h3><?php echo (($uid > 0)? '<span class="fa fa-pencil"></span> Edit User\'s Information': '<span class="fa fa-user-plus"></span> Add New User'); ?></h3>
<div class="<?php echo $theme_color; ?> line"></div>	
<a class="btn btn-sm btn-primary pull-right <?php echo $theme_color; ?>" href="index.php?a=cms&s=user"><span class="fa fa-reply"></span> Go Back</a>
<div class="col-lg-10">
	<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?a=cms&s=user-new'.((isset($_GET['uid']))?'&uid='.$uid:''); ?>" method="post" enctype="application/x-www-form-urlencoded" name="form" id="form">
		<fieldset>	
			<div class="form-group">
				<label for="fname" class="col-lg-2 control-label">First Name</label>
				<div class="col-lg-4">
					<input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" value="<?php echo (($uid > 0)? $user_info['fname']:''); ?>" required="true"/>
				</div>
				<label for="lname" class="col-lg-2 control-label">Last Name</label>
				<div class="col-lg-4">
					<input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" value="<?php echo (($uid > 0)? $user_info['lname']:''); ?>" required="true"/>
				</div>
			</div>
			<div class="form-group">
				<label for="uname" class="col-lg-2 control-label">User Name</label>
				<div class="col-lg-4">
					<input type="text" class="form-control" id="uname" name="uname" placeholder="User Name (Login Name)" value="<?php echo (($uid > 0)? $user_info['uname']:''); ?>" required="true"/>
					<input type="hidden" name="mid" id="mid" value="<?php  echo ((isset($_POST['m']))?$_POST['mid']:((isset($_GET['mid']))?$mid:'')); ?>" />
				</div>
			</div>
			<?php
			if($uid == 0)
				echo '<div class="form-group">
							<label for="pass" class="col-lg-2 control-label">Password</label>
							<div class="col-lg-4">
								<input type="password" class="form-control" id="pass" name="pass" placeholder="Password" required="true"/>
							</div>
							<label for="cpass" class="col-lg-2 control-label">Confirm Password</label>
							<div class="col-lg-4">
								<input type="password" class="form-control" id="cpass" name="cpass" placeholder="Confirm Password" required="true"/>
							</div>
						</div>';
			?>
			<div class="form-group">
				<label for="role" class="col-lg-2 control-label">Role</label>
				<div class="col-lg-4">
					<select class="form-control" id="role" name="role" placeholder="" required="true">
						<option value="">-- Select a Role -- </option>
						<option value="1" <?php echo (($uid > 0 && $user_info['role_id'] == 1)? 'selected':''); ?>>Admin</option>
						<option value="2" <?php echo (($uid > 0 && $user_info['role_id'] == 2)? 'selected':''); ?>>Attendant</option>
						<option value="3" <?php echo (($uid > 0 && $user_info['role_id'] == 3)? 'selected':''); ?>>Bar/Chef</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-10 col-lg-offset-2">
					<button type="submit" class="btn btn-primary btn-sm <?php echo $theme_color; ?>" name="m" id="m" value="<?php echo (($uid > 0)? 'edit':'new'); ?>">
						<?php echo (($uid > 0)? 'Save':'Add'); ?> <i class="fa fa-send"></i>
					</button>
				</div>
			</div>
		</fieldset>

	</form>
</div>