<?php
	include 'app/cls-restaurant.php';
	include 'app/cls-order.php';
	include 'utility/utility.php';
	$utility_obj = New Utility();
	$order_obj = New Order();
	$restaurant_obj = New Restaurant();
	
	$mode = 'new';
	$rid = 0;
	$tid = 0;
	
	if(isset($_POST['t']))
		$mode = 'edit';
	
	if(isset($_GET['rid'])){
		$rid = $_GET['rid'];
		//echo $rid;
		
		if(isset($_GET['tid'])){
			$tid = $_GET['tid'];
			//echo $tid;
			$tables = $restaurant_obj->getTables($rid, $tid);
			$table = $tables[0];
			//print_r($table);
		}
	}
	
	if(isset($_POST['t'])){
		if($_POST['t'] == 'new'){
			//Function in Class is incomplete
			$newid = $restaurant_obj->add_table($rid);
			if($newid > 0){
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-success">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>New</strong> record added.
															  </div>';
				header('Location: index.php?a=cms&s=restaurant-view&rid='.$_GET['rid']);
			}
			else {
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-danger">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																'.$newid.'
															  </div>';
				header('Location: index.php?a=cms&s=restaurant-view&rid='.$_GET['rid']);
			}
		}
		if($_POST['t'] == 'edit'){
			$rows = $restaurant_obj->update_table($tid);
			if($rows > 0){
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-success">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>'.$rows.'</strong> record(s) updated.
															  </div>';
				header('Location: index.php?a=cms&s=restaurant-view&rid='.$_GET['rid']);
			}
			else {
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-danger">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																Error Updating Record. '.$rows.'
															  </div>';
				header('Location: index.php?a=cms&s=restaurant-view&rid='.$_GET['rid']);
			}
		}
	}
	
?>
<h3><?php echo (($tid > 0)? '<span class="fa fa-pencil"></span> Edit Table\'s Information': '<span class="fa fa-user-plus"></span> Add New Table'); ?></h3>
<div class="<?php echo $theme_color; ?> line"></div>	
<a class="btn btn-sm btn-primary pull-right <?php echo $theme_color; ?>" href="index.php?a=cms&s=restaurant-view&rid=<?php echo ((isset($_GET['rid']))?$_GET['rid']:$table['restaurant_id']); ?>"><span class="fa fa-reply"></span> Go Back</a>
<div class="col-lg-10">
	<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?a=cms&s=table-new&rid='.((isset($_GET['rid']))?$_GET['rid']:$rid).((isset($_GET['tid']))?'&tid='.$tid:''); ?>" method="post" enctype="multipart/form-data" name="new_table_form" id="new_table_form">
		<fieldset>	
			<div class="form-group">
				<label for="menu_name" class="col-lg-2 control-label">Table Name</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="table_name" placeholder="Table Name"  name="table_name"
						value="<?php  echo ((isset($_POST['t']))?$_POST['table_name']:((isset($_GET['tid']))?$table['table_name']:'')); ?>" required="true"/>
					<input type="hidden" class="form-control" id="tid" placeholder="Table Name"  name="tid" value="<?php echo $tid; ?>"/>
					<input type="hidden" class="form-control" id="rid" placeholder="Restaurant Name"  name="rid" value="<?php echo ((isset($_GET['rid']))?$_GET['rid']:$rid); ?>"/>
				</div>
			</div>
			<div class="form-group">
				<label for="price" class="col-lg-2 control-label">Number of Seats</label>
				<div class="col-lg-4">
					<input type="number" class="form-control" id="no_seats" name="no_seats" placeholder="Number of Seats" 
						value="<?php  echo ((isset($_POST['t']))?$_POST['no_seats']:((isset($_GET['tid']))?$table['no_seats']:'')); ?>"/>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-lg-10 col-lg-offset-2">
					<!--button type="reset" class="btn btn-default"><i class="glyphicon glyphicon-erase"></i> Clear</button-->
					<button type="submit" class="btn btn-primary <?php echo $theme_color; ?>" name="t" id="t" value="<?php echo ((isset($_GET['tid']) || isset($_POST['t']))?'edit':'new'); ?>">
						<?php echo ((isset($_GET['tid']) || isset($_POST['t']))?'Save':'Add'); ?> <i class="fa fa-send"></i>
					</button>
				</div>
			</div>
		</fieldset>
	</form>
</div>