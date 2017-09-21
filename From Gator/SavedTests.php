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

$stmt = $pdo->prepare("SELECT * FROM qtests WHERE deleted='0'");
$results = $stmt->execute();



echo '
<!doctype html>

<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
  <title>Saved Quizzes</title>
    
 <!-- Latest compiled and minified bootstrap stylesheet -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

  <!-- Latest compiled Material Design https://7b0257f4.ngrok.io -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    
  <link rel="stylesheet" href="SavedTests.css">
</head>

<body>
<!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
          <!-- Title -->
          <br>
          <p id="title">Saved Quizzes</p>     
          <!-- Add spacer, to align navigation to the right -->
          <p id="LoggedInAs"> You are logged in as ' . $_SESSION['username'] . '</p>
      </header>
        
      <div class="mdl-layout__drawer">
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href="LectureMM.php">Main Menu</a>    
          <a class="mdl-navigation__link" href="logout.php">Logout</a>
        </nav>
      </div>
    </div>
   
    <div id=MainContainer>
      <table>    
        <tr>
          <th>Quiz name</th>
          <th>Quiz Time</th>
          <th>Activate this Quiz</th>
          <th>Delete this Quiz</th>
          <th>Edit this Quiz</th>
        </tr>';

     while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
     echo '<tr>
             <td id="TestName" style="font-weight: bold;"> '. $result['name'] .' </td>
             <td> '. $result['time'] .' </td>
             <td><a href="\Active.php?' . $result['id'] . '" style="color:#4caf50 ;font-weight: bold;">Activate</a></td>
             <td><a href="\Testmethod.php?' . $result['id'] . '&delete" style="color:#d50000 ;font-weight: bold;">Delete</a></td>
             <td><a href="\Testmethod.php?' . $result['id'] . '&edit" style="color:#2196f3;font-weight: bold;">Edit</a></td>
             </tr>';
     }
     echo '</table>
    </div>

    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script> 

</body>
</html>';
?>