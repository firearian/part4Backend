<?php
/**
 * Created by PhpStorm.
 * User: Azul Alysum
 * Date: 3/04/2017
 * Time: 12:06 PM
 */
session_start();
$user = 'root';
$password = '';

$dsn = 'mysql:host=localhost;dbname=part4;charset=utf8mb4';
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $password, $opt);

//Validation of input
if (!isset($_POST['questions']) or !isset($_POST['tname']) or !isset($_POST['ttime'])) {
    echo "Nothing was found.<br><br>";
    echo "<br><br><button onclick=\"location.href='LecturerSavedQuestions.php';\" type=\"button\" class=\"signupbtn\">Go Back</button>";
    exit();
}

$json = json_encode($_POST['questions']);
$nme = $_POST['tname'];
$tme = $_POST['ttime'];

$data = explode("&", $_SERVER['QUERY_STRING']);


if ($data[0]==="edit"){
    $stmt = $pdo->prepare("UPDATE qtests SET name = :Name, time = :Time, data = :Data, username =  :Username, date = :Date WHERE id='$data[1]'");
    $stmt->execute(['Name' => $nme, 'Time' => $tme, 'Data' => $json, 'Username' => $_SESSION['username'],  'Date' => date("Y:m:d:h:i:s")]);
}
else {
    $stmt = $pdo->prepare("INSERT INTO qtests (name, time, data, username, date) VALUES (:Name, :Time, :Data, :Username, :Date)");
    $stmt->execute(['Name' => $nme, 'Time' => $tme, 'Data' => $json, 'Username' => $_SESSION['username'], 'Date' => date("Y:m:d:h:i:s")]);
}
header("Location: SavedTests.php");
?>