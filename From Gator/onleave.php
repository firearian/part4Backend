<?php
session_start();
date_default_timezone_set('Pacific/Auckland');

$user = 'pomufoq_root';
$password = 'password';

$dsn = 'mysql:host=localhost;dbname=pomufoq_part4;charset=utf8mb4';

$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, $user, $password, $opt);

$data = explode("&", $_SERVER['QUERY_STRING']);


if ($data[0]=="on"){
	$stmt = $pdo->prepare("UPDATE qtests SET active='0' WHERE id='$data[1]'");
	$results = $stmt->execute();
} else if ($data[0]=="off"){
	$stmt = $pdo->prepare("UPDATE qtests SET active='1' WHERE id='$data[1]'");
	$results = $stmt->execute();
}
//<script type="text/javascript" src="Active.js"></script>

?>
