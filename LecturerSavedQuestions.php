<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['status'] == "l") {} else {
    echo '<script type="text/javascript"> window.location = "index.html" </script>';
}

$user = 'root';
$password = '';

$dsn = 'mysql:host=localhost;dbname=part4;charset=utf8mb4';
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $password, $opt);

$stmt = $pdo->prepare("SELECT DISTINCT QTopic FROM questions");
$results = $stmt->execute();

echo '
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>lecturer main menu</title>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
  <!-- Latest compiled Material Design -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script> 
     
  <link rel="stylesheet" href="LecturerSavedQuestions.css">
    
</head>

<body>

    <!-----------------------------NAVBAR ----------------------->
    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
          <!-- Title -->
          <span class="mdl-layout-title"> SAVED QUESTIONS </span>
          <!-- Add spacer, to align navigation to the right -->
          <div class="mdl-layout-spacer"></div>
          <!-- Navigation. We hide it in small screens. -->
          <nav class="mdl-navigation mdl-layout--large-screen-only">
            <p id="LoggedInAs"> You are logged in as ' . $_SESSION['username'] . '</p>
          </nav>
        </div>
      </header>
      <div class="mdl-layout__drawer">
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href="LectureMM.php">Main Menu</a>   
          <a class="mdl-navigation__link" href="logout.php">Logout</a>
        </nav>
      </div>
    </div>


    <!------------------- START OF TOPICS ------------------------>
    <div class="topics">';


$count = 1;
while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo'<button class="accordion">' . $result['QTopic'] . '</button>
            <div class="panel">
                    <table id="Files">';

                    $columndata = $result['QTopic'];
                    $stmt1 = $pdo->prepare("SELECT * FROM questions WHERE QTopic='$columndata'");
                    $results1 = $stmt1->execute();
                    while ($result1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>
                        <td id="NoBorder">' . $result1['Qname'] . '</td>
                        <td id="Border">' . $result1['Qtype'] . '</td>';
                        if ($result1['Qtype']=="MC"){
                            echo '<td id="Border">' . unserialize(base64_decode($result1['Multi']))[$result1['answers']-1] . '</td>';
                        } elseif ($result1['Qtype']=="Text"){
                            echo '<td id="Border">' . (!($result1['Answerimage']=="") ? '<img align="center" src="' . $result1['Answerimage'] . '" class="img-responsive"/>' : $result1['answers'] ) . '</td>';
                        } else{
                            echo '<td id="Border">' . $result1['answers'] . '</td>';
                        }
                        echo '<td id="Border">
                        <img align="center" src="' . $result1['image'] . '" class="img-responsive"/>
                        </td>
                        <td id="Border"><a href="QuestionMethods.php?edit&'. $result1['id'] .'">Edit</a></td>
                        <td id="NoBorder"><a href="QuestionMethods.php?delete&'. $result1['id'] .'">Delete</a></td>
                      </tr>';
                    };
                    echo '
                </table>
            </div>';
$count = $count+1;
}
echo '</div>
<script src="/SelectQuestions.js"></script>  



</body>
</html>
';
?>