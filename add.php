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

if (!isset($_POST['name']) or !isset($_POST['topic']) or !isset($_POST['type']) or !isset($_POST['Answer'])) {
    echo "Nothing was found or more input was required.<br><br>";
    echo "<br><br><button onclick=\"location.href='LecturerNewQuestion.php';\" type=\"button\" class=\"signupbtn\">Try again</button>";
    exit();
}

if (($_FILES['fileimage']['name']=="") and !isset($_POST['QText'])) {
    echo "Question not submitted.<br><br>";
    echo "<br><br><button onclick=\"location.href='LecturerNewQuestion.php';\" type=\"button\" class=\"signupbtn\">Try again</button>";
    exit();
}

if ($_POST['type'] == "MF" and (!isset($_POST['questionA']) or !isset($_POST['questionB']) or !isset($_POST['questionC']) or !isset($_POST['questionD']))) {
    echo "Question not submitted.<br><br>";
    echo "<br><br><button onclick=\"location.href='LecturerNewQuestion.php';\" type=\"button\" class=\"signupbtn\">Try again</button>";
    exit();
}

$target_dir = "Pictures/";
$target_file1 = $target_dir . basename($_FILES["images"]["name"]);
$imageFileType = pathinfo($target_file1,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
move_uploaded_file($_FILES['fileimage']['tmp_name'], $target_file1);

$target_file2 = $target_dir . basename($_FILES["questionimg"]["name"]);
$imageFileType = pathinfo($target_file2,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
move_uploaded_file($_FILES['questionimg']['tmp_name'], $target_file2);



$nme = $_POST['name'];
$typ = $_POST['type'];
$top = $_POST['topic'];
$qtext = $_POST['QText'];
$answer = $_POST['Answer'];
$qmc = "";
if ($typ==="MC"){
    $qmc = json_encode($_POST['question']);
}

$stmt = $pdo->prepare("INSERT INTO questions (Qname, creation, Qtype, image, username, QTopic, answers, Qtext, Answerimage, Multi) VALUES (:qname, :creation, :qtype, :image, :username, :qtopic, :answers, :qtext, :aimage, :multi)");
$stmt->execute(['qname' => $nme, 'username' => $_SESSION['username'], 'creation' => date("Y:m:d:h:i:s"), 'qtype' => $typ, 'image' => $target_file1, 'qtopic' => $top, 'answers' => $answer, 'qtext' => $qtext, 'aimage' => $target_file2, 'multi' => $qmc]);


header("Location: LectureMM.php");
?>