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






echo '<!doctype html>
<html lang="en">
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
  <script type="text/javascript">
    function myFunction() {
        if (document.getElementById("Typesel").value == "MC") {
            document.getElementById("AnswerContainer").style.display = "none";
            document.getElementById("AnswerMultichoice").style.display = "block";
            document.getElementById("AnswerTrueFalse").style.display = "none";
            document.getElementById("dynamicContentsText").style.display = "none";
            document.getElementById("dynamicContentsMultiChoice").style.display = "block";
            document.getElementById("dynamicContentsTrueFalse").style.display = "none";
            
        } else if (document.getElementById("Typesel").value == "Text") {
            document.getElementById("AnswerContainer").style.display = "block";
            document.getElementById("AnswerMultichoice").style.display = "none";
            document.getElementById("AnswerTrueFalse").style.display = "none";
            document.getElementById("dynamicContentsText").style.display = "block";
            document.getElementById("dynamicContentsMultiChoice").style.display = "none";
            document.getElementById("dynamicContentsTrueFalse").style.display = "none";

        }
        else if (document.getElementById("Typesel").value == "TF"){
           document.getElementById("AnswerContainer").style.display = "none";
            document.getElementById("AnswerMultichoice").style.display = "none";
            document.getElementById("AnswerTrueFalse").style.display = "block";
            document.getElementById("dynamicContentsText").style.display = "none";
            document.getElementById("dynamicContentsMultiChoice").style.display = "none";
            document.getElementById("dynamicContentsTrueFalse").style.display = "block";
        }
    }
  </script>
</head>
<body>
   
 <!-----------------------------NAVBAR ----------------------->
    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout ">
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
        
    <form id="form1" method="post" action="add.php" enctype="multipart/form-data">
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
                  <div class="mdl-selectfield mdl-js-selectfield">
                    <select class="Typesel" id="Typesel" name="type" onchange="myFunction()">
                      <option value="Text">Text</option>
                      <option value="MC">Multi choice</option>
                      <option value="TF">True/False</option>   
                    </select>
                  </div>
            </div>
            <br>
        </div>
    
    
        <div id="dynamicContentsText">
            <p id="uploadQuestionText">Upload an image for the question (optional)</p>
                    <input id="UploadQuestion" type="file" name="fileimage" accept="image/*">
                    <label id="UploadQuestionLabel" for="UploadQuestion">Choose file</label>
            <br>
            <br>
            <p style="text-align: center; font-size: 120%;"><b>Type the question contents below</b></p>
            <textarea form="form1" name="QText" rows="12" cols="80"></textarea>
        </div>
    
        <div id="dynamicContentsMultiChoice">
        <p id="uploadQuestionText">Upload an image for the question (optional)</p>
        <input id="UploadQuestion" type="file" name="fileimage" accept="image/*">
        <label id="UploadQuestionLabel" for="UploadQuestion">Choose file</label>
        <br>
        <br>
        <p style="text-align: center; font-size: 120%;"><b>Type the question contents below</b></p>
         <textarea form="form1" name="QText" id="commemt" rows="4" cols="80"></textarea><br>
             <div style="text-align: center;">
             A <textarea form="form1" name="question[]" rows="1" cols="12" ></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             B <textarea form="form1" name="question[]" rows="1" cols="12"></textarea>
             </div><br>
            <div style="text-align: center;">
             C <textarea form="form1" name="question[]" rows="1" cols="12"></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             D <textarea form="form1" name="question[]" rows="1" cols="12"></textarea>
            </div>
        </div>
    
    <div id="dynamicContentsTrueFalse">
        <p id="uploadQuestionText">Upload an image for the question (optional)</p>
                <input id="UploadQuestion" type="file" name="fileimage" accept="image/*">
                <label id="UploadQuestionLabel" for="UploadQuestion">Choose file</label>
        <br>
        <br>
        <p style="text-align: center; font-size: 120%;"><b>Type the question contents below</b></p>
        <textarea form="form1" name="QText" rows="12" cols="80"></textarea><br> 
    </div>
    
    <div id="qTopicContainer">
        <div id="qTopic">
            <p>Under the topic:</p>
    </div>
        <div id="qTopicSelect">
              <div class="mdl-selectfield mdl-js-selectfield">
                <select class="mdl-selectfield__select" id="professsion1" name="topic">';
$count = 1;
while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<option value="' . $result['QTopic'] . '"> ' . $result['QTopic'] . ' </option >';
    $count = $count +1;
}
echo '</select>
              </div>
        </div>
        <br>
    </div>
        

    <div id="AnswerContainer"> 
            <p style="text-align: center"><b>Upload the answer via an image/PDF.</b></p>
            <input id="UploadAnswer" type="file" name="questionimg" accept="image/*">
            <label id="UploadAnswerLabel" for="UploadAnswer">Choose file</label> 
        <br>
            <textarea  name="Answer" form="form1" rows="4" cols="110"></textarea>
    </div>
    
    <div id="AnswerMultichoice">
        <p style="text-align: center"> Select the correct answers</p>
        <table style="margin-left: auto; margin-right: auto">     
        <tr>    
            <td align="middle">
                <input type="checkbox" name="Answer" value="1"> A &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="Answer" value="2"> B
            </td> 
        </tr>    
        <tr>
            <td align="middle">
                <input type="checkbox" name="Answer" value="3"> C &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="Answer" value="4"> D 
            </td>
        </tr>    
        </table> 
    </div>
    
    <div id="AnswerTrueFalse">
        <p style="text-align: center;"> Select the correct answers</p>
        <table style="margin-left: auto; margin-right: auto">     
        <tr>    
            <td align="middle">
                <input type="radio" name="Answer" value="True">True</input>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="Answer" value="False">False</input>
            </td> 
        </tr>      
        </table> 
    </div>
    
    <button id="submitButton" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="submit">
     Submit
    </button>
    </form>
    
    <img id="UoaLogo" src="/Pictures/uoaLogo.jpg" alt="UoaLogo"/>
    
</body>
</html>';
?>