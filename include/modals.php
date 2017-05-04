<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" id="yourOrder" aria-labelledby="yourOrderLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title <?php echo $theme_text; ?>">Your Order</h4>
			</div>
			<div class="modal-body">
				<form action="index.php?a=<?php echo $_GET['a'].((isset($_GET['m']))?'&m='.$_GET['m']:''); ?>" method="POST" class="form-horizontal" id="plate">
					<fieldset>
						<img src="assets/images/demo-menu/pexels-small-01.jpeg" class="img-responsive thumbnail"  id="img"/>
						<h3 id="menu_item">Menu Item</h3>
						<input type="hidden" id="item" name="item"/>
						<input type="hidden" id="price" name="price" />
						<p><b>Price:</b> ₦ <span id="txtprice">1,000.00</span></p>
						<p>Serving(s):</p>
						<div class="form-group">
							<div class="col-lg-12">
								<select class="form-control" id="qty" name="qty">
									<option value="1" selected>1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>
							</div>
						</div>	
						<p><b>Total: </b> ₦ <span id="ttlprice">5,000.00</span></p>
						<p><b>Estimated Delivery Time: </b> <span id="etime">2</span> mins</p>
						<div class="form-group">
							<div class="col-lg-12">
								<button type="reset" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary pull-right <?php echo $theme_color; ?>" name="menu" id="menu" value="order">Select <span class="fa fa-check"></span></button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" id="removeOrder" aria-labelledby="yourOrderLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title <?php echo $theme_text; ?>">Remove Order</h4>
			</div>
			<div class="modal-body">
				<form action="index.php?a=<?php echo $_GET['a'].((isset($_GET['m']))?'&m='.$_GET['m']:''); ?>" method="post" class="form-horizontal" id="plate">
					<fieldset>
						<img src="assets/images/demo-menu/pexels-small-01.jpeg" class="img-responsive thumbnail" id="img"/>
						<input type="hidden" id="item" name="item"/>
						<h3 id="menu_item">Menu Item</h3>
						<p><b>Price:</b> ₦<span id="txtprice">1,000.00</span></p>
						<p><b>Serving:</b> <span id="qty">5</span></p>	
						<p><b>Total: </b> ₦<span id="ttlprice">5,000.00</span></p>
						<div class="form-group">
							<div class="col-lg-12">
								<button type="reset" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary pull-right <?php echo $theme_color; ?>" name="menu" id="menu" value="remove"><span class="fa fa-times-circle"></span> Remove Order</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Delete Item Modal -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" id="deleteItem" aria-labelledby="yourItemLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title <?php echo $theme_text; ?>"  id="del_title">Remove Order</h4>
			</div>
			<div class="modal-body">
				<p id="del_msg">Are you sure you want to delete?</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-times"></span> Cancel</a>
				<a href="" class="btn btn-primary pull-right <?php echo $theme_color; ?>" id="del_link" ><span class="fa fa-trash"></span> Continue</a>			
			</div>
		</div>
	</div>
</div>

<!-- Change Password Modal -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" id="changePass" aria-labelledby="yourItemLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title <?php echo $theme_text; ?>"  id="del_title">Change Password</h4>
			</div>
			<div class="modal-body">
				<form action="index.php?a=login&s=pass" method="post" class="form-horizontal" id="change_password">
					<fieldset>
						<div class="form-group">
							<label for="opass" class="col-lg-2 control-label">Current Password</label>
							<div class="col-lg-10">
								<input type="hidden" id="action" name="action" value="<?php echo $action; ?>">
								<input type="hidden" id="step" name="step" value="<?php echo ((isset($_GET['s']))?$_GET['s']:''); ?> ">
								<input type="password" class="form-control" id="opass" name="opass" placeholder="Current Password"  required/>
							</div>
						</div>
						<div class="form-group">
							<label for="npass" class="col-lg-2 control-label">New Password</label>
							<div class="col-lg-10">
								<input type="password" class="form-control" id="npass" name="npass" placeholder="New Password"  required/>
							</div>
						</div>
						<div class="form-group">
							<label for="cpass" class="col-lg-2 control-label">Current Password</label>
							<div class="col-lg-10">
								<input type="password" class="form-control" id="cpass" name="cpass" placeholder="Confirm Password"  required/>
							</div>
							<span class="help-block">
								You would have to login again once the password change is successful
							</span>
						</div>
					</fieldset>
					<div class="form-group">
						<div class="col-lg-12">
							<button type="reset" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary pull-right <?php echo $theme_color; ?>" name="change_pass" id="change_pass" value="change">Change Password <span class="fa fa-chevron-right"></span></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>