<?php
//echo json_encode($_SERVER);


$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH'], '/'));
$input = json_decode(file_get_contents('php://input'), true);

print_r($input);