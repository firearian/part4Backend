<?php
/**
 * Created by PhpStorm.
 * User: Azul Alysum
 * Date: 3/04/2017
 * Time: 12:06 PM
 */
session_start();

echo '<html lang="en">
<head>
  <meta charset="utf-8">
  <title> Create a test</title>
    
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
  <link rel="stylesheet" href="LecturerCreateTest.css">
</head>

<body>
   
    <img id="bg" src="../Pictures/LoginBg.jpg" alt="bg"/>
    
    <p id="LoggedInAs"> You are logged in as ' . $_SESSION['username'] . ' </p>

       <a href="SelectQuestions.php">
        <img id="SelectQuestions" src="/Pictures/SelectQuestions.png" alt="SelectQuestions"/>
        </a>     
    
        <a href="SavedTests.php">
        <img id="SavedTests" src="/Pictures/SavedTests.png" alt="SavedTests"/>
        </a> 
    
    <div id="dropdown">
            <img id="mainmenu" src="../Pictures/MenuIcon.png" alt="MenuIcon"/>

            <div class="dropdown-content">
              <a href="Login.html">Logout</a>
                <br>
              <a href="LectureMM.php">Main Menu</a>
            </div>
        </div>
    

    
</body>
</html>';
?>