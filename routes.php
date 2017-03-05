<?php 
	
	require_once 'connection/DB.class.php';
	require_once 'Kernel.php'; 

	$db = Database::getInstance();
	$mysqli = $db->getConnection(); 
	
	//$users = new Users($mysqli);
	//echo $users->index();
	
	if($configFile['debug_mode']) {
	
		$userId = $_POST['userId'];
		$message = $_POST['message'];
		
	} else {
	
		$datas = json_decode(file_get_contents('php://input'), true);
		$userId = $datas['userId'];
		$message = $datas['message'];
		
	}
	
	$users = new Users($mysqli,$userId);
	$isRegister = $users->checkIsRegister($userId);

	if(startsWith(strtolower($message), "regis") || startsWith($message,"ลงทะเบียน")) {
	
		echo $users->register($userId,$message);
		
	} else if($isRegister) {
		
		if(startsWith(strtolower($message), "confirm") || startsWith($message,"ยืนยัน")) {

			if($users->userLevel == "Admin") {
				echo $users->confirmUser($message);
			} else {
				returnNotPermission($users->userLevel);
			}
			
		} else if(startsWith(strtolower($message), "profile") || startsWith($message,"ข้อมูลของฉัน")) {
		
			echo $users->myProfile();
		
		} else if(startsWith(strtolower($message), "order") || startsWith($message,"ใ")) {
		
			$order = new Order($mysqli,$userId);
			echo $order->post_order($message);
		
		} else if(startsWith(strtolower($message), "list") || startsWith($message,"รายการ")) {
		
			$order = new Order($mysqli,$userId);
			echo $order->list_order($users);
		
		} else if(startsWith(strtolower($message), "del") || startsWith($message,"ลบ")) {
	
			$order = new Order($mysqli,$userId);
			echo $order->delete_order($users,$message);
		
		} else if(startsWith(strtolower($message), "view") || startsWith($message,"ดู")) {
	
			$order = new Order($mysqli,$userId);
			echo $order->view_order($users,$message);
		
		} else if(startsWith(strtolower($message), "print")) {
		
			if($users->userLevel == "Admin") {
				echo "เข้าไปที่ www.alicornteam.com/storerbot/public/listOrder.php";
			} else {
				returnNotPermission($users->userLevel);
			}
		
		
		} else {
			returnNotPermission($users->userLevel);
		}
			
	} else {
	
		$text = "";
		$text = $text."ระบบพบว่า Account ของคุณยังไม่ได้ลงทะเบียน หรือยังไม่ได้รับการยืนยัน\r\n\r\n";
		$text = $text."โปรดลงทะเบียน พิมพ์ regis ชื่อ นามสกุล เบอร์โทร(ไม่มีขีด - )\r\n\r\n";
		$text = $text."เช่น\r\n";
		$text = $text."regis ดวงกมลวรรณ วาจี 0853701557";
		echo $text;
		
	}
	
	function returnNotPermission($userLevel) {
	
		$text = "";
		$text = $text."ไม่พบคำสั่ง ลองใหม่อีกครั้ง\r\n\r\n";
		$text = $text."คำสั่ง\r\n";
		$text = $text."1. order หรือ ใ ตามด้วยชื่อ นามสกุล ที่อยู่ ข้อความ\r\n";
		$text = $text."2. list หรือ รายการ เพื่อดูรายการที่ order\r\n";
		$text = $text."3. del หรือ ลบ ตามด้วยลำดับจากรายการ เพื่อลบ Order\r\n";
		$text = $text."4. view หรือ ดู ตามด้วยลำดับจากรายการ เพื่อดู Order\r\n";
		$text = $text."5. print เพื่อรับ url สำหรับเข้าระบบ\r\n";
		$text = $text."6. profile เพื่อดูข้อมูลส่วนตัว\r\n";
		
		if($userLevel == "Admin") {
			$text = $text."7. confirm ตามด้วยเบอร์โทรศัพท์ตัวแทนที่ลงทะเบียน เพื่อเปิดการใช้งานให้ตัวแทน\r\n";
		}
		
		echo $text;
	}
	
	function startsWith($fullString, $someWord) {
		return $someWord === "" || strrpos($fullString, $someWord, -strlen($fullString)) !== false;
	}
	
			
?>