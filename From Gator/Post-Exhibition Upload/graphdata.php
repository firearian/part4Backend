<?php
/**
 * Created by PhpStorm.
 * User: Azul Alysum
 * Date: 17/08/2017
 * Time: 2:17 AM
 */
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
} elseif ($method=="compare"){
    $temp = array();
    $data1 = $_REQUEST['Tid1'];
    $data2 = $_REQUEST['Tid2'];

    $stmt = $pdo->prepare("SELECT DISTINCT Correct FROM testsubmissions WHERE Tid='$data1'");
    $results = $stmt->execute();
    $percentagevalues = $stmt->fetchAll(PDO::FETCH_ASSOC);

    for ($i = 0; $i < sizeof($percentagevalues); $i++){
        $temp[(string)($percentagevalues[$i]['Correct']*100)."%"] = 0;
    }

    $stmt = $pdo->prepare("SELECT id, Correct FROM testsubmissions WHERE Tid='$data1'");
    $results = $stmt->execute();

    while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < sizeof($percentagevalues); $i++){
            if ($result['Correct'] == $percentagevalues[$i]['Correct']){
                $temp[(string)($percentagevalues[$i]['Correct']*100)."%"]++;
            }
        }
    }
    ksort($temp,SORT_NUMERIC);
    $answer[$data1] = $temp;
    $temp = array();

    $stmt = $pdo->prepare("SELECT DISTINCT Correct FROM testsubmissions WHERE Tid='$data2'");
    $results = $stmt->execute();
    $percentagevalues = $stmt->fetchAll(PDO::FETCH_ASSOC);

    for ($i = 0; $i < sizeof($percentagevalues); $i++){
        $temp[(string)($percentagevalues[$i]['Correct']*100)."%"] = 0;
    }

    $stmt = $pdo->prepare("SELECT id, Correct FROM testsubmissions WHERE Tid='$data2'");
    $results = $stmt->execute();

    while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        for ($i = 0; $i < sizeof($percentagevalues); $i++){
            if ($result['Correct'] == $percentagevalues[$i]['Correct']){
                $temp[(string)($percentagevalues[$i]['Correct']*100)."%"]++;
            }
        }
    }
    ksort($temp,SORT_NUMERIC);
    $answer[$data2] = $temp;
    $temp = array();


    $stmt = $pdo->prepare("SELECT DISTINCT Correct FROM testsubmissions WHERE Tid IN ('$data1', '$data2')");
    $results = $stmt->execute();
    $percentagevalues = $stmt->fetchAll(PDO::FETCH_ASSOC);

    for ($i = 0; $i < sizeof($percentagevalues); $i++){
        $temp[(string)($percentagevalues[$i]['Correct']*100)."%"] = 0;
    }

    ksort($temp,SORT_NUMERIC);
    $answer["keys"] = $temp;

} elseif ($method=="student"){

    $stats = array();
    $tempvalues = array();
    $calculatingvalues = array();
    $N = 0;
    $sigma = 0;

    $data = $_REQUEST['Tid'];
    $stmt = $pdo->prepare("SELECT DISTINCT Correct FROM testsubmissions WHERE Tid='$data'");
    $results = $stmt->execute();
    $percentagevalues = $stmt->fetchAll(PDO::FETCH_ASSOC);

    for ($i = 0; $i < sizeof($percentagevalues); $i++){
        $tempvalues[(string)($percentagevalues[$i]['Correct']*100)."%"] = 0;
    }

    $stmt = $pdo->prepare("SELECT id, Correct FROM testsubmissions WHERE Tid='$data'");
    $results = $stmt->execute();
    $j = 0;

    while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $j++;
        for ($i = 0; $i < sizeof($percentagevalues); $i++){
            if ($result['Correct'] == $percentagevalues[$i]['Correct']){
                $tempvalues[(string)($percentagevalues[$i]['Correct']*100)."%"]++;
                $sigma = $sigma + $percentagevalues[$i]['Correct']*100;
                $calculatingvalues[$j] = $percentagevalues[$i]['Correct']*100;
                $N++;
            }
        }
    }

    $stats["mean"] = $sigma/$N;
    $stats["mode"] = array_keys($tempvalues, max($tempvalues))[0];

    asort($calculatingvalues,SORT_NUMERIC);
    $calculatingvalues= array_values($calculatingvalues);

    $stats["median"] = checkvalue($calculatingvalues, 1, $N);

    if ($N < 4) {
        $stats["lquartile"] = "N/A";
        $stats["uquartile"] = "N/A";
    } else {
        $stats["lquartile"] = checkvalue($calculatingvalues, 2, $N);
        $stats["uquartile"] = checkvalue($calculatingvalues, 3, $N);
    }

    $uname = $_SESSION['username'];
    $stmt = $pdo->prepare("SELECT DISTINCT Correct FROM testsubmissions WHERE Username='$uname' AND Tid='$data'");
    $results = $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats["score"] = $result["Correct"]*100;


    $answer["stats"] = $stats;
    ksort($tempvalues,SORT_NUMERIC);
    $answer["values"] = $tempvalues;

}

function odd_array(array $calculatingvalues, $ovalue){

    $val1 = floor($ovalue);
    $val2 = ceil($ovalue);
    $total = 0;
    $count = 1;

        for ($i = 0; $i < sizeof($calculatingvalues); $i++){
            if ($count == $val1 OR $count == $val2){
                $total = $total + $calculatingvalues[$i];
            }
            $count++;
        }
        if ($ovalue > 1) {
            return ($total*($ovalue-round($ovalue, 0,PHP_ROUND_HALF_DOWN)));
        } else {
            return ($total*$ovalue);
        }
}

function even_array(array $calculatingvalues, $ovalue){
    $count = 1;
        for ($i = 0; $i < sizeof($calculatingvalues); $i++){
            if ($count == $ovalue){
                return $calculatingvalues[$i];
            }
            $count++;
        }
}

function checkvalue(array $calculatingvalues, $mode, $val){
    if ($mode == 1){
        if ($val%2 or $val==2){
            $ans = odd_array($calculatingvalues, $val/2);
            return ($ans === null) ? 0 : $ans;
        } else{
            $ans = even_array($calculatingvalues, $val/2);
            return ($ans === null) ? 0 : $ans;
        }
    } elseif ($mode == 2){
        if ($val%4){
            $ans = odd_array($calculatingvalues, $val/4);
            return ($ans === null) ? 0 : $ans;
        } else{
            $ans = even_array($calculatingvalues, $val/4);
            return ($ans === null) ? 0 : $ans;
        }
    } elseif ($mode == 3){
        if (($val*3)%4){
            $ans = odd_array($calculatingvalues, ($val*3)/4);
            return ($ans === null) ? 0 : $ans;
        } else{
            $ans = even_array($calculatingvalues, ($val*3)/4);
            return ($ans === null) ? 0 : $ans;
        }
    }
}


echo(json_encode($answer));
?>
