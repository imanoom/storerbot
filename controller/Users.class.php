<?php
	
class Users { 	

	protected $connect;
	public $lineUserId;
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
			return "คุณกรอกข้อมูล ไม่ถูกต้อง \r\n\r\nโปรดลงทะเบียน พิมพ์ regis ชื่อ นามสกุล เบอร์โทร(ไม่มีขีด - )";
		}
		
		$firstname = $messageArr[1];
		$lastname = $messageArr[2];
		$phonenumber = $messageArr[3];
		$address = "";
		
		$sql_query = "INSERT INTO users (lineUserId,firstname,lastname,phonenumber,address) VALUES ('".$userId."', '".$firstname."', '".$lastname."', '".$phonenumber."', '".$address."')";
		$result = $this->connect->query($sql_query);
		
		if($result == 1) {
			return "บันทึกข้อมูลแล้ว โปรดรอการยืนยันจากทางร้านค้า";
		} else {
			return "ขออภัย ระบบขัดข้อง โปรดทำรายการใหม่ในภายหลัง [ติดต่อผู้ดูแลระบบ]";
		}
			
	}
	
	function checkIsRegister($userId) {
	
		$sql_query = "SELECT * FROM users WHERE lineUserId='".$userId."'";
		$result = $this->connect->query($sql_query);
		$row_cnt = mysqli_num_rows($result);
		$result = $result->fetch_object();
		
		if($row_cnt == 1 && $result->userStatus == 'Active') {
	
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
			return "คุณกรอกข้อมูล ไม่ถูกต้อง \r\n\r\nโปรดลงทะเบียน พิมพ์ confirm เบอร์โทร(ไม่มีขีด - )";
		}
		
		$phonenumber = $messageArr[1];
		
		$sql_query = "SELECT * FROM users WHERE phonenumber='".$messageArr[1]."'";
		$result = $this->connect->query($sql_query);
		$row_cnt = mysqli_num_rows($result);
		
		if($row_cnt == 1) {
		
			$sql_query = "UPDATE users SET userStatus='Active' WHERE phonenumber='".$phonenumber."'";
			$result = $this->connect->query($sql_query);
		
			if($result == 1) {
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
		$text = $text."ชื่อ ".$result->firstname." ".$result->lastname."\r\n";
		$text = $text."โทร ".$result->phonenumber."\r\n";
		$text = $text."ที่อยู่ ".$result->address."\r\n";
		
		$userStatus = "ยังไม่ได้ยืนยัน";
		if($result->userStatus == 'Active') {
			$userStatus = "ยืนยัน";
		}
		
		$text = $text."สถานะ ".$userStatus."\r\n";
	
		return $text;
		
	}
	
}