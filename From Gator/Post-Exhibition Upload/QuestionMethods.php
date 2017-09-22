<?php
/**
 * Created by PhpStorm.
 * User: Azul Alysum
 * Date: 25/08/2017
 * Time: 11:26 PM
 */
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

$data = explode("&", $_SERVER['QUERY_STRING']);

//If deleting:
if ($data[0]==="delete"){
    $stmt = $pdo->prepare("UPDATE questions SET deleted='1' WHERE id='$data[1]'");
    $results = $stmt->execute();
    header("Location: LecturerSavedQuestions.php");
    exit();
}


$stmt = $pdo->prepare("SELECT * FROM questions WHERE id='$data[1]'AND deleted='0'");
$result = $stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);





echo '<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Edit Question</title>
    
 <!-- Latest compiled and minified bootstrap stylesheet -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

  <!-- Latest compiled Material Design https://7b0257f4.ngrok.io -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    
  <link rel="stylesheet" href="QuestionMethods.css">
</head>
<body>
   
 <!-----------------------------NAVBAR ----------------------->
   <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
          <!-- Title -->
          <br>
          <p id="title">Edit Question</p>     
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
        
    <form id="form1" method="post" action="add.php?edit&'. $data[1] .'" enctype="multipart/form-data">
    
     <div id="MainContainer"> 
       <div id="NameContainer">
            <div id="Name" style="margin: auto; width: 50%;">  
                <p>Question name:</p>
            </div>

            <div id="qNameSelect"> 
                <input id="NameTfield" type="text" name="name" value="'. $results['Qname'] .'">
            </div>
        </div>
        
 <!-----------------------------TEXT ----------------------->
        
        ';




    if ($results['Qtype']=="Text") {
    
        echo '<div id="qTypeContainer">
                <div id="qType" style="margin: auto; width: 50%;">  
                  <p>Question type:</p>
                </div>
    
              <div id="qTypeSelect">
                    <select class="Typesel" id="Typesel" disabled>
                      <option value="Text">Text</option>
                    </select>
                    <input type="hidden" name="type" value="Text" />
              </div>
              </div>
    
              <input id="UploadQuestion" type="file" name="fileimage" accept="image/*"> 
    
             <div id="dynamicContentsText">
               <p style="text-align: center; font-size: 1.5vw;"><b>Type the question contents below</b></p>
               <div>
               <textarea id="QText" form="form1" name="QText" id="commemt1" rows="8">' . $results['Qtext'] . '</textarea>
                </div>

               <div>
                 <label id="UploadQuestionLabel" for="UploadQuestion">Choose file</label>
                 <p id="uploadQuestionText"><b>Upload an image for the question (optional): &nbsp;</b></p>
               </div> 
            </div>

            <div id="qTopicContainer">
              <div id="qTopic">
                <p>Under the topic:</p>
              </div>
              <div id="qTopicSelect">
                 <div class="mdl-selectfield mdl-js-selectfield">
                 <select class="mdl-selectfield__select" id="professsion1" name="topic">';
        $count = 1;
        $stmt = $pdo->prepare("SELECT DISTINCT QTopic FROM questions WHERE deleted='0'");
        $results1 = $stmt->execute();
        while ($result1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . $result1['QTopic'] . '"> ' . $result1['QTopic'] . ' </option >';
            $count = $count + 1;
        }
        echo '</select>
                </div>
             </div>
            </div>

        <div id="AnswerContainer"> 
            <p style="text-align: center"><b>Upload the answer via an image/PDF.</b></p>
            <input id="UploadAnswer" type="file" name="questionimg" accept="image/*">
            <label id="UploadAnswerLabel" for="UploadAnswer">Choose file</label> 
        <br>
            <textarea  name="Answer" form="form1" rows="4" cols="110" >' . $results['answers'] . '</textarea>
        </div>
 <!-----------------------------MULIT CHOICE ----------------------->
        ';
      }



    elseif ($results['Qtype']=="MC"){
        echo '<div id="qTypeContainer">
                <div id="qType" style="margin: auto; width: 50%;">  
                   <p>Question type:</p>
                </div>
    
                <div id="qTypeSelect">
                    <select class="Typesel" id="Typesel" disabled>
                      <option value="MC">Multi Choice</option>
                    </select>
                    <input type="hidden" name="type" value="MC" />
                </div>
              </div>

        <div id="dynamicContentsMultiChoice">
	        <p id="uploadQuestionText">Upload an image for the question (optional)</p>
	        <input id="UploadQuestion" type="file" name="fileimage" accept="image/*">
	        <label id="UploadQuestionLabel" for="UploadQuestion">Choose file</label>
	        <br>
	        <br>
	        <p style="text-align: center; font-size: 120%;"><b>Type the question contents below</b></p>
	         <textarea form="form1" name="QText" id="commemt" rows="4" cols="80">' . $results['Qtext'] . '</textarea><br>
	             <div style="text-align: center;">
	             A <textarea form="form1" name="question[]" rows="1" cols="12" >' . unserialize(base64_decode($results['Multi']))[0] . '</textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	             B <textarea form="form1" name="question[]" rows="1" cols="12">' . unserialize(base64_decode($results['Multi']))[1] . '</textarea>
	             </div><br>
	            <div style="text-align: center;">
	             C <textarea form="form1" name="question[]" rows="1" cols="12">' . unserialize(base64_decode($results['Multi']))[2] . '</textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	             D <textarea form="form1" name="question[]" rows="1" cols="12">' . unserialize(base64_decode($results['Multi']))[3] . '</textarea>
	            </div>
        </div>

    
    <div id="qTopicContainer">
	        <div id="qTopic">
	            <p>Under the topic:</p>
	    </div>
	        <div id="qTopicSelect">
	              <div class="mdl-selectfield mdl-js-selectfield">
	                <select class="mdl-selectfield__select" id="professsion1" name="topic">';
	        $count = 1;
	        $stmt = $pdo->prepare("SELECT DISTINCT QTopic FROM questions WHERE deleted='0'");
	        $results1 = $stmt->execute();
	        while ($result1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
	            echo '<option value="' . $result1['QTopic'] . '"> ' . $result1['QTopic'] . ' </option >';
	            $count = $count + 1;
	        }
	        echo '</select>
	              </div>
	        </div>
	        <br>
    </div>

    <div id="AnswerMultichoice">
        <p style="text-align: center"> Select the correct answers</p>
        <table style="margin-left: auto; margin-right: auto">     
        <tr>    
            <td align="middle">
                <input type="checkbox" name="Answer" value="1" '. ($results['answers']==unserialize(base64_decode($results['Multi']))[0] ? "checked" : "") .'> A &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="Answer" value="2" '. ($results['answers']==unserialize(base64_decode($results['Multi']))[1] ? "checked" : "") .'> B
            </td> 
        </tr>    
        <tr>
            <td align="middle">
                <input type="checkbox" name="Answer" value="3" '. ($results['answers']==unserialize(base64_decode($results['Multi']))[2] ? "checked" : "") .'> C &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="Answer" value="4" '. ($results['answers']==unserialize(base64_decode($results['Multi']))[3] ? "checked" : "") .'> D 
            </td>
        </tr>    
        </table> 
    </div>
 <!-----------------------------TRUE / FALSE----------------------->
    
    ';
    }


    elseif ($results['Qtype']=="TF"){
        echo '<div id="qTypeContainer">
            <div id="qType" style="margin: auto; width: 50%;">  
                <p>Question type:</p>
            </div>
    
            <div id="qTypeSelect">
                    <select class="Typesel" id="Typesel" disabled>
                      <option value="TF">True/False</option>
                    </select>
                    <input type="hidden" name="type" value="TF" />
            </div>
        </div>
    

    <div id="AnswerTrueFalse">
        <p style="text-align: center;font-size: 1.5vw;"><b> Select the correct answers</b></p>
        <table style="margin-left: auto; margin-right: auto">   
        <tr>    
            <td align="middle">
                <input type="radio" name="Answer" value="True" '. ($results['answers']=="True" ? "checked" : "") .'>True</input>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="Answer" value="False" '. ($results['answers']=="False" ? "checked" : "") .'>False</input>
            </td> 
        </tr>      
        </table> 
    </div>
    
            <div id="dynamicContentsTrueFalse">
            <p id="uploadQuestionText">Upload an image for the question (optional)</p>
                    <input id="UploadQuestion" type="file" name="questionimg" accept="image/*">
                    <label id="UploadQuestionLabel" for="UploadQuestion">Choose file</label>
            <br>
            <br>
            <p style="text-align: center; font-size: 120%;"><b>Type the question contents below</b></p>
            <textarea form="form1" name="QText" id="QText" rows="12" cols="80">' . $results['Qtext'] . '</textarea><br> 
        </div>
    
    <div id="qTopicContainer">
        <div id="qTopic">
            <p>Under the topic:</p>
    </div>
        <div id="qTopicSelect">
              <div class="mdl-selectfield mdl-js-selectfield">
                <select class="mdl-selectfield__select" id="professsion1" name="topic">';
        $count = 1;
        $stmt = $pdo->prepare("SELECT DISTINCT QTopic FROM questions WHERE deleted='0'");
        $results1 = $stmt->execute();
        while ($result1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . $result1['QTopic'] . '"> ' . $result1['QTopic'] . ' </option >';
            $count = $count + 1;
        }
        echo '</select>
              </div>
        </div>
        <br>
    </div>
    <div id="AnswerTrueFalse">
        <p style="text-align: center;"> Select the correct answers</p>
        <table style="margin-left: auto; margin-right: auto">     
        <tr>    
            <td align="middle">
                <input type="radio" name="Answer" value="True" '. ($results['answers']=="True" ? "checked" : "") .'>True</input>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="Answer" value="False" '. ($results['answers']=="False" ? "checked" : "") .'>False</input>
            </td> 
        </tr>      
        </table> 
    </div>';
    }


//------------------------------------------------------------------------------------------------------------------------
    echo '<div id="buttonsContainer"> 
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
$("input[id=\"UploadQuestion\"]").change(function (e) {
	var $this = $(this).val().split("\\\").pop();
	$("p#uploadQuestionText").html("<b>Upload an image for the question (optional):</b> "+$this);
});

$("input[id=\"UploadAnswer\"]").change(function (e) {
	var $this = $(this).val().split("\\\").pop();
	$("p#AnswerText").html("<b>Upload the answer via an image or type above:</b> "+$this);
});
  </script>  


    
    
</body>
</html>';
?>