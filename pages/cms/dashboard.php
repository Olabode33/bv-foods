<?php
	include_once 'app/cls-dashboard.php';
	include_once 'utility/utility.php';

	$util_obj = new Utility();
	$dash_obj = new Dashboard();
	
	if(isset($_GET['t']))
		$age_f = $_GET['t'];
	else
		$age_f = 'none';
	
	if(isset($_GET['g']))
		$gender_f = $_GET['g'];
	else
		$gender_f = 'none';
?>

<h3><span class="fa fa-dashboard"></span> Dashboard <?php echo '<small class="'.$theme_text.'">-  '.ucfirst((!isset($_GET['m']) || $_GET['m'] == 'default')?'summary':$_GET['m']).'</small>';?></h3>
<div class="<?php echo $theme_color; ?> line"></div>	
<div class="row">
	<?php
		$mode = 'default';
		if(isset($_GET['m'])){
			$mode = $_GET['m'];
		}
		
		switch($mode) {
			case 'time':
				include 'pages/cms/dashboards/time.php';
				break;
			case 'quality':
				include 'pages/cms/dashboards/quality.php';
				break;
			case 'customer':
				include 'pages/cms/dashboards/customer.php';
				break;
			default:
				include 'pages/cms/dashboards/default.php';
				break;
		}
	?>
</div>

<script>
	function filter(type){
		var filt = $(event.currentTarget);
		//var opt = filt.val();
	
		switch(type){
			case 'age':
				var age = filt.val();
				var gender = '<?php echo ((isset($_GET['g']))?$_GET['g']:'none'); ?>'; 
			break;
			case 'gender':
				var age = '<?php echo ((isset($_GET['t']))?$_GET['t']:'none'); ?>';
				var gender = filt.val();
			break;
			default:
				var age = '<?php echo ((isset($_GET['t']))?$_GET['t']:'none'); ?>';
				var gender = '<?php echo ((isset($_GET['g']))?$_GET['g']:'none'); ?>';
			break;
		}
		
		window.location.href = 'index.php?a=cms&s=dashboard&m=<?php echo $mode; ?>'+'&t='+age+'&g='+gender;
	}
</script>
