<?php
$access_token = '5Xu9joQddKbDnD5THhMXxYaNoflVITFW/3GIXFrGEwqKXZkJYbWzYD+nMMeczf091CBd/06JX5hS+oUwTXnnkzEHT3+0spwkfi7+AHqHCasXs0ZRiHgiOMR8xRwzx3JgkuoISnabV/tMHGYzshveIwdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			if ( $text == 'เมนู'){
				$messages = [
				'type' => 'text',
				'text' => 'คำสั่งที่ใช้ได้ในปัจจุบัน หมูฝอย, ช่องทางติดต่อ, รายละเอียดร้าน'
			];
			}
			if ($text == 'ยืนยันการสั่งซื้อ'){
				$messages = [
				'type' => 'text',
				'text' => 'ยืนยัน จะดำเนินการจัดส่งให้เร็วที่สุด ขอบคุณครับ'
			];
			}
			if (strpos($text, 'สั่งหมูฝอย') !== false){
				$amount = filter_var($text, FILTER_SANITIZE_NUMBER_INT);
				$price = $amount*200;
				$messages = [
				'type' => 'text',
				'text' => 'หมูฝอยจำนวน ' . $amount . ' กล่อง ราคารวมทั้งหมด ' . $price .  ' บาท กรุณาระบุที่อยู่จัดส่งโดยเริ่มต้นด้วยคำว่า ที่อยู่' 
			];
			}
			if ( strpos($text, 'ที่อยู่') !== false{
				'type' => 'text',
				'text' => $text . ' กรุณายืนยันการส่งซื้อโดยพิมว่า ยืนยันการสั่งซื้อ'
			];
			}
			if ( $text == 'หมูฝอย'){
				$menu = 0;
				$pork = 1;
				$messages = [
				'type' => 'text',
				'text' => 'สั่งหมูฝอยพิม สั่งหมูฝอย # กล่อง'
			];
			}
			if ( $text == 'ช่องทางติดต่อ'){
				$messages = [
				'type' => 'text',
				'text' => 'เบอร์โทร:087561XXXX E-Mail: chatwithche@gmail.com'
			];
			}
			if ( $text == 'รายละเอียดร้าน'){
				$messages = [
				'type' => 'text',
				'text' => 'ร้านขายหมูฝอยราคาถูก อร่อย ถูกสุขอนามัย จัดส่งทาง EMS เก็บเงินปลายทางได้
				สามารถสั่งในนี้ทางไลน์ได้เลยโดยการพิมว่า เมนู'
			];
			}
			
			// Make a POST Request to Messaging API to reply to sender
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
