<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['status'] == "l") {} else {
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

$stmt = $pdo->prepare("SELECT DISTINCT QTopic FROM questions WHERE deleted='false'");
$results = $stmt->execute();

echo '
<!doctype html>

<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
  <title>Saved questions</title>
    
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
  <!-- Latest compiled Material Design -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
     
  <link rel="stylesheet" href="LecturerSavedQuestions.css">
    
</head>

<body>
    
    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
          <!-- Title -->
          <br>
          <p id="title">Saved Questions</p>     
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


    <!------------------- START OF TOPICS ------------------------>
    <div id= MainContainer> 
    <div class="topics">';

      $count = 1;
      while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo'<button class="accordion">' . $result['QTopic'] . '</button>
            <div class="panel">
                    <table>';
                      $columndata = $result['QTopic'];
                      $stmt1 = $pdo->prepare("SELECT * FROM questions WHERE QTopic='$columndata' AND deleted='0'");
                      $results1 = $stmt1->execute();

                      while ($result1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                      echo '<tr>
                        <td id="NoBorder">' . $result1['Qname'] . '</td>
                        <td id="Border">' . $result1['Qtype'] . '</td>';
                        if ($result1['Qtype']=="MC"){
                            echo '<td id="Border">' . $result1['answers'] . '</td>';
                        } elseif ($result1['Qtype']=="Text"){
                            echo '<td id="Border">' . (!($result1['Answerimage']=="") ? '<img id="setWidth" src="' . $result1['Answerimage'] . '" 
                            />' : $result1['answers'] ) . '</td>';
                        } else{
                            echo '<td id="Border">' . $result1['answers'] . '</td>';
                        }
                        echo '<td id="Border">
                        <img id="setWidth" src="' . $result1['image'] . '"/>

                        </td>
                        <td id="Border"><a href="QuestionMethods.php?edit&'. $result1['id'] .'">Edit</a></td>
                        <td id="NoBorder"><a href="QuestionMethods.php?delete&'. $result1['id'] .'">Delete</a></td>
                      </tr>';
                    };
                    echo '
                </table>
            </div>';
$count = $count+1;
}
echo '</div>

         /* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}

/* Caption of Modal Image (Image Text) - Same Width as the Image */
#caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation - Zoom in the Modal */
.modal-content, #caption { 
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}   

</body>
</html>
';
?>