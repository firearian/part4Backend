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


echo '<html lang="en">
<head>
  <meta charset="utf-8">
  <title>lecturer main menu</title>
    
<!-- Latest compiled Material Design -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>     
    
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    

     
    
  <link rel="stylesheet" href="LecturerNewQuestion.css">
</head>

<body>
   
 <!-----------------------------NAVBAR ----------------------->
    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
          <!-- Title -->
          <span class="mdl-layout-title"> NEW QUESTION </span>
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

    <form method="post" action="add.php" enctype="multipart/form-data">
    
    <div id="qNameTimeContainer">
        <div id="qName">  
            <p>Question name:</p>
            <input id="NameTfield" type="text" name="name" style="text-align:center; color:black;">
        </div>
        <br>
    </div>
    
    
    <div id="qTypeContainer">
        <div id="qType">  
            <p>Question type:</p>
        </div>

        <div id="qTypeSelect">   
            <form>
              <div class="mdl-selectfield mdl-js-selectfield">
                <select class="mdl-selectfield__select" id="namesel" name="type">
                  <option value=""></option>
                  <option value="option1">Text</option>
                  <option value="option2">Multi choice</option>
                  <option value="option3">Yes/No</option>
                </select>
              </div>
           </form>
        </div>
        <br>
    </div>



    <div id="qTopicContainer">
        <div id="qTopic">  
            <p>Under the topic:</p>
        </div>

        <div id="qTopicSelect">   
            <form>
              <div class="mdl-selectfield mdl-js-selectfield">
                <select class="mdl-selectfield__select" id="topicsel" name="topic">
                  <option value=""></option>
                  ';
                    $count = 1;
                    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value = "Place holder ' . $count .'" > ' . $result['QTopic'] . ' </option >';
                        $count = $count +1;
                    }
                    echo '<option value = "New Topic" > New Topic </option >  
                </select>
              </div>
           </form>
        </div>
        <br>
    </div>
    <div id="AnswerContainer">
        <div id="AnswerTitle">  
            <p>Upload the answer or enter it via the text box below.</p>
        </div>

        <div id="AnswerSelect">   
            <input type="file" name="fileimage" accept="image/*">
        </div>
        <br>
        <div id="AnswerTextBox">
            <textarea rows="4" cols="122"></textarea>
        </div>
    </div>
    </form>

    <button id="submitButton" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="submit">
     Submit
    </button>
    
    <img id="UoaLogo" src="/Pictures/uoaLogo.jpg" alt="UoaLogo"/>
    
</body>
</html>';
?>