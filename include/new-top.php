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
	<link rel="stylesheet" type="text/css" href="assets/css/theme/theme6.wetasphalt.bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="assets/css/mystyle.css">
	<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css"/>
	<link rel="stylesheet" type="text/css" href="assets/css/cropper.css"/>
	<!--link rel="stylesheet" type="text/css" href="assets/css/awesome-bootstrap-checkbox.css"--/>
	

	<!-- Javascript -->
	<script type="application/javascript" src="assets/js/jquery-1.12.0.js"></script>
	<script type="application/javascript" src="assets/js/bootstrap.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.min.js"></script>
	<script type="application/javascript" src="assets/js/chart.bundle.min.js"></script>
	<!--script type="application/javascript" src="assets/js/cropper.min.js"></script-->
	<script type="application/javascript" src="assets/js/cropper.js"></script>
</head>

<body class="" data-spy="scroll" data-target="#myScrollspy" data-offset="100">	
	<div class="" id="">
		
	<!--Header End-->