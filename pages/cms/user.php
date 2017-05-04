	<?php 
	include 'app/cls-users.php';
	include 'utility/utility.php';
	
	$utility_obj = New Utility();
	$user_obj = New User();
	
	if(isset($_GET['duid'])){
		$rows = $user_obj->remove_user($_GET['duid']);
		//echo $rows
		if($rows > 0){
			$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-success">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>'.$rows.'</strong> records deleted.
														  </div>';
			header('Location: index.php?a=cms&s=user');
		}
		else{
			$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-warning">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>'.$rows.'</strong> records deleted.
														  </div>';
			header('Location: index.php?a=cms&s=user');
		}
		
	}
	
	if(isset($_POST['change_pass'])){
		$change = $user_obj->change_password();
		
			$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-success">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																Password changed successfully. Please login again
														  </div>';
			header('Location: index.php?a=login&s=exit');
	}
	
?>
<h3><span class="fa fa-users"></span> Users</h3>
<div class="<?php echo $theme_color; ?> line"></div>	
<a class="btn btn-sm btn-primary pull-right <?php echo $theme_color; ?>" href="index.php?a=actions"><span class="fa fa-reply"></span> Go Back</a>
<a class="btn btn-sm btn-primary <?php echo $theme_color; ?>" href="index.php?a=cms&s=user-new"><span class="fa fa-plus"></span> Add New User</a><br>
<table class="table table-hover">
	<thead>
		<th class="col-sm-1">S/n</th>
		<th class="col-xs-3 col-sm-3">Name</th>
		<th class="col-xs-2 col-sm-2">Role</th>
		<th class="col-xs-2 col-sm-2">Actions</th>
	</thead>
	<tbody>
	<?php 
		$users = $user_obj->getAll('r');
		$count = 1;
		
		foreach($users as $user){
			echo '<tr>
						<td>'.$count.'</td>
						<td>'.$user['fname'].' '.$user['lname'].'</td>
						<td>'.$user['role'].'</td>
						<td>
							<a href="index.php?a=cms&s=user-new&uid='.$user['user_id'].'" class="btn btn-sm btn-primary '.$theme_color.'"><span class="fa fa-pencil"></span> Edit</a>
							<!--a href="index.php?a=cms&s=user&duid='.$user['user_id'].'" class="btn btn-sm btn-primary '.$theme_color.'"><span class="fa fa-trash"></span> Delete</a-->
							<button class="btn btn-sm btn-primary '.$theme_color.'" data-toggle="modal" data-target="#deleteItem" data-title="Delete User" 
								data-msg="Are you sure you want to delete the user '.$user['fname'].' '.$user['lname'].'?" 
								data-link="index.php?a=cms&s=user&duid='.$user['user_id'].'">
								<span class="fa fa-trash"></span> Delete
							</button>
						</td>
					</tr>';
					
			$count++;
		}
	?>
	</tbody>
</table>