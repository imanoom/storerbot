<?php

	require_once '../../connection/DB.class.php';
	$configFile = include('../../config/app.conf');
	
	session_start();
	
	$db = Database::getInstance();
	$mysqli = $db->getConnection(); 
				
	$sql_query = "UPDATE orders SET note='".base64_encode($_POST['note'])."' WHERE orderId='".$_POST['orderId']."'";
	$result = $mysqli->query($sql_query);

	if($result == 1) {
		header( "location: ../view.php?orderId=".$_POST['orderId']."&result=success" );
		exit(0);
	} else {
		header( "location: ../view.php?orderId=".$_POST['orderId']."&result=success" );
		exit(0);
	}

?>