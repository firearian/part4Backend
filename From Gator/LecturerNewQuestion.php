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

$stmt = $pdo->prepare("SELECT DISTINCT QTopic FROM questions WHERE deleted='0'");
$results = $stmt->execute();


echo '<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
  <title>lecturer main menu</title>
    
 <!-- Latest compiled and minified bootstrap stylesheet -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

  <!-- Latest compiled Material Design https://7b0257f4.ngrok.io -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    
  <link rel="stylesheet" href="LecturerNewQuestion.css">
    
</head>
<body>
   
 <!-----------------------------NAVBAR ----------------------->
   <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
          <!-- Title -->
          <br>
          <p id="title">New Question</p>     
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
        
    <form id="form1" method="post" action="add.php" enctype="multipart/form-data">

    <div id="MainContainer"> 
        <div id="NameContainer">
            <div id="Name">  
                <p>Question name:</p>
                <input id="NameTfield" type="text" name="name" style="text-align:center; color:black;">
            </div>
            <br>
        </div>

    <div id="qTopicContainer">
        <div id="qTopic">
            <p>Under the topic:</p>
        </div>
        <div id="qTopicSelect">
            <input id="text-to-add" type="text" value="New Topic (optional)" style="font-size:1.4vmin;text-align:center; color:black;">
	    <button type="button" id="new-item" style="font-size:1.4vmin;">Add to topics</button>
            <select id="Topsel" name="topic"  style="font-size:1.4vmax;">';
                $count = 1;
                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  echo '<option value="' . $result['QTopic'] . '"> ' . $result['QTopic'] . ' </option >';
                  $count = $count +1;
                }
                echo '</select>
        </div>
    </div>
    
        <div id="qTypeContainer">
            <div id="qType">  
                <p>Question type:</p>
            </div>
            <div id="qTypeSelect">
                    <select id="Typesel" name="type" style=" font-size: 1.4vmax;" onchange="myFunction()">
                      <option value="Text">Text</option>
                      <option value="MC">Multi choice</option>
                      <option value="TF">True/False</option>   
                    </select>
            </div>
        </div>
    
        <input id="UploadQuestion" type="file" name="fileimage" accept="image/*">
        
    
        <div id="dynamicContentsText">
             <p style="text-align: center; font-size: 1.5vw;"><b>Type the question contents below</b></p>
             <div>
                 <textarea id="QText" form="form1" name="QText" id="commemt1" rows="8"></textarea>
             </div> 
             <div>
             <label id="UploadQuestionLabel" for="UploadQuestion">Choose file</label>
             <p id="uploadQuestionText"><b>Upload an image for the question (optional): &nbsp;</b></p>
             </div> 
        </div>
    
        <div id="dynamicContentsMultiChoice">
             <p style="text-align: center; font-size: 1.5vw;"><b>Type the question contents below</b></p>
             <div>
                 <textarea id="QText" form="form1" name="QText" id="commemt2" rows="4"></textarea>
             </div>
             <div id="multiQuestionChoiceCont" style="text-align: center; font-size: 1.5vw;">

                 A <textarea form="form1" name="question[]" rows="1" cols="12" ></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 B <textarea form="form1" name="question[]" rows="1" cols="12"></textarea>
             </div><br>
             <div id="multiQuestionChoiceCont" style="text-align: center; font-size: 1.5vw;">
                 C <textarea form="form1" name="question[]" rows="1" cols="12"></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 D <textarea form="form1" name="question[]" rows="1" cols="12"></textarea>
             </div>
             <label id="UploadQuestionLabel" for="UploadQuestion">Choose file</label>
             <p id="uploadQuestionText"><b>Upload an image for the question (optional): &nbsp;</b></p>
       </div>
    
       <div id="dynamicContentsTrueFalse">
                <p style="text-align: center; font-size: 1.5vw;"><b>Type the question contents below</b></p>
                <div>
                 <textarea id="QText" form="form1" name="QText" id="commemt3" rows="8"></textarea>
                </div>
                <label id="UploadQuestionLabel" for="UploadQuestion">Choose file</label>
                <p id="uploadQuestionText"><b>Upload an image for the question (optional): &nbsp;</b></p>
       </div>

    <div id="AnswerContainer"> 

            <p style="text-align: center;font-size: 1.5vw;"><b> Type the correct answer below</b></p> 
            <textarea id="Answer" name="Answer" form="form1" rows="4"></textarea>
            <input id="UploadAnswer" type="file" name="questionimg" accept="image/*">
            <label id="UploadAnswerLabel" for="UploadAnswer">Choose file</label>
            <p id="AnswerText"><b>Upload the answer via an image/PDF or type below: &nbsp;</b></p>
    </div>
    
    <div id="AnswerMultichoice">
            <p style="text-align: center;font-size: 1.5vw;"><b> Select the correct answers</b></p>
            <table style="margin-left: auto; margin-right: auto">   
        <tr>    
            <td align="middle">
                <input type="checkbox" name="Answer" value="0"> A &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="Answer" value="1"> B
            </td> 
        </tr>    
        <tr>
            <td align="middle">
                <input type="checkbox" name="Answer" value="2"> C &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="Answer" value="3"> D 
            </td>
        </tr>    
        </table> 
    </div>
    
    <div id="AnswerTrueFalse">
        <p style="text-align: center;font-size: 1.5vw;"><b> Select the correct answers</b></p>
        <table style="margin-left: auto; margin-right: auto">   
        <tr>    
            <td align="middle">
                <input type="radio" name="Answer" value="True">True</input>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="Answer" value="False">False</input>
            </td> 
        </tr>      
        </table> 
    </div>
    
    <div id="buttonsContainer">  
    <button id="submitButton" class="waves-effect waves-light btn" type="submit">
     Submit
    </button>
    </div> 
      
  </div>  
    </form>
    
  <!-- javascript -->
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

  <script type="text/javascript">
	$(document).ready(function () {
	    $("#new-item").click(function() {
	        console.log($("#text-to-add").val());
	        $("#Topsel").append( "<option>" + $("#text-to-add").val() + "</option>" );
	    });
	});

