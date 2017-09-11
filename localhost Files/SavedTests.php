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

$stmt = $pdo->prepare("SELECT * FROM qtests");
$results = $stmt->execute();



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
          <a class="mdl-navigation__link" href="LectureMM.php">Main Menu</a>   
          <a class="mdl-navigation__link" href="Logout.php">Logout</a>
        </nav>
      </div>
    </div>
   
    <table>    
      <tr>
        <th>Test name</th>
        <th>Test Time</th>
        <th>Activate this test</th>
        <th>Delete this test</th>
        <th>Edit this test</th>
      </tr>';

while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>
        <td id="TestName"> '. $result['name'] .' </td>
        <td> '. $result['time'] .' </td>
        <td><a href="\Active.php?' . $result['id'] . '">Activate</a></td>
        <td><a href="\Testmethod.php?' . $result['id'] . '&delete">Delete</a></td>
        <td><a href="\Testmethod.php?' . $result['id'] . '&edit">Edit</a></td>
      </tr>';
}
    echo '</table>


</body>
</html>';
?>
