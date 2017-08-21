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

$stmt = $pdo->prepare("SELECT DISTINCT Tid FROM testsubmissions");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Statistics</title>

    <!-- Latest compiled and minified bootstrap stylesheet -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Latest compiled Material Design https://7b0257f4.ngrok.io -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">

    <link rel="stylesheet" href="LecturerStatistics.css">

    <!-- javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js"></script>

</head>

<body>

<div>
    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <header class="mdl-layout__header">
            <!-- Title -->
            <br>
            <p id="title">Statistics</p>
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

    <br>
    <br>
    <br>

    <div id="TestContainer">
        <div id="TestName">
            <p>Test\'s name you want to compare:</p>
            <div id="TestSelect">
                <div class="mdl-selectfield mdl-js-selectfield">
                    <select class="Namesel" id="Namesel" name="name" onchange="drawgraph()">
                    <option value=""></option>';

            $count = 1;
            for ($i = 0; $i < count($result); $i++){
                $value = $result[$i]['Tid'];
                $stmt = $pdo->prepare("SELECT * FROM qtests WHERE id='$value'");
                $stmt->execute();
                $result2 = $stmt->fetch(PDO::FETCH_ASSOC);
            echo '
                        <option value="' . $value . '">' . $result2['name'] . '</option>';
                        $count++;
            }
                        echo '</select>
                </div>
            </div>
        </div>
        <br>
    </div>

<div id="graph">
<canvas id="graphanswers" width="500" height="400" ></canvas>
</div>

    <img id="UoaLogo" src="/Pictures/uoaLogo.jpg" alt="UoaLogo"/>
</div>
</body>



<script type="text/javascript">
var chartgraph;

function drawgraph(){
    console.log("hello");
    $.ajax({
        url: "graphdata.php",
        data: {Tid: $("#Namesel").val()},
        dataType: "json",
        success: function(ans) {
            $("canvas").empty();
            console.log(ans);
            var keys = [];
            var values = [];
            for (var i = 0; i < Object.keys(ans).length; i++){
                keys.push(Object.keys(ans)[i]);
                console.log("Mew");
                console.log(Object.keys(ans)[i]);
//                values.push(ans.(Object.keys(ans)[i]));
            }
            console.log(keys);
            console.log(Object.values(ans));
            var ctx = document.getElementById("graphanswers");
            chartgraph = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: keys, //names from ans
                    datasets: [{
                        label: "Answer percentages",
                        backgroundColor: \'rgba(153, 102, 255, 0.2)\',
                        data: Object.values(ans)//values //details from ans
                    }]
                },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }

            });



//            var chartgraph = new Chart(ctx).Bar(barData);
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
}

</script>




</html>';
?>