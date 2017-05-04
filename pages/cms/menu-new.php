<?php
	include 'app/cls-menu.php';
	include 'app/cls-order.php';
	include 'utility/utility.php';
	$utility_obj = New Utility();
	$order_obj = New Order();
	$menu_obj = New Menu();
	
	$mode = 'new';
	$mid = 0;
	
	if(isset($_GET['mid'])) {
		$mid = $_GET['mid'];
		$mode = 'get';
	}
	if(isset($_POST['m'])){
		if($_POST['m'] == 'new'){
			$newid = $menu_obj->add_menu();
			if($newid > 0){
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-success">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>New</strong> record added.
															  </div>';
				header('Location: index.php?a=cms&s=menu');
			}
			else {
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-danger">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																'.$newid.'
															  </div>';
				header('Location: index.php?a=cms&s=menu');
			}
		}
		if($_POST['m'] == 'edit'){
			$rows = $menu_obj->update_menu();
			if($rows > 0){
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-success">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>'.$rows.'</strong> record(s) updated.
															  </div>';
				header('Location: index.php?a=cms&s=menu');
			}
		}
	}

?>
<h3><?php echo (($mid > 0)? '<span class="fa fa-pencil"></span> Edit Menu': '<span class="fa fa-user-plus"></span> Add New Menu'); ?></h3>
<div class="<?php echo $theme_color; ?> line"></div>	
<a class="btn btn-sm btn-primary pull-right <?php echo $theme_color; ?>" href="index.php?a=cms&s=menu"><span class="fa fa-reply"></span> Go Back</a>
<div class="col-lg-10">
<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?a=cms&s=menu-new'.((isset($_GET['mid']))?'&mid='.$mid:''); ?>" method="post" enctype="multipart/form-data" name="form_menu" id="form_menu">
	<fieldset>	
		<div class="form-group">
			<label for="menu_name" class="col-lg-2 control-label">Menu Name</label>
			<div class="col-lg-10">
				<input type="text" class="form-control" id="menu_name" name="menu_name" placeholder="Menu Name" 
					value="<?php  echo ((isset($_POST['m']))?$_POST['menu_name']:((isset($_GET['mid']))?$utility_obj->getObjectFromID('tbl_menus', 'menu_name', 'menu_id', $mid):'')); ?>"/>
				<input type="hidden" name="mid" id="mid" value="<?php  echo ((isset($_POST['m']))?$_POST['mid']:((isset($_GET['mid']))?$mid:'')); ?>" />
				<span class="help-block">
					<?php
						if(isset($_GET['mid']) || isset($_POST['m']))
							echo 'The menu belongs to '.$utility_obj->getObjectFromID('tbl_restaurants', 'restaurants', 'id', $_SESSION['restaurant_id']);
						else
							echo 'This menu would be added to '.$utility_obj->getObjectFromID('tbl_restaurants', 'restaurants', 'id', $_SESSION['restaurant_id']);
					?>
				</span>
			</div>
		</div>
		<!--div class="form-group">
			<label for="crop_img" class="col-lg-2 control-label">Image</label>
			<div class="col-lg-10">
				<input type="file" name="img" id="img" class="col-lg-10 form-control" value="'.((isset($_POST['m']))?$_POST['img']:((isset($_GET['iid']))?$item['image']:'')).'"  onChange="read2URL(this);">
				<input type="hidden" name="dataX" id="dataX" value="0" />
				<input type="hidden" name="dataY" id="dataY" value="0" />
				<input type="hidden" name="dataH" id="dataH" value="0" />
				<input type="hidden" name="dataW" id="dataW" value="0" />
				<div class="img-container">
					<img id="to_crop" src="#" alt="No Image selected" />
				</div>
				<div id="cropped_img" class="img-preview"></div>
			</div>
		</div-->
		<div class="form-group">
		   	<div class="col-lg-10 col-lg-offset-2">
				<button type="submit" class="btn btn-primary btn-sm <?php echo $theme_color; ?>" name="m" id="m" value="<?php echo ((isset($_GET['mid']) || isset($_POST['m']))?'edit':'new'); ?>">
					<?php echo ((isset($_GET['mid']) || isset($_POST['m']))?'Save':'Add'); ?> <i class="fa fa-send"></i>
				</button>
			</div>
		</div>
	</fieldset>

</form>
</div>

<script>
		function jsfunction(input) {
			alert('Im here');
		}
	
		function read2URL(input) {
			if(input.files && input.files[0]) {
				var reader = new FileReader();
				console.log('Gap');
				reader.onload =  function(e) {
					$('#to_crop').attr('src', e.target.result);
					console.log('Here!	')
				};
				reader.readAsDataURL(input.files[0]);
				setTimeout(initCropper, 1000);
			}
		}

		window.Cropper;
		
		function initCropper(){
			var image = document.querySelector('#to_crop');
			var dataX = $('#dataX');
			var dataY = $('#dataY');
			var dataH = $('#dataH');
			var dataW = $('#dataW');
			
			var cropper = new Cropper(image, {
				viewMode: 1,
				dragMode: 'crop',
				aspectRatio: 21/9,
				restore: false,
				guides: false,
				center: false,
				highlight: false,
				cropBoxMovable: true,
				cropBoxResizable: true,
				toggleDragModeOnDblclick: false,
				done: function (data) {
					$dataX.val(Math.round(data.x));
					$dataY.val(Math.round(data.y));
					$dataH.val(Math.round(data.height));
					$dataW.val(Math.round(data.width));
				}
			});
			
			document.getElementById('m').addEventListener('click', function(){
				var imgurl = cropper.getCroppedCanvas().toDataURL();
				var img = document.createElement("img");
				img.src = imgurl;
				document.getElementById('cropped_img').appendChild(img);
				
				var cropData = cropper.getData();
				
				dataX.val(Math.round(cropData.x));
				dataY.val(Math.round(cropData.y));
				dataH.val(Math.round(cropData.height));
				dataW.val(Math.round(cropData.width));
				
				console.log(cropData);
				var form = $('#form_menu').serialize();
				var formData = new FormData();
				//formData.append('img', blob);
				
				// cropper.getCroppedCanvas().toBlob(function (blob){
					// var form = $('#menu_item_form').serialize();
					// var formData = new FormData();
					
					// formData.append('img', blob);
					
				var formAction = $('#form_menu').attr('action');
					
					// console.log(formData);
					
				$.ajax({
					url: formAction,
					method: "POST",
					data: formData,
					processData: false,
					contentType: false,
					success: function(data) {
						alert('Upload success');
					},
					error: function(data) {
						alert('Upload error');
					}
				});
				// });
				
				//e.preventdefault();
			});

		}
</script>