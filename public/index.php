<?php require_once '../connection/DB.class.php'; ?>
<?php
	
	$db = Database::getInstance();
	$mysqli = $db->getConnection(); 
	
	$datas = json_decode(file_get_contents('php://input'), true);
	$userId = $datas['userId'];
	$message = $datas['message'];
	
	if(startsWith($message,"order") || startsWith($message,"Order")) {
		$message = substr($message,6);
		echo insertOrder($mysqli,$userId,$message);
	} else {
		echo "ไม่รู้จะทำอะไร ไม่มีอะไรให้ทำ - - !";
	}
		
	function insertOrder($mysqli,$userId,$note) {

		$sql_query = "INSERT INTO customers (userToken,note,dateTimeStamp) VALUES ('".$userId."', '".$note."', '".date('Y-m-d H:i:s')."')";

		$result = $mysqli->query($sql_query);

		if($result != 1) {
			header('HTTP/ 500 Internal error');
		} else {
			return "บันทึกข้อมูลแล้ว !";
		}
	
	}
	
	function startsWith($fullString, $someWord) {
		return $someWord === "" || strrpos($fullString, $someWord, -strlen($fullString)) !== false;
	}
	
			
?>