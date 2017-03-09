<?php
	
class Users { 	

	protected $connect;
	public $lineUserId;
	public $userAddress;
	public $userLevel;
	public $sellerLevel;
	public $userStatus;
	
	function __construct($mysqli,$lineUserId) {
	
		$this->connect = $mysqli;
		$this->lineUserId = $lineUserId;
	}
	
	function register($userId,$message) {
		
		//Validate
		$messageArr = explode(" ", $message);
		if(count($messageArr) != 4) {
			return "คุณกรอกข้อมูล ไม่ถูกต้อง \r\n\r\nลงทะเบียน พิมพ์ regis ชื่อ นามสกุล เบอร์โทร(ไม่มีขีด - )";
		}
		
		$firstname = $messageArr[1];
		$lastname = $messageArr[2];
		$phonenumber = $messageArr[3];
		$address = "";
		
		$sql_query = "INSERT INTO users (lineUserId,firstname,lastname,phonenumber,address) VALUES ('".$userId."', '".base64_encode($firstname)."', '".base64_encode($lastname)."', '".$phonenumber."', '".$address."')";
		$result = $this->connect->query($sql_query);
		
		if($result == 1) {
			return "บันทึกข้อมูลแล้ว โปรดแจ้งทางร้านค้า เพื่อทำการยืนยัน";
		} else {
			return "ขออภัย ระบบขัดข้อง โปรดทำรายการใหม่ในภายหลัง [ติดต่อผู้ดูแลระบบ]";
		}
			
	}
	
	function checkIsRegis($userId) {
	
		$sql_query = "SELECT * FROM users WHERE lineUserId='".$userId."'";
		$result = $this->connect->query($sql_query);
		$row_cnt = mysqli_num_rows($result);
		$result = $result->fetch_object();
		
		if($row_cnt == 1) {
	
			$this->userAddress = $result->address;
			$this->userLevel = $result->userLevel;
			$this->sellerLevel = $result->sellerLevel;
			$this->userStatus = $result->userStatus;
		
			return true;
			
		}
		
		return false;
	}
	
	function checkIsActiveUser($userId) {
	
		$sql_query = "SELECT * FROM users WHERE lineUserId='".$userId."'";
		$result = $this->connect->query($sql_query);
		$row_cnt = mysqli_num_rows($result);
		$result = $result->fetch_object();
		
		if($row_cnt == 1 && $result->userStatus == 'Active') {
	
			$this->userAddress = $result->address;
			$this->userLevel = $result->userLevel;
			$this->sellerLevel = $result->sellerLevel;
			$this->userStatus = $result->userStatus;
		
			return true;
			
		}
		
		return false;
	}
	
	function confirmUser($message) {
		
		$messageArr = explode(" ", $message);
		if(count($messageArr) != 2) {
			return "คุณกรอกข้อมูล ไม่ถูกต้อง \r\n\r\nพิมพ์ confirm เบอร์โทร(ไม่มีขีด - )";
		}
		
		$phonenumber = $messageArr[1];
		
		$sql_query = "SELECT * FROM users WHERE phonenumber='".$messageArr[1]."'";
		$result = $this->connect->query($sql_query);
		$row_cnt = mysqli_num_rows($result);
		
		if($row_cnt == 1) {
		
			$sql_query = "UPDATE users SET userStatus='Active' WHERE phonenumber='".$phonenumber."'";
			$result2 = $this->connect->query($sql_query);
		
			if($result2 == 1) {
				
				$result = $result->fetch_object();
				$this->lineUserId = $result->lineUserId;
				
				return "Confirm Account ของหมายเลข ".$phonenumber." แล้ว !";
				
			} else {
				return "ขออภัย ระบบขัดข้อง โปรดทำรายการใหม่ในภายหลัง [ติดต่อผู้ดูแลระบบ]";
			}
		
		} else {
		
			return "ไม่พบ หมายเลข ".$phonenumber." ในระบบ";
			
		}
		
	}
	
	function myProfile() {

		$sql_query = "SELECT * FROM users WHERE lineUserId='".$this->lineUserId."'";
		
		$result = $this->connect->query($sql_query)->fetch_object();
	
		$text = "";
		$text = $text."ชื่อ ".base64_decode($result->firstname)." ".base64_decode($result->lastname)."\r\n";
		$text = $text."โทร ".$result->phonenumber."\r\n";
		$text = $text."ที่อยู่ ".base64_decode($result->address)."\r\n";
		
		$userStatus = "ยังไม่ได้ยืนยัน";
		if($result->userStatus == 'Active') {
			$userStatus = "ยืนยัน";
		}
		
		$text = $text."สถานะ ".$userStatus."\r\n";

		return $text;
		
	}
	
	function updateAddress($userId,$message) {
		
		$message = substr($message,7);
		
		$sql_query = "UPDATE users SET address='".base64_encode($message)."' WHERE lineUserId='".$userId."'";
		$result = $this->connect->query($sql_query);
	
		if($result == 1) {
			return "Update ที่อยู่ของคุณแล้ว !";
		} else {
			return "ขออภัย ระบบขัดข้อง โปรดทำรายการใหม่ในภายหลัง [ติดต่อผู้ดูแลระบบ]";
		}
		
	}
	
}