<?php 
	session_start();
	require_once 'cls-order.php';
	
	$order_obj = new Order();
	
	switch($_GET['data']){
		case 'order_count':
			echo (isset($_SESSION['order']))?count($_SESSION['order']):' 0';
			break;
			
		case 'order_status':
			if(isset($_SESSION['order_key'])){
				echo $order_obj->getOrderStatus($_SESSION['order_key']);
			}
			else
				echo 'No Order has been placed';
			break;
			
		case 'update_plate':
			if(isset($_GET['item']) && isset($_GET['qty'])){
				echo $order_obj->updatePlateQuantity($_GET['item'], $_GET['qty']);
			}
			break;
			
		default:
			echo 'No Data to process';
			break;
	}
?>