	<p><span class="fa fa-filter"></span> Filter</p>
	<select class="btn btn-primary btn-block <?php echo $theme_color; ?>" onchange="filter('age');">
		<option value="none">- Select Age Group -</option>	
		<option value="1" <?php echo ((isset($_GET['t']) && $_GET['t'] == '1')?'selected':''); ?> ><12</option>	
		<option value="2" <?php echo ((isset($_GET['t']) && $_GET['t'] == '2')?'selected':''); ?> >13-19</option>	
		<option value="3" <?php echo ((isset($_GET['t']) && $_GET['t'] == '3')?'selected':''); ?> >20-40</option>	
		<option value="4" <?php echo ((isset($_GET['t']) && $_GET['t'] == '4')?'selected':''); ?> >41-58</option>	
		<option value="5" <?php echo ((isset($_GET['t']) && $_GET['t'] == '5')?'selected':''); ?> >>59</option>	
	</select>
	
	<select class="btn btn-primary btn-block <?php echo $theme_color; ?>" onchange="filter('gender');">
		<option value="none">- Select Gender -</option>	
		<option value="M" <?php echo ((isset($_GET['g']) && $_GET['g'] == 'M')?'selected':''); ?> >Male</option>	
		<option value="F" <?php echo ((isset($_GET['g']) && $_GET['g'] == 'F')?'selected':''); ?> >Female</option>
	</select>
	<hr>