<?php
/**
 * Created by PhpStorm.
 * User: Azul Alysum
 * Date: 3/04/2017
 * Time: 12:06 PM
 */
session_start();
$user = 'id1616804_root';
$password = 'password';

$dsn = 'mysql:host=localhost;dbname=id1616804_part4db;charset=utf8mb4';
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $password, $opt);

//Validation of input
if (($_FILES['fileimage']['name']=="") or !isset($_POST['name']) or !isset($_POST['topic']) or !isset($_POST['type'])) {
    echo "Nothing was found.<br><br>";
    echo "<br><br><button onclick=\"location.href='LecturerNewQuestion.php';\" type=\"button\" class=\"signupbtn\">Go Back</button>";
    exit();
}

$target_dir = "Pictures/";
$target_file = $target_dir . basename($_FILES["fileimage"]["name"]);
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
move_uploaded_file($_FILES['fileimage']['tmp_name'], $target_file);


$nme = $_POST['name'];
if (!isset($_POST['Ntopic'])){
    $top = $_POST['topic'];
}
else{
    $top = $_POST['Ntopic'];
}
$typ = $_POST['type'];
if ($top==="Multichoice"){
    $answer = json_encode($_POST['manswer']);
}
elseif ($top==="calculation") {
    $answer = $_POST['Canswer'];
}
elseif ($top==="Yes/No"){
    $answer = $_POST['Yanswer'];
}

$stmt = $pdo->prepare("INSERT INTO questions (Qname, creation, Qtype, image, username, QTopic, answers) VALUES (:qname, :creation, :qtype, :image, :username, :qtopic, :answers)");
$stmt->execute(['qname' => $nme, 'username' => $_SESSION['username'], 'creation' => date("Y:m:d:h:i:s"), 'qtype' => $typ, 'image' => $target_file, 'qtopic' => $top, 'answers' => $answer]);


header("Location: LectureMM.php");
?>