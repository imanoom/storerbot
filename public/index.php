<?php require_once '../connection/DB.class.php'; ?>
<?php
	
	$db = Database::getInstance();
	$mysqli = $db->getConnection(); 
	
	$datas = json_decode(file_get_contents('php://input'), true);

	$userId = $datas['userId'];
	$note = $datas['message'];
	$timeStamp = date('Y-m-d H:i:s');
	
	$sql_query = "INSERT INTO customers (userToken,note,dateTimeStamp) VALUES ('".$userId."', '".$note."', '".$timeStamp."')";

	$result = $mysqli->query($sql_query);

	if($result != 1) {
		echo "มีข้อผิดพลาด";
	} else {
		echo "บันทึกข้อมูลแล้ว !";
	}
			
?>