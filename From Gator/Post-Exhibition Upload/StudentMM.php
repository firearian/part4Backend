<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['status'] == "s") {} else {
        echo '<script type="text/javascript"> window.location = "index.html" </script>';
}
date_default_timezone_set('Pacific/Auckland');

echo '<!doctype html>

<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Student main menu</title>
    
 <!-- Latest compiled and minified bootstrap stylesheet -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

  <!-- Latest compiled Material Design https://7b0257f4.ngrok.io -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    
  <link rel="stylesheet" href="StudentMM.css">    
  
            
</head>

<body> 
  
    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
          <!-- Title -->
          <br>
          <p id="title">Main Menu</p>     
          <!-- Add spacer, to align navigation to the right -->
                <p id="LoggedInAs"> You are logged in as ' . $_SESSION['username'] . '</p>
       </header>
        
      <div class="mdl-layout__drawer">
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href="logout.php">Logout</a>
        </nav>
      </div>
    </div>


     <div id=buttonsContainer>
        <a href="SActiveQLogin.php" style="text-decoration:none;">
        <button class="waves-effect waves-light btn" type="submit">
        Active Quizzes
        </button>
        </a>
    
    
    <br>
    
        <a href="SAsk.php" style="text-decoration:none;">
        <button class="waves-effect waves-light btn" type="submit">
        Ask the lecturer
        </button>
        </a>
    
    <br>
    
        <a href="SAnswers.php" style="text-decoration:none;">
        <button class="waves-effect waves-light btn" type="submit">
        Your past answers
        </button>
        </a>
    
    <br>
    
        <a href="StudentStatistics.php" style="text-decoration:none;">
        <button class="waves-effect waves-light btn" type="submit">
        Statistics
        </button>
        </a>
    </div>

        
    <img id="UoaLogo" src="/Pictures/uoaLogo.jpg" alt="UoaLogo"/>  
    
  <!-- javascript -->
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script> 

</body>
</html>'
?>


