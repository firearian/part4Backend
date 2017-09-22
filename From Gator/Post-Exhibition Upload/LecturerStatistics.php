<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['status'] == "l") {} else {
        echo '<script type="text/javascript"> window.location = "index.html" </script>';
}
date_default_timezone_set('Pacific/Auckland');

echo '<!doctype html>
<html lang="en">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Lecturer Statistics</title>
    
 <!-- Latest compiled and minified bootstrap stylesheet -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

  <!-- Latest compiled Material Design https://7b0257f4.ngrok.io -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    
  <link rel="stylesheet" href="LecturerStatistics.css">  

    <!-- javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js"></script>

</head>

<body>
    
    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <header class="mdl-layout__header">
            <!-- Title -->
            <br>
            <p id="title">Statistics</p>
            <!-- Add spacer, to align navigation to the right -->
            <p id="LoggedInAs"> You are logged in as Joel</p>
        </header>

        <div class="mdl-layout__drawer">
            <nav class="mdl-navigation">
                <a class="mdl-navigation__link" href="LectureMM.php">Main Menu</a>
                <a class="mdl-navigation__link" href="logout.php">Logout</a>
            </nav>
        </div>
    </div>

  <div id="buttonsContainer">    
        <a href="StudentPerformance.php" style="text-decoration:none;">
        <button class="waves-effect waves-light btn" type="submit">
        Student\'s performance
        </button>
        </a>
    <br>    
        <a href="QuizStatistics.php" style="text-decoration:none;">
        <button class="waves-effect waves-light btn" type="submit">
        Quiz Statistics
        </button>
        </a>
    <br>      

        <a href="QuestionStatistics.php" style="text-decoration:none;">
        <button class="waves-effect waves-light btn" type="submit">
        Question Statistics
        </button>
        </a>
    <br>            

        <a href="CompareQuizzes.php" style="text-decoration:none;">
        <button class="waves-effect waves-light btn" type="submit">
        Compare Quizzes
        </button>
        </a>
    <br>  
      
        <a href="LecturerFastestAnswers.php" style="text-decoration:none;">
        <button class="waves-effect waves-light btn" type="submit">
        Fastest Answers
        </button>
        </a>
    </div>    

    <img id="UoaLogo" src="/Pictures/uoaLogo.jpg" alt="UoaLogo"/>
</body>

</html>'
?>
