<?php

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['status'] == "l") {} else {
    echo '<script type="text/javascript"> window.location = "index.html" </script>';
}

$user = 'pomufoq_root';
$password = 'password';

$dsn = 'mysql:host=localhost;dbname=pomufoq_part4;charset=utf8mb4';

$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $password, $opt);

$data = explode("&", $_SERVER['QUERY_STRING']);

if ($data[1]==="delete"){
    $stmt = $pdo->prepare("UPDATE qtests SET deleted='1' WHERE id='$data[0]'");
    $results = $stmt->execute();
    $stmt = $pdo->prepare("UPDATE quizinters SET deleted = :Del WHERE qtestsid='$data[0]'");
    $stmt->execute(['Del' => true]);
    header("Location: SavedTests.php");
}

if ($data[1]==="edit") {
    $stmt = $pdo->prepare("SELECT * FROM qtests WHERE id='$data[0]' AND deleted='0'");
    $stmt->execute();
    $result1 = $stmt->fetch(PDO::FETCH_ASSOC);
    $json = json_decode($result1['data'], TRUE);

echo '<!doctype html>

<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
  <title>Edit Quiz</title>
    
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
  <!-- Latest compiled Material Design -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    
  <link rel="stylesheet" href="SelectQuestions.css">    
      
</head>

<body>

    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
          <!-- Title -->
          <br>
          <p id="title">Edit Quiz</p>     
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

    <div id= MainContainer> 
      <form method="post" action="add1.php?edit&' . $result1['id'] . '" enctype="multipart/form-data">
      <input id="TestName" type="text" placeholder="Name of Test here" name="tname" value="' . $result1['name'] . '" required>
      <input id="TestTime" type="text" placeholder="Total time in minutes" name="ttime" value="' . $result1['time'] . '" required>
      <br>  

      <!------------------- START OF TOPICS ------------------------>
      <div class="topics">';

         $stmt1 = $pdo->prepare("SELECT DISTINCT QTopic FROM questions WHERE deleted='0'");
         $stmt1->execute();
         $count = 1;

         while ($result2 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
         echo '<button type="button" class="accordion">' . $result2['QTopic'] . '</button>
         <div class="panel">
           <table>';
           $columndata = $result2['QTopic'];
           $stmt = $pdo->prepare("SELECT * FROM questions WHERE QTopic='$columndata' AND deleted='0'");
           $stmt->execute();

         while ($result3 = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>
                <td id="NoBorder">' . $result3['Qname'] . '</td>
                <td id="Border">' . $result3['Qtype'] . '</td>
                <td id="Border">
                    <img src="' . $result3['image'] . '" class="img-responsive"/>
                </td>
                <td id="NoBorder"><input type="checkbox" name="questions[]" value="' . $result3['id'] . '"';
            if (in_array($result3['id'], $json, FALSE)) {
                echo ' checked ';
            }
            echo '><br>Select</td>
            </tr>';
        }
        echo '</table>
    </div>';
        $count = $count + 1;
    }
    echo '<br><br><br><br><br>
    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="submit">
        Confirm and Save Quiz
    </button>
    </form>
  </div>
</div>

  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script> 
  <script src="/SelectQuestions.js"></script>

</body>
</html>';
}
?>