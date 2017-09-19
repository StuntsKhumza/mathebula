<?php
$ch = curl_init('https://textbelt.com/text');

$data = array(
  'phone' => '+27768368758',
  'message' => 'Hello world',
  'key' => '',
);
//3a7341b52e80995ac7a05546fb92ce61dcf0d110NE6GIyI1XHhcz4LpQiRZGRHJc
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

curl_close($ch);

print_r($response);

echo "sent";