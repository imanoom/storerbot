<?php
$access_token = '8I4k0Q1En3A2pfDvdmutUj0BhVqXGqjxi/EohdcFSDLcVgEYiYDvzOkAfcYPL2uEfqv0unrjH60Ka4WSXi7G//ciYEJ1WtLAF4xR02HziTya+cOGzvSk1qh2lFIiGk2PlZuFemi94zswT5WT0MPcWAdB04t89/1O/w1cDnyilFU=';

$content = file_get_contents('php://input');

$events = json_decode($content, true);

if (!is_null($events['events'])) {

	foreach ($events['events'] as $event) {

		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
	
			$text = $event['message']['text'];
		
			$replyToken = $event['replyToken'];

			$url = 'http://www.alicornteam.com/storerbot/routes.php';
			$data = [
				'userId' => $event['source']['userId'],
				'message' => $text
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json',);
			
			$timeout = 10;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
			
			$result = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				var_dump($result);
			} else {
				$result = "พบข้อผิดพลาด โปรดติดต่อร้านค้า ด่วน !";
			}
	  
			curl_close($ch);
			
			$messages = [
				'type' => 'text',
				'text' => $result
			];
			
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
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

			echo $result . "\r\n";
		}
	}
}

echo "OK";