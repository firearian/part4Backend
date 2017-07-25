<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['status'] == "s") {} else {
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

if (!isset($_POST['Qname'])) {
    echo '<script type="text/javascript">
           window.location = "SActiveQLogin.php"
      </script>';
}

$data = $_POST['Qname'];
$stmt = $pdo->prepare("SELECT id, name, time FROM qtests WHERE active=TRUE AND pass='$data'");
$results = $stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$id = $result['id'];
$time = $result['time'];
$name = $result['name'];

if ($result == null){
    echo '<script type="text/javascript">
           window.location = "SActiveQLogin.php"
      </script>';
}



echo '<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Student active quiz</title>
    
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
  <!-- Latest compiled Material Design -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script> 
     
  <link rel="stylesheet" href="SActiveQuiz.css">
    
</head>

<body>
    
    <!-----------------------------NAVBAR ----------------------->
    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
          <!-- Title -->
          <span class="mdl-layout-title"> Active quiz </span>
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
          <a class="mdl-navigation__link" href="StudentMM.php">Main Menu</a>
          <a class="mdl-navigation__link" href="logout.php">Logout</a>
        </nav>
      </div>
    </div>


<form method="post" action="answer.php?' . $id . '" enctype="multipart/form-data">

<div class="Questions">';

$stmt = $pdo->prepare("SELECT quizinters.id, quizinters.questionid, quizinters.deleted, questions.Qname, questions.Qtype, questions.image, questions.Qtext, questions.Multi FROM quizinters INNER JOIN questions ON quizinters.questionid=questions.id WHERE quizinters.qtestsid='$id'");
$stmt->execute();
$count = 1;
while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

    if ($result['Qtype'] == "Text") {
        echo '<button type="button" class="accordion">' . $result['Qname'] . '</button>
            <div class="panel">
                    <table id="Files">
                      <tr>';
                        if (!($result['image']=="")) {
                            echo '<img src="' . $result['image'] . '" class="img-responsive"/>';
                        }
                          echo '<p>' . $result['Qtext'] . '</p>
                      </tr>

                      <tr>
                          <textarea name="Answer[' . $result['questionid'] .']" rows="4" cols="115"></textarea>
                      </tr>
                    </table>
            </div>';
    }
    if ($result['Qtype'] == "TF") {
        echo '<button type="button" class="accordion">' . $result['Qname'] . '</button>
            <div class="panel">
                   <table id="Files">
                      <tr>';
                        if (!($result['image']=="")) {
                            echo '<img src="' . $result['image'] . '" class="img-responsive"/>';
                        }
                          echo '<p>' . $result['Qtext'] . '</p>
                      </tr> 
                      <tr>
                            <div id="trueContainer">
                      <td>               
                              <input name="Answer[' . $result['questionid'] .']" type="radio" value="True">True</input>
                      </td>
                      <td>
                              <input name="Answer[' . $result['questionid'] .']" type="radio" value="False">False</input>
                      </td>
                            </div>
                      </tr>
                  </table>
            </div>';
    }
    if ($result['Qtype'] == "MC"){
        echo '<button type="button" class="accordion">' . $result['Qname'] . '</button>
            <div class="panel">
                <table id="Files">    
                      <tr>';
                        if (!($result['image']=="")) {
                            echo '<img src="' . $result['image'] . '" class="img-responsive"/>';
                        }
                          echo '<p>' . $result['Qtext'] . '</p>
                      </tr> 

                      <tr>      
                      <td>         
                              <input name="Answer[' . $result['questionid'] .']" type="checkbox" name="optionA" value="A">' . $result['Multi'][0] . '                                    </input><br><br>
                      </td>
                      <td>          
                              <input name="Answer[' . $result['questionid'] .']" type="checkbox" name="optionA" value="B">' . $result['Multi'][1] . '                                    <br><br>
                      </td>
                      <td>
                              <input name="Answer[' . $result['questionid'] .']" type="checkbox" name="optionC" value="C">' . $result['Multi'][2] . '                                    <br><br>
                      </td>
                      <td>      
                              <input name="Answer[' . $result['questionid'] .']" type="checkbox" name="optionD" value="D">' . $result['Multi'][3] . '                                    <br><br>
                      </td>              
                      </tr>
                </table>   
            </div>';
    }
    $count = $count +1;
}

            
    echo '<br><br><br>
    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="submit">
      Submit final answers
    </button>    
</div>
</form>


<script src="/SelectQuestions.js"></script>

 
</body>
</html>'
?>