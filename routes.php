<?php 
	
	require_once 'Kernel.php'; 
	
	$db = Database::getInstance($configFile);
	$mysqli = $db->getConnection(); 

	if($configFile['debug_mode']) {
	
		$userId = $_POST['userId'];
		$message = $_POST['message'];
		
	} else {
	
		$datas = json_decode(file_get_contents('php://input'), true);
		$userId = $datas['userId'];
		$message = $datas['message'];
		
	}
	
	$users = new Users($mysqli,$userId);
	$isRegister = $users->checkIsActiveUser($userId);

	if(startsWith(strtolower($message), "regis") || startsWith($message,"ลงทะเบียน")) {
	
		if($users->checkIsRegis($userId)) {
		
			echo "Account ของคุณได้ลงทะเบียนแล้ว !";
			echo "\r\n\r\n".$users->myProfile();
			
			if($users->userStatus == "DeActive") {
				echo "\r\nโปรดรอทางร้านค้ายืนยัน Account";
			} 
			
		} else {
			
			echo $users->register($userId,$message);
		
		}
		
	} else if($isRegister) {
		
		if(startsWith(strtolower($message), "confirm") || startsWith($message,"ยืนยัน")) {

			if($users->userLevel == "Admin") {
			
				$client = new Users($mysqli,null);
				
				echo $client->confirmUser($message);
				
				if($client->lineUserId != null) {
					notify($client->lineUserId,"Account ของคุณได้ยืนยันแล้ว เริ่มใช้งานได้เลย !");
				}
				
			} else {
			
				returnNotPermission($users->userLevel);
				
			}
			
		} else if(startsWith(strtolower($message), "profile") || startsWith($message,"ข้อมูลของฉัน")) {
		
			echo $users->myProfile();
		
		} else if(startsWith(strtolower($message), "address")) {
		
			echo $users->updateAddress($userId,$message);
		
		} else if(startsWith(strtolower($message), "order") || startsWith($message,"ใ")) {
		
			$order = new Order($mysqli,$userId);
			echo $order->post_order($message);
		
		//} else if(startsWith(strtolower($message), "list") || startsWith($message,"รายการ")) {
		//
		//	$order = new Order($mysqli,$userId);
		//	echo $order->list_order($users);
		//
		//} else if(startsWith(strtolower($message), "del") || startsWith($message,"ลบ")) {
		//
		//	$order = new Order($mysqli,$userId);
		//	echo $order->delete_order($users,$message);
		//
		} else if(startsWith(strtolower($message), "last") || startsWith($message,"ล่าสุด")) {
	
			$order = new Order($mysqli,$userId);
			echo $order->view_order($users,$message);
		
		} else if(startsWith(strtolower($message), "print")) {
		
			if($users->userLevel == "Admin") {
				echo "เข้าไปที่ www.alicornteam.com/storerbot/";
			} else {
				returnNotPermission($users->userLevel);
			}
		
		} else if(startsWith(strtolower($message), "สวัสดี")
					|| startsWith(strtolower($message), "ดี")
					|| startsWith(strtolower($message), "ทัก")
					|| startsWith(strtolower($message), "ฮาโหล")
					|| startsWith(strtolower($message), "ฮัลโหล")) {
		
			echo "สวัสดีเราเป็น Bot คอยรับ order ให้คุณ ไม่สามารถตอบโต้ได้นะ ถ้ามีข้อสงสัยให้ติดต่อ Line:@dalfour.th";
		
		} else {
			returnNotPermission($users->userLevel);
		}
		
		if($users->userAddress == "") {
			echo "\r\n\r\n *โปรดระบุที่อยู่ของคุณ พิมพ์ address เว้นวรรคตามด้วยที่อยู่ \r\nเช่น address 24 เอกชัย 73 บางบอน กรุงเทพ 10150";
		}
			
	} else {
	
		$text = "";
		$text = $text."Account ของคุณยังไม่ได้ลงทะเบียน หรือยังไม่ได้รับการยืนยัน\r\n\r\n";
		$text = $text."โปรดลงทะเบียน โดยพิมพ์ regis ชื่อ นามสกุล เบอร์โทร(ไม่มีขีด - )\r\n\r\n";
		$text = $text."เช่น\r\n";
		$text = $text."regis ดวงกมลวรรณ วาจี 0853701557";
		echo $text;
		
	}
	
	function returnNotPermission($userLevel) {
	
		$text = "";
		$text = $text."Bot Active ! โปรดพิมพ์คำสั่ง \r\n";
		
		echo $text;
	}
	
	function startsWith($fullString, $someWord) {
		return $someWord === "" || strrpos($fullString, $someWord, -strlen($fullString)) !== false;
	}
	
	function notify($lineId,$message) {
		
		$access_token = '8I4k0Q1En3A2pfDvdmutUj0BhVqXGqjxi/EohdcFSDLcVgEYiYDvzOkAfcYPL2uEfqv0unrjH60Ka4WSXi7G//ciYEJ1WtLAF4xR02HziTya+cOGzvSk1qh2lFIiGk2PlZuFemi94zswT5WT0MPcWAdB04t89/1O/w1cDnyilFU=';

		$messages = [
			'type' => 'text',
			'text' => $message
		];

		$url = 'https://api.line.me/v2/bot/message/push';
		$data = [
			'to' => $lineId,
			'messages' => [$messages],
		];
		$post = json_encode($data);
		$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		curl_close($ch);

	}
	
?>