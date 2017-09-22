<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['status'] == "l") {} else {
    echo '<script type="text/javascript"> window.location = "index.html" </script>';
}
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

$stmt = $pdo->prepare("SELECT qtests.name, qtests.id, testintermediate.* FROM testintermediate INNER JOIN qtests ON testintermediate.Tid = qtests.id");
$stmt->execute();

date_default_timezone_set('Pacific/Auckland');


echo '<!doctype html>

<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
  <title>Fastest Answers</title>
    
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
  <!-- Latest compiled Material Design -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    
  <link rel="stylesheet" href="LecturerFastestAnswers.css">    
      
</head>

<body>

    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
          <!-- Title -->
          <br>
          <p id="title">Fastest Answers</p>     
          <!-- Add spacer, to align navigation to the right -->
          <p id="LoggedInAs"> You are logged in as ' . $_SESSION['username'] . '</p>
      </header>
        
      <div class="mdl-layout__drawer">
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href="LectureMM.php">Main Menu</a>    
          <a class="mdl-navigation__link" href="LecturerStatistics.php">Statistics</a>    
          <a class="mdl-navigation__link" href="logout.php">Logout</a>
        </nav>
      </div>
    </div>

    <div id= MainContainer>  
    <br>
    
    <!------------------- START OF TOPICS ------------------------>
    <div class="topics">';

        $count = 1;
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $columndata = $result['tempTestid'];
        console.log($columndata);
        $stmt1 = $pdo->prepare("SELECT * FROM testsubmissions WHERE tempTid='$columndata'");
        $results1 = $stmt1->execute();
        $rows = $stmt1->rowCount();
        if ($rows){
        echo'<button type="button" class="accordion">' . $result['name'] . ' created on the ' . $result['createtime'] . '</button>
        <div class="panel">
            <table>
               <tr>
                 <th id="Border">Student</th>
                 <th id="Border">Score</th>
                 <th id="Border">Time</th>
               </tr>';
                $count = 0;
                $now = date_create_from_format("Y-m-d h:i:s", $result['createtime']);
                $now = $now->getTimestamp() ;
                while (($result1 = $stmt1->fetch(PDO::FETCH_ASSOC)) AND ($count < 3)) {
                $then = date_create_from_format("Y-m-d h:i:s", $result1['Submission']);
                $then = $then->getTimestamp();
                $sum = abs($now - $then)/60;
                echo '<tr>
                    <td id="Border">' . $result1['Username'] . '</td>
                    <td id="Border">' . $result1['Correct']*100 . '</td>
                    <td id="Border">' . $sum . ' minutes</td>
                </tr>';
                $count = $count+1;
                }
                echo '</table>
        </div>';
        }
        }


        echo'
    </div>
</div>        
    
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script> 
        
  <script src="/SelectQuestions.js"></script>   
 
</body>
</html>
';
?>