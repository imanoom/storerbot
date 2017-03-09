<?php

	require_once '../../Kernel.php';
	
	$db = Database::getInstance($configFile);
	$mysqli = $db->getConnection(); 
	
	$sql_query = "DELETE FROM orders WHERE orderId='".$_GET['orderId']."'";
	$result = $mysqli->query($sql_query);

	if($result == 1) {
		header( "location: ../order.php?result=success" );
		exit(0);
	} else {
		header( "location: ../order.php?result=dbError" );
		exit(0);
	}

?>