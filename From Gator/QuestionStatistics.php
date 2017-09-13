<?php
session_start();
$user = 'pomufoq_root';
$password = 'password';

$dsn = 'mysql:host=localhost;dbname=pomufoq_part4;charset=utf8mb4';

$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $password, $opt);

$stmt = $pdo->prepare("SELECT DISTINCT Qname FROM questions");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Question Statistics</title>
 <!-- Latest compiled and minified bootstrap stylesheet -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

  <!-- Latest compiled Material Design https://7b0257f4.ngrok.io -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">

    <link rel="stylesheet" href="QuestionStatistics.css">

</head>

<body>

    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <header class="mdl-layout__header">
            <!-- Title -->
            <br>
            <p id="title">Question Statistics</p>
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
            <p>Quiz\'s name you want to compare:</p>
            <div id="TestSelect">
                <div class="mdl-selectfield mdl-js-selectfield">
                    <select class="Namesel" id="Namesel" name="name" onchange="drawgraph()">
                    <option value=""></option>';

for ($i = 0; $i < count($result); $i++){
    $value = $result[$i]['Qname'];
    echo '
                        <option value="' . $value . '">' . $value . '</option>';
}
echo '</select>
                </div>
            </div>
        </div>
        <br>
    </div>

    <br>

   <div id="graph" style="position: relative; height:40vh; width:70vw">
     <canvas id="graphanswers" responsive="true"></canvas>
   </div>


</body>


    <!-- javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js"></script>

<script type="text/javascript">
var chartgraph;

function drawgraph(){
    console.log("hello");
    $.ajax({
        url: "graphdata.php",
        data: {Qid: $("#Namesel").val(), method: "questioninfo"},
        dataType: "json",
        success: function(ans) {
              $("#graph").empty();
              $("#graph").append("<canvas id=\\"graphanswers\\" responsive=\\"true\\"></canvas>");

            console.log(ans);
            var keys = [];
            var values = [];
            for (var i = 0; i < Object.keys(ans).length; i++){
                keys.push(Object.keys(ans)[i]);
                console.log("Mew");
                console.log(Object.keys(ans)[i]);
            }
            console.log(keys);
            console.log(Object.values(ans));
            var ctx = document.getElementById("graphanswers");
            Chart.defaults.global.defaultFontSize = 12;
            chartgraph = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: keys, //names from ans
                    datasets: [
                        {
                            label: "Answers",
                            backgroundColor: \'rgba(33, 150, 243, 0.4)\',
                            borderColor: \'rgba(21, 101, 192, 0.6)\',
                            borderWidth: 2,
                            borderSkipped: "bottom",
                            hoverBackgroundColor: \'rgba(33, 150, 243, 0.7)\',
                            data: Object.values(ans)
                        }
                    ]
                },
                    options: {
                        legend: {
                                position: "right",
                            labels: {
                                // This more specific font property overrides the global property
                                fontSize: 16,
                                fontStyle: "bold"
                            }
                        },
                        scales: {
                            yAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: "Number of Answers",
                                    fontSize: 15,
                                    fontStyle: "bold",
                                    padding: 2,
                                },
                                ticks: {
                                    beginAtZero:true
                                }
                            }],
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: "Nature of Answer",
                                    fontSize: 15,
                                    fontStyle: "bold",
                                    padding: 0,
                                },
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