<?php
$access_token = '5Xu9joQddKbDnD5THhMXxYaNoflVITFW/3GIXFrGEwqKXZkJYbWzYD+nMMeczf091CBd/06JX5hS+oUwTXnnkzEHT3+0spwkfi7+AHqHCasXs0ZRiHgiOMR8xRwzx3JgkuoISnabV/tMHGYzshveIwdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
$menu = 0;
$pork = 0;
$pork_amount = 0;
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
			if ( $text == 'เมนู' && $menu == 0){
				$menu = 1;
			$messages = [
				'type' => 'text',
				'text' => 'หมูฝอย'
			];
			}
			if (is_numeric($text) && $pork == 1){
				$pork_amount = 1;
				$pork = 0;
				$messages = [
				'type' => 'text',
				'text' => $text+'กล่อง'
				$pork_amount =0;
			];
			}
			if ( $text == 'หมูฝอย' && $menu == 1){
				$menu = 0
				$pork = 1;
				$messages = [
				'type' => 'text',
				'text' => $pork
				
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
