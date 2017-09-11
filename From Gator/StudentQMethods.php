<?php
/**
 * Created by PhpStorm.
 * User: Azul Alysum
 * Date: 28/08/2017
 * Time: 5:54 AM
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

$data = $_REQUEST['id'];

$stmt = $pdo->prepare("SELECT active FROM qtests WHERE id='$data'");
$stmt->execute();
$answer = $stmt->fetch();

echo(json_encode($answer['active']));
?>