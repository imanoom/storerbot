<?php

	require_once '../../connection/DB.class.php';
	$configFile = include('../../config/app.conf');
	
	session_start();
	
	$db = Database::getInstance();
	$mysqli = $db->getConnection(); 
	
	$sql_query = "DELETE FROM orders WHERE orderId='".$_GET['orderId']."'";
	$result = $mysqli->query($sql_query);

	if($result == 1) {
		header( "location: ../listOrder.php?result=success" );
		exit(0);
	} else {
		header( "location: ../listOrder.php?result=dbError" );
		exit(0);
	}

?>