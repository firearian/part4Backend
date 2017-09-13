<?php
/**
 * Created by PhpStorm.
 * User: Azul Alysum
 * Date: 17/08/2017
 * Time: 2:17 AM
 */
session_start();
$user = 'pomufoq_root';
$password = 'password';

$dsn = 'mysql:host=localhost;dbname=pomufoq_part4;charset=utf8mb4';

$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, $user, $password, $opt);

$answer = array();
$count = 0;
$method = $_REQUEST['method'];

if ($method=="userinfo"){
    $data = $_REQUEST['username'];
    $stmt = $pdo->prepare("SELECT * FROM testsubmissions WHERE Username='$data'");
    $results = $stmt->execute();
    $percentagevalues = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT testsubmissions.Correct, testsubmissions.tempTid, testsubmissions.Tid, testintermediate.tempTestid, testintermediate.createtime FROM testsubmissions INNER JOIN
     testintermediate ON testsubmissions.tempTid=testintermediate.tempTestid WHERE testsubmissions.Username='$data'");
    $results = $stmt->execute();

    while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id = $result['Tid'];
        $stmt1 = $pdo->prepare("SELECT name FROM qtests WHERE id='$id'");
        $result1 = $stmt1->execute();
        $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $text = "\"" . $result1['name'] . "\"" . " on " . $result['createtime'];
        $answer[(string)$text] = ($result['Correct']*100);
    }
    ksort($answer,SORT_STRING);
} elseif ($method=="testinfo"){
    $data = $_REQUEST['Tid'];
    $stmt = $pdo->prepare("SELECT DISTINCT Correct FROM testsubmissions WHERE Tid='$data'");
    $results = $stmt->execute();
    $percentagevalues = $stmt->fetchAll(PDO::FETCH_ASSOC);

    for ($i = 0; $i < sizeof($percentagevalues); $i++){
        $answer[(string)($percentagevalues[$i]['Correct']*100)."%"] = 0;
    }

    $stmt = $pdo->prepare("SELECT id, Correct FROM testsubmissions WHERE Tid='$data'");
    $results = $stmt->execute();

    while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < sizeof($percentagevalues); $i++){
            if ($result['Correct'] == $percentagevalues[$i]['Correct']){
                $answer[(string)($percentagevalues[$i]['Correct']*100)."%"]++;
            }
        }
    }
    ksort($answer,SORT_NUMERIC);
} elseif ($method=="questioninfo"){
    $data = $_REQUEST['Qid'];
    $stmt = $pdo->prepare("SELECT answers.id, answers.Qid, answers.Tid, answers.Username, answers.answer, questions.Qname, questions.id, questions.answers FROM questions INNER JOIN
answers ON answers.Qid=questions.id WHERE questions.Qname='$data'");
    $results = $stmt->execute();
    $answer['Correct'] = 0;
    $answer['Incorrect'] = 0;

    while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($result['answer']==$result['answers']){
            $answer['Correct']++;
        } else {
            $answer['Incorrect']++;
        }
    }
}


echo(json_encode($answer));
?>
