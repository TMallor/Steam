<?php

$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$date = date('Y-m-d H:i:s');

$info = "IP: " . $ip . " | Date: " . $date . " | User-Agent: " . $user_agent . "\n";
file_put_contents("ip.txt", $info, FILE_APPEND);

?> 