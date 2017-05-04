<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" id="removeOrder" aria-labelledby="yourOrderLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-primary">Remove Order</h4>
			</div>
			<div class="modal-body">
				<form action="index.php?a=check-out" method="post" class="form-horizontal">
					<fieldset>
						<img src="assets/images/demo-menu/pexels-small-01.jpeg" class="img-responsive thumbnail"/>
						<h3>Menu Item</h3>
						<p><b>Price:</b> ₦<span>1,000.00</span></p>
						<p><b>Quantity:</b> <span>5</span></p>	
						<p><b>Total: </b> ₦<span>5,000.00</span></p>
						<div class="form-group">
							<div class="col-lg-12">
								<button type="reset" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary pull-right"><span class="fa fa-times-circle"></span> Remove Order</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>