	<!-- Footer -->
	<footer class="<?php echo $theme_color; ?>" style="min-height: 70px;">
		<div class="<?php echo $theme_light; ?>">
			<div class="container" style="color: #fff; padding-top: 10px; margin-bottom:10px;">
				<div class="row" style="margin-bottom: 20px;">
					<!--Left Column -->
					<div class="col-sm-6">
						<h5>Our Mission</h5>
						<p>
							Bringing your favourite meals from different restaurant to one platform, and make it easier for you to find.
						</p>
						<span class="">
							<a href="#" class="text-white" style="text-decoration: underline">Privacy Policy</a> |
							<a href="#" class="text-white" style="text-decoration: underline">Term of Use</a> |
							<a href="#" class="text-white" style="text-decoration: underline">Site Map</a> |
							<a href="#" class="text-white" style="text-decoration: underline">Support</a> |
							<a href="#" class="text-white" style="text-decoration: underline">Contact Us</a>
						</span>
					</div>
					<!--Mid Column -->
					<div class="col-sm-3">
						<h5>Follow Us</h5>
						<a href="#" class="text-white" style="font-size: 30px; margin-right:10px;"><span class="small fa fa-twitter-square"></span></a>
						<a href="#" class="text-white" style="font-size: 30px; margin-right:10px;"><span class="small fa fa-facebook-square"></span></a>
						<a href="#" class="text-white" style="font-size: 30px; margin-right:10px;"><span class="small fa fa-instagram"></span></a>
						<a href="#" class="text-white" style="font-size: 30px; margin-right:10px;"><span class="small fa fa-google-plus-square"></span></a>
					</div>
					<!-- Right Column -->
					<div class="col-sm-3 text-right">
						<h5>Would you like to sign up</h5>
						<a href="#" class="btn btn-default <?php echo $theme_color; ?>"><span class="small fa fa-users"></span> Customer</a>
						<a href="#" class="btn btn-default <?php echo $theme_color; ?>">Restaurant <span class="small fa fa-chevron-right"></span></a>
					</div>
				</div>
			</div>
		</div>
		<div class="container" style="color: #fff; margin-top: 10px;">	
			<p class="row">
				<!--Left Column -->
				<span class="col-xs-4">
					<i class="fa fa-copyright"></i> 
					<?php 
						date_default_timezone_set("Africa/Lagos");
						//echo date_default_timezone_get();
						$copyyear = '2017'; 
						$curyear = date("Y");
						echo $copyyear.(($curyear > $copyyear)?' - '.$curyear:'');
					?> 
					Powered By <b>BV Foods</b>
				</span>
				<!--Mid Column -->
				
				<!-- Right Column -->
				<span class="pull-right">Icons made by Freepik from www.flaticon.com</span>
			</p>
		</div>
	</footer>
	<!-- End Footer -->
	
	<?php
			require_once 'include/modals.php';
	?>
	
	<script type="application/javascript" src="assets/js/my-script.js"></script>	
</body>
</html>