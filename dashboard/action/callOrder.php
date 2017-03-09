<?php

	require_once '../../Kernel.php';
	
	$db = Database::getInstance($configFile);
	$mysqli = $db->getConnection(); 
	
	$id = $_GET['id'];
			
	$db = Database::getInstance($configFile);
	$mysqli = $db->getConnection(); 
	$sql_query = "SELECT * FROM orders JOIN users ON orders.userToken = users.lineUserId WHERE orderId in(".$id.") ORDER BY orderId DESC";
	$resultEl = $mysqli->query($sql_query);
	
	$sql_query = "UPDATE orders SET printed='1' WHERE orderId in(".$id.")";
	$result = $mysqli->query($sql_query);
	
	$myArray = array();
	while($row = $resultEl->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
    }
    echo json_encode($myArray);

?>