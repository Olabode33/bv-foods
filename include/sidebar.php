<?php

?>
<h3 class="text-left">&nbsp;</h3>
<ul class="nav nav-pills nav-stacked">
	<li <?php echo (($action == 'home')?'class="active"':'') ;?>>
		<a href="index.php?a=home" id="home" onclick="loading();" style="text-align: left;">
			<i class="fa fa-home"> Home</i>
		</a>
	</li>
	<li <?php echo (($action == 'menu')?'class="active"':'') ;?>>
		<a href="index.php?a=menu" id="menu" onclick="loading();" style="text-align: left;">
			<i class="fa fa-cutlery"> Menu</i>
		</a>
	</li>
	<li <?php echo (($action == 'check-out')?'class="active"':'') ;?>>
		<a href="index.php?a=check-out" id="view" onclick="loading();" style="text-align: left;">
			<i class="fa fa-credit-card"> Check Out</i>
		</a>
	</li>
	<li <?php echo (($action == 'edit')?'class="active"':'') ;?>>
		<a href="index.php?a=survey" id="edit" onclick="loading();" style="text-align: left;">
			<i class="fa fa-check-square-o"> Survey</i>
		</a>
	</li>
</ul>