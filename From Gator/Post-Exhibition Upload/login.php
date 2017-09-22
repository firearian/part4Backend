<?php
session_start();
date_default_timezone_set('Pacific/Auckland');

/**
 * Created by PhpStorm.
 * User: Azul Alysum
 * Time: 9:37 PM
 */
if (isset($_POST['uname']) and isset($_POST['psw'])) {
    $username = preg_replace('/[^a-zA-Z0-9\ ]/', '', $_POST['uname']);
    $pass = $_POST['psw'];
    $user = 'pomufoq_root';
    $password = 'password';
    $dsn = 'mysql:host=localhost;dbname=pomufoq_part4;charset=utf8mb4';
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, $user, $password, $opt);
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user = :user AND password = :pass ");
    $stmt->execute(['user' => $username, 'pass' => $pass]);
    $result = $stmt->fetch();
    if (empty($result)) {
        echo "No user found. Try again";
    } elseif ($result['status'] == "lecturer") {
        $_SESSION['loggedin'] = true;
        $_SESSION['status'] = "l";
        $_SESSION['username'] = $result['user'];
        echo '<script type="text/javascript">
           window.location = "LectureMM.php"
      </script>';
    } elseif ($result['status'] == "student") {
        $_SESSION['loggedin'] = true;
        $_SESSION['status'] = "s";
        $_SESSION['username'] = $result['user'];
        echo '<script type="text/javascript">
           window.location = "StudentMM.php"
      </script>';
    } else {
        echo "Error. Server Side Error.";
    }
}
?>
