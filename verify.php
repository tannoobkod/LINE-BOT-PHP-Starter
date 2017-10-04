<?php
$access_token = '5Xu9joQddKbDnD5THhMXxYaNoflVITFW/3GIXFrGEwqKXZkJYbWzYD+nMMeczf091CBd/06JX5hS+oUwTXnnkzEHT3+0spwkfi7+AHqHCasXs0ZRiHgiOMR8xRwzx3JgkuoISnabV/tMHGYzshveIwdB04t89/1O/w1cDnyilFU=
';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
