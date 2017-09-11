<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['status'] == "s") {} else {
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

if (!isset($_POST['Qname'])) {
    echo '<script type="text/javascript">
           window.location = "SActiveQLogin.php"
      </script>';
}

$data = $_POST['Qname'];
$stmt = $pdo->prepare("SELECT id, name, time FROM qtests WHERE active=TRUE AND pass='$data' AND deleted='0'");
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
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
  <title>Active quiz</title>
    
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
  <!-- Latest compiled Material Design -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">

  <link rel="stylesheet" href="SActiveQuiz.css">
    
</head>

<body>
    
    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
          <!-- Title -->
          <br>
          <p id="title">Active Quiz</p>     
          <!-- Add spacer, to align navigation to the right -->
            <p id="LoggedInAs"> You are logged in as ' . $_SESSION['username'] . '</p>
     </header>
        
      <div class="mdl-layout__drawer">
        <nav class="mdl-navigation">
            <a class="mdl-navigation__link" href="StudentMM.php">Main menu</a>
            <a class="mdl-navigation__link" href="logout.php">Logout</a>
        </nav>
      </div>
    </div>


  <div id= MainContainer>   
  <form method="post" action="answer.php?' . $id . '" enctype="multipart/form-data">

    <div class="Questions">';

$stmt = $pdo->prepare("SELECT quizinters.id, quizinters.questionid, quizinters.deleted, questions.Qname, questions.Qtype, questions.image, questions.Qtext, questions.Multi FROM quizinters INNER JOIN questions ON quizinters.questionid=questions.id WHERE quizinters.qtestsid='$id'");
$stmt->execute();
$count = 1;
while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

    if ($result['Qtype'] == "Text") {
        echo '<button type="button" class="accordion">' . $result['Qname'] . '</button>
            <div class="panel">
                    <table style="margin-left: auto; margin-right: auto">
                      <tr>';
                        if (!($result['image']=="")) {
                            echo '<img id="QuestionImage" src="' . $result['image'] . '" class="img-responsive"/>';
                        }
                          echo '<p style="text-align: center;">' . $result['Qtext'] . '</p>  
                      </tr>
                      <tr>
                         <textarea id="QuestionText" name="Answer[' . $result['questionid'] .']" rows="4"></textarea>
                      </tr>
                    </table>
            </div>';
    }
    if ($result['Qtype'] == "TF") {
        echo '<button type="button" class="accordion">' . $result['Qname'] . '</button>
            <div class="panel">
                   <table style="margin-left: auto; margin-right: auto">
                      <tr>';
                        if (!($result['image']=="")) {
                            echo '<img id="QuestionImage" src="' . $result['image'] . '" class="img-responsive"/>';
                        }
                          echo '<p style="text-align:center;">' . $result['Qtext'] . '</p>  
                      </tr> 
                      <tr>   
                          <td style="text-align: center; background-color: greenyellow;"> 
                              <input name="Answer[' . $result['questionid'] .']" type="radio" value="True">True</input> &nbsp;&nbsp;&nbsp;
                              <input name="Answer[' . $result['questionid'] .']" type="radio" value="False">False</input> 
                          </td>
                      </tr>
                  </table>
            </div>';
    }
    if ($result['Qtype'] == "MC"){
        echo '<button type="button" class="accordion">' . $result['Qname'] . '</button>
            <div class="panel">
                <table style="margin-left: auto; margin-right: auto">    
                      <tr>';
                        if (!($result['image']=="")) {
                            echo '<img id="QuestionImage" src="' . $result['image'] . '" class="img-responsive"/>';
                        }
                          echo '<p style="text-align:center;">' . $result['Qtext'] . '</p>
                      </tr> 
                      <tr>      
                          <td style="text-align: center; background-color: greenyellow;">          
                              <input name="Answer[' . $result['questionid'] .']" type="radio" name="optionA" value="' . unserialize(base64_decode($result['Multi']))[0] . '">' . unserialize(base64_decode($result['Multi']))[0] . '</input> &nbsp;&nbsp;          
                              <input name="Answer[' . $result['questionid'] .']" type="radio" name="optionA" value="' . unserialize(base64_decode($result['Multi']))[1] . '">' . unserialize(base64_decode($result['Multi']))[1] . '</input> &nbsp;&nbsp;
                              <input name="Answer[' . $result['questionid'] .']" type="radio" name="optionC" value="' . unserialize(base64_decode($result['Multi']))[2] . '">' . unserialize(base64_decode($result['Multi']))[2] . '</input> &nbsp;&nbsp;     
                              <input name="Answer[' . $result['questionid'] .']" type="radio" name="optionD" value="' . unserialize(base64_decode($result['Multi']))[3] . '">' . unserialize(base64_decode($result['Multi']))[3] . '</input> &nbsp;&nbsp;
                              <input name="Answer[' . $result['questionid'] .']" type="radio" name="optionD" value="" hidden checked>
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
  </div>

  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

  <script src="/SelectQuestions.js"></script>


<script type="text/javascript">

function autosubmit (){
    console.log("ID: ",'. $id .');
    $.ajax({
        url: "StudentQMethods.php",
        data: {id:' . $id . '},
        dataType: "json",
        success: function(ans) {
            console.log("Answer: ", ans);
            if (ans === 0){
                console.log("Submission commencing:");
                $("form").submit();
            }
        },
        error: function (jqXHR, exception) {
            var msg = "";
            if (jqXHR.status === 0) {
                msg = "Not connect.\n Verify Network.";
            } else if (jqXHR.status == 404) {
                msg = "Requested page not found. [404]";
            } else if (jqXHR.status == 500) {
                msg = "Internal Server Error [500].";
            } else if (exception === "parsererror") {
                msg = "Requested JSON parse failed";
            } else if (exception === "timeout") {
                msg = "Time out error.";
            } else if (exception === "abort") {
                msg = "Ajax request aborted.";
            } else {
                msg = "Uncaught Error.\n" + jqXHR.responseText;
            }
            console.log(msg);
        }
    });
    t = setTimeout(autosubmit, 10000);
}

window.onload=function() {
    autosubmit();
    t = setTimeout(autosubmit, 10);
}


</script>


 
</body>
</html>'
?>