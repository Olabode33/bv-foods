	<!--div class="row"-->
		
<div class="jumbotron">
	<h1>
		<small class="text-success">Welcome! to</small><br>
		<?php echo ((isset($_SESSION['restaurant_id']))?$_SESSION['restaurant']:'Mahō'); ?>
	</h1>
	<p>
		Where all you magical needs would be met<br>
		<!--Note:: Some of your stuff might get destroyed a little but nothing major ... hopefully-->
	</p>
	<p>
		<a href="index.php?a=menu" class="btn btn-primary btn-lg"> 
			View Our Menu 
			<span class="fa fa-cutlery"></span> 
		</a>
	</p>
</div>
	<!--/div-->
		