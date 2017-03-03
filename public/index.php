<?php require_once '../connection/DB.class.php'; ?>
<?php
	
	$db = Database::getInstance();
	$mysqli = $db->getConnection(); 
	
	$datas = json_decode(file_get_contents('php://input'), true);
	$userId = $datas['userId'];
	$message = $datas['message'];
	
	if(startsWith($message,"order") || startsWith($message,"Order")) {
		$message = substr($message,6);
		
		if($message == "" || $message == " ") {
			echo "ใส่ข้อมูลด้วยดิ ต้องให้บอก !";
		} else {
			echo insertOrder($mysqli,$userId,$message);
		}
	
	} else if(startsWith($message,"รายการ")) {
	
		echo listAllOrderToday($mysqli);
	
	} else {
		$text = "ไม่รู้จะทำอะไร ไม่มีอะไรให้ทำ - - ! \r\n";
		$text = $text."มีไรให้ทำไหมละ...\r\n";
		$text = $text."1. Order : บันทึก order\r\n";
		$text = $text."2. รายการ : เรียกดูรายการวันนี้\r\n";
		$text = $text."3. print : ต้องใช้ com สั่ง print <www.alicornteam.com/storerbot/listOrder.php>\r\n";
		
		echo $text;
	}
		
	function insertOrder($mysqli,$userId,$note) {

		$sql_query = "INSERT INTO customers (userToken,note,dateTimeStamp) VALUES ('".$userId."', '".base64_encode($note)."', '".date('Y-m-d H:i:s')."')";

		$result = $mysqli->query($sql_query);

		if($result != 1) {
			header('HTTP/ 500 Internal error');
		} else {
			return "บันทึกข้อมูลแล้ว !";
		}
	
	}
	
	function listAllOrderToday($mysqli) {

		$sql_query = "SELECT * FROM customers WHERE dateTimeStamp between '".date("Y-m-d")."' and '".date("Y-m-d")." 23:59:59' AND printed = '0'";

		$result = $mysqli->query($sql_query)->fetch_all(MYSQLI_ASSOC);

		$output = "";
		
		foreach ($result as $key=>$cus) { 
		
			$full_text = base64_decode($cus['note']);
			$full_texts = explode(" ", $full_text);

			$output = $output.$full_texts[0]." ".$full_texts[1]."\r\n";
			
		}
		
		if($output == "") {
			return "ยังไม่มีรายการสั่งซื้อ";
		} else {
			return $output;
		}
	
	}
	
	function startsWith($fullString, $someWord) {
		return $someWord === "" || strrpos($fullString, $someWord, -strlen($fullString)) !== false;
	}
	
			
?>