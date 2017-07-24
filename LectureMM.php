<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['status'] == "l") {} else {
        echo '<script type="text/javascript"> window.location = "index.html" </script>';
}

echo '<html lang="en">
<head>
  <meta charset="utf-8">
  <title>lecturer main menu</title>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Latest compiled Material Design https://7b0257f4.ngrok.io -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

  <link rel="stylesheet" href="LecturerMM.css">
</head>

<body>
   


<!-- Always shows a header, even in smaller screens. -->
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
  <header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
      <!-- Title -->
      <span class="mdl-layout-title"> Main Menu </span>
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
      <a class="mdl-navigation__link" href="Login.html">Logout</a>
    </nav>
  </div>
</div>



        <a href="SelectQuestions.php" id="CreateTest">
        <button class="mdl-button mdl-js-button" type="submit">
        Create Test
        </button>
        </a>

        <a href="SavedTests.php" id="SavedTests">
        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="submit">
        Saved Tests
        </button>
        </a>

        <a href="LecturerNewQuestion.php" id="NewQuestion">
        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="submit">
        New Question
        </button>
        </a>

        <a href="LecturerSavedQuestions.php" id="SavedQuestions">
        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="submit">
        Saved Questions
        </button>
        </a>

        <a href="Active.php" id="Active">
        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="submit">
        Current Session
        </button>
        </a>

        <a href="LecturerStatistics.php" id="Statistics">
        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="submit">
        Statistics
        </button>
        </a>blue

        <a href="LecturerFastestAnswers.php" id="FastestAnswers">
        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="submit">
        Fastest Answers
        </button>
        </a>

    <img id="UoaLogo" src="/Pictures/uoaLogo.jpg" alt="UoaLogo"/>

</body>
</html>'
?>