<?php
/**
 * Created by PhpStorm.
 * User: Azul Alysum
 * Date: 3/04/2017
 * Time: 12:06 PM
 */
session_start();
date_default_timezone_set('Pacific/Auckland');


$user = 'pomufoq_root';
$password = 'password';

$dsn = 'mysql:host=localhost;dbname=pomufoq_part4;charset=utf8mb4';

$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $password, $opt);


$receiver = $_POST['LecSel'];
$user= $_SESSION['username'];
$message = $_POST['Answer'];


$stmt = $pdo->prepare("SELECT * FROM users WHERE user='$user'");
$stmt->execute();
$result1 = $stmt->fetch(PDO::FETCH_ASSOC);
$email_from = $result1['upi']."@aucklanduni.ac.nz";
$email_subject = "New Question from Student";
$email_body = $message;


$stmt = $pdo->prepare("SELECT * FROM users WHERE user='$receiver'");
$stmt->execute();
$result1 = $stmt->fetch(PDO::FETCH_ASSOC);


$to = $result1['upi']."@aucklanduni.ac.nz";
$headers = "From: "."$email_from"." \r\n";
$headers .= "Reply-To:"." $visitor_email "."\r\n";

mail($to,$email_subject,$email_body,$headers);



header("Location: StudentMM.php");
?>