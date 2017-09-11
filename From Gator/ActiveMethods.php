<?php
/**
 * Created by PhpStorm.
 * User: Azul Alysum
 * Date: 21/07/2017
 * Time: 11:00 PM
 */
$user = 'pomufoq_root';
$password = 'password';

$dsn = 'mysql:host=localhost;dbname=pomufoq_part4;charset=utf8mb4';

$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $password, $opt);

$data = explode("&", $_SERVER['QUERY_STRING']);

if ($data[0]==="active") {
    $stmt = $pdo->prepare("UPDATE qtests SET active = :actives, pass = :ids  WHERE id='$data[1]'");
    $stmt->execute(['actives' => 1, 'ids' => $data[2]]);
} elseif ($data[0]==="deactive"){
    $id = "";
    $stmt = $pdo->prepare("UPDATE qtests SET active = :actives  WHERE id='$data[1]'");
    $stmt->execute(['actives' => false]);
}


?>