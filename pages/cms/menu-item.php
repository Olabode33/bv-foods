<?php
	include 'app/cls-menu.php';
	include 'app/cls-order.php';
	include 'utility/utility.php';
	$utility_obj = New Utility();
	$order_obj = New Order();
	$menu_obj = New Menu();
	
	$mode = 'new';
	$iid = 0;
	
	if(isset($_POST['m']))
		$mode = 'edit';
	
	if(isset($_GET['iid'])){
		$iid = $_GET['iid'];
		$item = $menu_obj->getItemDetails($iid);
		$mid = $item['menu_id'];
	}
	
	// echo '<pre>';
	// print_r($_POST);
	// print_r($_FILES);
	// echo '</pre>';
	
	if(isset($_POST['m'])){
		if($_POST['m'] == 'new'){
			//Function in Class is incomplete
			$newid = $menu_obj->add_item($_GET['mid']);
			if($newid > 0){
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-success">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>New</strong> record added.
															  </div>';
				header('Location: index.php?a=cms&s=menu-view&mid='.$_GET['mid']);
			}
			else {
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-danger">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																'.$newid.'
															  </div>';
				header('Location: index.php?a=cms&s=menu-view&mid='.$_GET['mid']);
			}
		}
		if($_POST['m'] == 'edit'){
			//Function in class is incomplete
			$rows = $menu_obj->update_item();
			if($rows > 0){
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-success">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																<strong>'.$rows.'</strong> record(s) updated.
															  </div>';
				header('Location: index.php?a=cms&s=menu-view&mid='.$_GET['mid']);
			}
			else {
				$_SESSION['feedback'] = '<div class="alert alert-dismissible alert-danger">
																<button type="button" class="close" data-dismiss="alert">&times;</button>
																'.$rows.'
															  </div>';
				header('Location: index.php?a=cms&s=menu-view&mid='.$_GET['mid']);
			}
		}
	}
	