$("input[id=\"UploadQuestion\"]").change(function (e) {
	var $this = $(this).val().split("\\\").pop();
	$("p#uploadQuestionText").html("<b>Upload an image for the question (optional):</b> "+$this);
});

$("input[id=\"UploadAnswer\"]").change(function (e) {
	var $this = $(this).val().split("\\\").pop();
	$("p#AnswerText").html("<b>Upload the answer via an image/PDF or type below:</b> "+$this);
});


    function myFunction() {
        if (document.getElementById("Typesel").value == "Text") {
            document.getElementById("AnswerContainer").style.display = "block";
            document.getElementById("AnswerMultichoice").style.display = "none";
            document.getElementById("AnswerTrueFalse").style.display = "none";
            document.getElementById("dynamicContentsText").style.display = "block";
            document.getElementById("dynamicContentsMultiChoice").style.display = "none";
            document.getElementById("dynamicContentsTrueFalse").style.display = "none";
            
        } else if (document.getElementById("Typesel").value == "MC") {
            document.getElementById("AnswerContainer").style.display = "none";
            document.getElementById("AnswerMultichoice").style.display = "block";
            document.getElementById("AnswerTrueFalse").style.display = "none";
            document.getElementById("dynamicContentsText").style.display = "none";
            document.getElementById("dynamicContentsMultiChoice").style.display = "block";
            document.getElementById("dynamicContentsTrueFalse").style.display = "none";

        } else if (document.getElementById("Typesel").value == "TF"){
           document.getElementById("AnswerContainer").style.display = "none";
            document.getElementById("AnswerMultichoice").style.display = "none";
            document.getElementById("AnswerTrueFalse").style.display = "block";
            document.getElementById("dynamicContentsText").style.display = "none";
            document.getElementById("dynamicContentsMultiChoice").style.display = "none";
            document.getElementById("dynamicContentsTrueFalse").style.display = "block";
        }
    }
  </script>  
    
</body>
</html>';
?>