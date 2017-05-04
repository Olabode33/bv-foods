<?php 
	session_start();
	
	if(!isset($title))
		$title = "";
	else
		$title = $title." - ";
	
	$theme = 6;
	if(isset($_SESSION['theme_id']))
		$theme = $_SESSION['theme_id'];
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $title;?>Restaurants</title>
	<meta name="keywords" content="Restaurant App BV Foods" />
	<meta name="description" content="" />
	<meta name="Author" content="Olabode33">

	<!-- CSS -->
	<!--Bootstrap Template: https://bootswatch.com/united/     (Modified)-->
	<link rel="stylesheet" type="text/css" href="assets/css/mystyle.css">
	<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css"/>
	<link rel="stylesheet" type="text/css" href="assets/css/cropper.css"/>
	<!--link rel="stylesheet" type="text/css" href="assets/css/awesome-bootstrap-checkbox.css"--/>
	
	<!-- Load Restaurant's Theme -->
	<?php
		switch($theme){
			case '1':
				echo '<link rel="stylesheet" type="text/css" href="assets/css/theme/theme1.orange.bootstrap.min.css"/>';
				break;
			case '2':
				echo '<link rel="stylesheet" type="text/css" href="assets/css/theme/theme2.turquoise.bootstrap.min.css"/>';
				break;
			case '3':
				echo '<link rel="stylesheet" type="text/css" href="assets/css/theme/theme3.emerald.bootstrap.min.css"/>';
				break;
			case '4':
				echo '<link rel="stylesheet" type="text/css" href="assets/css/theme/theme4.peterriver.bootstrap.min.css"/>';
				break;
			case '5':
				echo '<link rel="stylesheet" type="text/css" href="assets/css/theme/theme5.amethyst.bootstrap.min.css"/>';
				break;
			case '6':
				echo '<link rel="stylesheet" type="text/css" href="assets/css/theme/theme6.wetasphalt.bootstrap.min.css"/>';
				break;
			case '7':
				echo '<link rel="stylesheet" type="text/css" href="assets/css/theme/theme7.sunflower.bootstrap.min.css"/>';
				break;
			case '8':
				echo '<link rel="stylesheet" type="text/css" href="assets/css/theme/theme8.carrot.bootstrap.min.css"/>';
				break;
			case '9':
				echo '<link rel="stylesheet" type="text/css" href="assets/css/theme/theme9.alizarin.bootstrap.min.css"/>';
				break;
			case '10':
				echo '<link rel="stylesheet" type="text/css" href="assets/css/theme/theme10.concrete.bootstrap.min.css"/>';
				break;
			
			default:
				echo '<link rel="stylesheet" type="text/css" href="assets/css/theme/theme6.wetasphalt.bootstrap.min.css"/>';
		}	
	?>

	<!-- Javascript -->
	<script type="application/javascript" src="assets/js/jquery-1.12.0.js"></script>
	<script type="application/javascript" src="assets/js/bootstrap.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.min.js"></script>
	<script type="application/javascript" src="assets/js/chart.bundle.min.js"></script>
	<!--script type="application/javascript" src="assets/js/cropper.min.js"></script-->
	<script type="application/javascript" src="assets/js/cropper.js"></script>
</head>

<body class="container mybody">	
	<div class="<?php echo (($action == 'home')?'homeDiv':(($action == 'actions')?'actionDiv':'centerDiv'));?>" id="contentDiv">
	
		
	<!--Header End-->