?>
<h3><?php echo (($iid > 0)? '<span class="fa fa-pencil"></span> Edit Menu Item': '<span class="fa fa-plus"></span> Add New Menu Item'); ?></h3>
<div class="<?php echo $theme_color; ?> line"></div>	
<a class="btn btn-sm btn-primary pull-right <?php echo $theme_color; ?>" href="index.php?a=cms&s=menu-view&mid=<?php echo ((isset($_GET['mid']))?$_GET['mid']:$item['menu_id']); ?>"><span class="fa fa-reply"></span> Go Back</a>
<div class="col-lg-10">
	<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'].'?a=cms&s=menu-item&mid='.((isset($_GET['mid']))?$_GET['mid']:$mid).((isset($_GET['iid']))?'&iid='.$iid:''); ?>" method="post" enctype="multipart/form-data" name="menu_item_form" id="menu_item_form">
		<fieldset>
			<div class="form-group">
				<label for="menu_name" class="col-lg-2 control-label">Item Name</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="item_name" placeholder="Item Name"  name="item_name"
						value="<?php  echo ((isset($_POST['m']))?$_POST['item_name']:((isset($_GET['iid']))?$item['menu_item']:'')); ?>"/>
					<input type="hidden" class="form-control" id="iid" placeholder="Item Name"  name="iid" value="<?php echo $iid; ?>"/>
					<input type="hidden" class="form-control" id="mid" placeholder="Item Name"  name="mid" value="<?php echo ((isset($_GET['mid']))?$_GET['mid']:$mid); ?>"/>
				</div>
			</div>
			<div class="form-group">
				<label for="price" class="col-lg-2 control-label">Price (₦)</label>
				<div class="col-lg-4">
					<input type="number" class="form-control" id="price" name="price" placeholder="Price (₦)" 
						value="<?php  echo ((isset($_POST['m']))?$_POST['price']:((isset($_GET['iid']))?$item['price']:'')); ?>"/>
				</div>
				<label for="time" class="col-lg-2 control-label">Estimated Preparation Time (mins)</label>
				<div class="col-lg-4">
					<input type="number" class="form-control" id="time" name="time" placeholder="Estimated Preparation Time (mins)" 
						value="<?php  echo ((isset($_POST['m']))?$_POST['time']:((isset($_GET['iid']))?$item['time']:'')); ?>"/>
				</div>
			</div>
			<div class="form-group">
				<label for="price" class="col-lg-2 control-label">Notes</label>
				<div class="col-lg-10">
					<textarea id="note" name="note" rows="3" class="form-control col-lg-10"><?php  echo ((isset($_POST['m']))?$_POST['note']:((isset($_GET['iid']))?$item['note']:'')); ?></textarea>
				</div>
			</div>
			<?php 
				if($iid == 0){
					// echo '<div class="form-group">
									// <label for="price" class="col-lg-2 control-label">Image</label>
									// <div class="col-lg-10">
										// <input type="file" name="img" id="img" class="col-lg-10 form-control" value="'.((isset($_POST['m']))?$_POST['img']:((isset($_GET['iid']))?$item['image']:'')).'">
										// <span class="help-block">
											// Ensure that the image is 400x350
										// </span>
									// </div>
								// </div>';
								
					echo '<div class="form-group">
									<label for="crop_img" class="col-lg-2 control-label">Image</label>
									<div class="col-lg-10">
										<input type="file" name="img" id="img" class="col-lg-10 form-control" value="'.((isset($_POST['m']))?$_POST['img']:((isset($_GET['iid']))?$item['image']:'')).'"  onChange="read2URL(this);">
										<input type="hidden" name="dataX" id="dataX" value="0" />
										<input type="hidden" name="dataY" id="dataY" value="0" />
										<input type="hidden" name="dataH" id="dataH" value="0" />
										<input type="hidden" name="dataW" id="dataW" value="0" />
										<div class="img-container">
											<img id="to_crop" src="#" alt="Select an Image" />
										</div>
										<div id="cropped_img" class="img-preview"></div>
										
									</div>
								</div>';
				}
				else {
					// echo '<div class="form-group">
									// <label for="price" class="col-lg-2 control-label">Image</label>
									// <div class="col-lg-10">
										// <img src="assets/images/menu-items/'.$item['image'].'" class="img-responsive img-thumbnail"/>
										// &nbsp;<a class="btn btn-primary">Change</a>
										// &nbsp;<a class="btn btn-primary">Delete</a>
									// </div>
								// </div>';
				}
			?>
			<div class="form-group">
				<div class="col-lg-10 col-lg-offset-2">
						<!--button type="reset" class="btn btn-default"><i class="glyphicon glyphicon-erase"></i> Clear</button-->
					<button type="submit" class="btn btn-sm btn-primary <?php echo $theme_color; ?>" name="m" id="m" value="<?php echo ((isset($_GET['iid']) || isset($_POST['m']))?'edit':'new'); ?>">
						<?php echo ((isset($_GET['iid']) || isset($_POST['m']))?'Save':'Add'); ?> <i class="fa fa-send"></i>
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
				dragMode: 'drag',
				aspectRatio: 4/3,
				autoCropArea: 0.65,
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
				var form = $('#menu_item_form').serialize();
				var formData = new FormData();
				//formData.append('img', blob);
				
				// cropper.getCroppedCanvas().toBlob(function (blob){
					// var form = $('#menu_item_form').serialize();
					// var formData = new FormData();
					
					// formData.append('img', blob);
					
				var formAction = $('#menu_item_form').attr('action');
					
					// console.log(formData);
					
				$.ajax({
					url: formAction,
					method: "POST",
					data: formData,
					processData: false,
					contentType: false,
					success: function(data) {
						//alert('Upload success');
					},
					error: function(data) {
						//alert('Upload error');
					}
				});
				// });
				
				//e.preventdefault();
			});

		}
		
		// $('menu_item_form').on('submit', function(){
			// alert('Submitting form');
			// var form = $(this).serialize();
			// var formName = form
			// var formData = new FormData();
	
			// formData.append('img', blob);
			
			// var formAction = form.attr('action');
			
			// $.ajax({
				// url: formAction,
				// method: "POST",
				// data: formData,
				// processData: false,
				// contentType: false,
				// success: function(data) {
					// alert('Upload success');
				// },
				// error: function(data) {
					// alert('Upload error');
				// }
			// });
		// });
		
		
</script>