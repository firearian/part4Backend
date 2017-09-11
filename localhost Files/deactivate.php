<?php
/**
 * Created by PhpStorm.
 * User: Azul Alysum
 * Date: 21/07/2017
 * Time: 11:00 PM
 */
$user = 'root';
$password = '';

$dsn = 'mysql:host=localhost;dbname=part4;charset=utf8mb4';
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $password, $opt);

$data = $_SERVER['QUERY_STRING'];

$id = "";
$stmt = $pdo->prepare("UPDATE qtests SET active = :actives  WHERE id='$data'");
$stmt->execute(['actives' => false]);
?>
