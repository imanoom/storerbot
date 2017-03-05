<?php

class Order { 	
	
	protected $connect;
	protected $lineUserId;
	
	function __construct($mysqli,$lineUserId) {
	
		$this->connect = $mysqli;
		$this->lineUserId = $lineUserId;
		
	}
	
	function post_order($message) {
		
		$realMessage = "";
		
		if(startsWith($message, "order") || startsWith($message, "Order")) {
		
			$realMessage = substr($message,6);
		
		} else {
		
			$lenStr = strlen($message);
			$realMessage = iconv_substr($message,2,$lenStr, "UTF-8");
			
		}

		if($realMessage == "" || $realMessage == " ") {
		
			echo "กรุณากรอกข้อมูลให้ถูกต้อง ! เช่น order ชื่อ นามสกุล ที่อยู่ สินค้า";
			
		} else {
		
			$sql_query = "INSERT INTO orders (userToken,note,dateTimeStamp) VALUES ('".$this->lineUserId."', '".base64_encode($realMessage)."', '".date('Y-m-d H:i:s')."')";

			$result = $this->connect->query($sql_query);

			if($result != 1) {
				return "ขออภัย ระบบขัดข้อง โปรดทำรายการใหม่ในภายหลัง [ติดต่อผู้ดูแลระบบ]";
			} else {
				return "บันทึกข้อมูลแล้ว !";
			}
		
		}
		
	}
	
	function list_order($users) {
		
		$sqlExtra = "";
		
		if($users->userLevel != "Admin") {
			$sqlExtra = "AND userToken = '".$users->lineUserId."'";
		}
		
		$sql_query = "SELECT * FROM orders WHERE dateTimeStamp between '".date("Y-m-d",strtotime("-1 days"))."' and '".date("Y-m-d")." 23:59:59' AND printed = '0' ".$sqlExtra;

		$result = $this->connect->query($sql_query)->fetch_all(MYSQLI_ASSOC);

		$output = "";
		
		
		$date ="";
		
		foreach ($result as $key=>$cus) { 
		
			$key++;
			
			$full_text = base64_decode($cus['note']);
			$full_texts = explode(" ", $full_text);

			$timeStamp = new DateTime($cus['dateTimeStamp']);
			
			if($date != $timeStamp->format('Y-m-d')) {
				$date = $timeStamp->format('Y-m-d');
				$output = $output."\r\n[วันที่ ".$date."]\r\n";
			}
			
			$output = $output.$key.". ".$full_texts[0]." ".$full_texts[1]."\r\n";
			
		}
		
		if($output == "") {
			return "ยังไม่มีรายการสั่งซื้อ";
		} else {
			return $output;
		}
		
	}
	
	function delete_order($users,$message) {
		
		$sqlExtra = "";
		
		if($users->userLevel != "Admin") {
			$sqlExtra = "AND userToken = '".$users->lineUserId."'";
		}
		
		$sql_query = "SELECT * FROM orders WHERE dateTimeStamp between '".date("Y-m-d",strtotime("-1 days"))."' and '".date("Y-m-d")." 23:59:59' AND printed = '0' ".$sqlExtra;

		$result = $this->connect->query($sql_query)->fetch_all(MYSQLI_ASSOC);

		$orderArr = array();
		foreach ($result as $key=>$cus) { 
		
			$key++;
			
			if($cus['userToken'] == $users->lineUserId || $users->userLevel == "Admin") {
				array_push($orderArr,$cus['orderId']);
			}
			
		}
		
		$no = substr($message,4);
		
		if($no == "" || $no == " ") {
			return "โปรดระบุ ลำดับที่ต้องการลบ โดยเลือกจากรายการ";
		}
		
		$noArr = (int)$no-1;
		if($no > $key) {
			return "คุณระบุลำดับไม่ถูกต้อง [".$key."]";
		}
		
		$sql_query = "DELETE FROM orders WHERE orderId = '".$orderArr[$noArr]."'";
		$result = $this->connect->query($sql_query);
	
		if($result == 1) {
			return "ระบบได้ลบข้อมูลแล้ว";
		} else {
			return "ขออภัย ระบบขัดข้อง โปรดทำรายการใหม่ในภายหลัง [ติดต่อผู้ดูแลระบบ]";
		}
		
	}
	
	function view_order($users,$message) {
		
		$sqlExtra = "";
		
		if($users->userLevel != "Admin") {
			$sqlExtra = "AND userToken = '".$users->lineUserId."'";
		}
		
		$sql_query = "SELECT * FROM orders WHERE dateTimeStamp between '".date("Y-m-d",strtotime("-1 days"))."' and '".date("Y-m-d")." 23:59:59' AND printed = '0' ".$sqlExtra;

		$result = $this->connect->query($sql_query)->fetch_all(MYSQLI_ASSOC);

		$orderArr = array();
		foreach ($result as $key=>$cus) { 
		
			$key++;
			
			if($cus['userToken'] == $users->lineUserId || $users->userLevel == "Admin") {
				array_push($orderArr,$cus['orderId']);
			}
			
		}
		
		$no = substr($message,4);
		
		if($no == "" || $no == " ") {
			return "โปรดระบุ ลำดับที่ต้องการดูข้อมูล โดยเลือกจากรายการ";
		}
		
		$noArr = (int)$no-1;
		
		if($no > $key) {
			return "คุณระบุลำดับไม่ถูกต้อง [".$key."]";
		}
		
		$sql_query = "SELECT * FROM orders WHERE orderId = '".$orderArr[$noArr]."'";
		$result = $this->connect->query($sql_query)->fetch_object();

		return base64_decode($result->note);

		
	}
	
	function startsWith($fullString, $someWord) {
		return $someWord === "" || strrpos($fullString, $someWord, -strlen($fullString)) !== false;
	}

}

?>