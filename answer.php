<?php
/**
 * Created by PhpStorm.
 * User: Azul Alysum
 * Date: 24/07/2017
 * Time: 8:00 PM
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
//if (($_FILES['fileimage']['name']=="") or !isset($_POST['name']) or !isset($_POST['topic']) or !isset($_POST['type'])) {
//    echo "Nothing was found.<br><br>";
//    echo "<br><br><button onclick=\"location.href='LecturerNewQuestion.php';\" type=\"button\" class=\"signupbtn\">Go Back</button>";
//    exit();
//}

$times = date("Y:m:d:h:i:s");
$data = $_SERVER['QUERY_STRING'];
$size = sizeof($_POST['Answer']);
//$_POST['Answer'][0][key($_POST['Answer'][0])]
//for ($i = 0; $i < $size; $i++){


$stmt = $pdo->prepare("SELECT quizinters.id, quizinters.questionid, quizinters.deleted, questions.answers FROM quizinters INNER JOIN questions ON quizinters.questionid=questions.id WHERE quizinters.qtestsid='$data'");
$stmt->execute();
$pass = true;
$totalqs = 0;
$nright = 0;

while ($result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $totalqs++;
    reset($_POST['Answer']);
    foreach (array_values($_POST['Answer']) as $i => $value) {
        if (key($_POST['Answer'])==$result['questionid']){
            if (!($result['answers']==$value)){
                $pass = false;
            } else {$nright++; break;}
        }
        next($_POST['Answer']);
    }

}

$stmt = $pdo->prepare("INSERT INTO testsubmissions (Tid, Username, Submission, Correct) VALUES (:tid, :username, :times, :correct)");
$stmt->execute(['username' => $_SESSION['username'], 'times' => $times, 'tid' => $data, 'correct' => ($nright/$totalqs)]);
reset($_POST['Answer']);


foreach (array_values($_POST['Answer']) as $i => $value) {
    $stmt = $pdo->prepare("INSERT INTO answers (Qid, Tid, username, answer) VALUES (:qid, :tid, :username, :answers)");
    $stmt->execute(['username' => $_SESSION['username'], 'qid' => key($_POST['Answer']), 'tid' => $data, 'answers' => $value]);
    next($_POST['Answer']);
}


header("Location: StudentMM.php");
?>