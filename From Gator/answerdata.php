<?php
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

//$data = $_SERVER['QUERY_STRING'];
$data = $_REQUEST['info'];
$answer = array();
$count = 0;

$stmt = $pdo->prepare("SELECT Username, Submission, Correct FROM testsubmissions WHERE TempTid='$data'");
$results = $stmt->execute();

$stmt1 = $pdo->prepare("SELECT createtime FROM testintermediate WHERE tempTestid='$data'");
$results1 = $stmt1->execute();
$result1 = $stmt1->fetch(PDO::FETCH_ASSOC);
//<script type="text/javascript" src="Active.js"></script>

$answer['html'] = "        <table id=\"testTable\">
            <tr>
                <td align=\"middle\" style=\"background-color:darkcyan; color: white\"><b>Student name</b></td>
                <td align=\"middle\" style=\"background-color:darkcyan; color: white\"><b>Time taken </b></td>
                <td align=\"middle\" style=\"background-color:darkcyan; color: white\"><b>Percentage correct </b></td>
            </tr>
";
while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $now = date_create_from_format("Y-m-d h:i:s", $result1['createtime']);
    $now = $now->getTimestamp() ;
    $then = date_create_from_format("Y-m-d h:i:s", $result['Submission']);
    $then = $then->getTimestamp();
    $sum = abs($then - $now)/60;
	

    $answer['html'] .= "<tr>";
    $answer['html'] .=  "<td align=\"middle\">" . $result['Username'] . "</td>";
    $answer['html'] .=  "<td align=\"middle\">" . $sum . " minutes</td>";
    $answer['html'] .=  "<td align=\"middle\">" . $result['Correct']*100 . "</td>";
    $answer['html'] .=  "</tr>";
    $count++;
}
$answer['html'] .=  "</table>";

$answer['length'] =  $count;

if ($count == $_REQUEST['row']){
    $answer['html'] = "";
}


echo(json_encode($answer));
?>
