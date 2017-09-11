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

$usr = $_SESSION['username'];

$stmt = $pdo->prepare("SELECT * FROM testsubmissions WHERE Username='$usr'");
$results = $stmt->execute();

//NOTE FOR AZUL -> IF results == NULL, then print out message in html!!!
//Second NOTE FOR AZUL -> What the hell did I mean!??!


echo '
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Saved Tests</title>
    
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
  <!-- Latest compiled Material Design -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script> 
     
    
  <link rel="stylesheet" href="SavedTests.css">
</head>

<body>
    
    <!-----------------------------NAVBAR ----------------------->
    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
          <!-- Title -->
          <span class="mdl-layout-title"> SAVED TESTS </span>
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
          <a class="mdl-navigation__link" href="StudentMM.php">Main Menu</a>   
          <a class="mdl-navigation__link" href="logout.php">Logout</a>
        </nav>
      </div>
    </div>
   
<div class="contains">';

while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $testid = $result['Tid'];
    $stmt1 = $pdo->prepare("SELECT * FROM answers WHERE Tid='$testid'");
    $result1 = $stmt1->execute();
    $stmt2 = $pdo->prepare("SELECT * FROM qtests WHERE id='$testid'");
    $result2 = $stmt2->execute();
    $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    echo'<button type="button" class="accordion">' . $result2['name'] . ' ---------- ' . $result1['Submission'] . '</button>
                <div class="panel">
                        <table>
                              <tr>
                                <th>Test Question:</th>
                                <th>Test Answer</th>
                                <th>Your Answer</th>
                              </tr>';
//    $typ = json_decode($result2['data']);
    while ($result1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $qid = $result1['Qid'];
        $stmt3 = $pdo->prepare("SELECT * FROM questions WHERE id='$qid'");
        $stmt3->execute();
        $result3 = $stmt3->fetch(PDO::FETCH_ASSOC);
        echo '<tr>
                <td id="TestQ"> ' . $result3['Qname'] . ' </td>';
                if ($result3['Qtype']=="MC"){
                    echo '<td id="Border">' . unserialize(base64_decode($result3['Multi']))[$result3['answers']-1] . '</td>';
                } elseif ($result3['Qtype']=="Text"){
                    echo '<td id="Border">' . (!($result3['Answerimage']=="") ? '<img align="center" src="' . $result3['Answerimage'] . '" class="img-responsive"/>' : $result3['answers'] ) . '</td>';
                } else{
                    echo '<td id="Border">' . $result3['answers'] . '</td>';
                }
                echo '<td> ' . $result1['answer'] . ' </td>
              </tr>';
    }
}

echo '</table>
</div>
</div>

</body>
</html>';
?>