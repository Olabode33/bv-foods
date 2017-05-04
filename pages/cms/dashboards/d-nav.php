<?php
	
	
	echo '<div class="row">
				<div class="col-xs-12">
					 <p class="pull-right">
						<a href="index.php?a=cms&s=dashboard&m=time&t='.((isset($_GET['t']))?$_GET['t']:'none').'&g='.((isset($_GET['g']))?$_GET['g']:'none').'" 
							class="btn btn-primary btn-xs '.((isset($_GET['m']) && $_GET['m'] == 'time')?'active':'').' '.$theme_color.'">
							<span class="fa fa-hourglass-half"></span> Time
						</a>			
						<a href="index.php?a=cms&s=dashboard&m=quality&t='.((isset($_GET['t']))?$_GET['t']:'none').'&g='.((isset($_GET['g']))?$_GET['g']:'none').'" 
							class="btn btn-primary btn-xs '.((isset($_GET['m']) && $_GET['m'] == 'quality')?'active':'').' '.$theme_color.'">
							<span class="fa fa-gears"></span> Quality
						</a>			
						<a href="index.php?a=cms&s=dashboard&m=customer&t='.((isset($_GET['t']))?$_GET['t']:'none').'&g='.((isset($_GET['g']))?$_GET['g']:'none').'" 
							class="btn btn-primary btn-xs '.((isset($_GET['m']) && $_GET['m'] == 'customer')?'active':'').' '.$theme_color.'">
							<span class="fa fa-users"></span> Customer
						</a>			
						<a href="index.php?a=cms&s=dashboard&m=default&t='.((isset($_GET['t']))?$_GET['t']:'none').'&g='.((isset($_GET['g']))?$_GET['g']:'none').'" 
							class="btn btn-primary btn-xs '.((isset($_GET['m']) && $_GET['m'] == 'default')?'active':'').' '.$theme_color.'">
							<span class="fa fa-reply"></span> Back
						</a>
					 </p>
				</div>
			 </div>';
?>