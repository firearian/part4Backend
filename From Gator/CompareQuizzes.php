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

$stmt = $pdo->prepare("SELECT DISTINCT Tid FROM testsubmissions");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Compare Quizzes</title>
 <!-- Latest compiled and minified bootstrap stylesheet -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

  <!-- Latest compiled Material Design https://7b0257f4.ngrok.io -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">

    <link rel="stylesheet" href="CompareQuizzes.css">

</head>

<body>

    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <header class="mdl-layout__header">
            <!-- Title -->
            <br>
            <p id="title">Compare Quizzes</p>
            <!-- Add spacer, to align navigation to the right -->
            <p id="LoggedInAs"> You are logged in as ' . $_SESSION['username'] . '</p>
        </header>

        <div class="mdl-layout__drawer">
            <nav class="mdl-navigation">
                <a class="mdl-navigation__link" href="LectureMM.php">Main Menu</a>
                <a class="mdl-navigation__link" href="LecturerStatistics.php">Statistics</a>
                <a class="mdl-navigation__link" href="logout.php">Logout</a>
            </nav>
        </div>
    </div>

  <div id="TestContainer">
    <div id="Test1Container">
        <div id="TestName">
            <p>Select the name of the second quiz</p>
                    <select class="Namesel" id="Namesel1" name="name"">
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

    <div id="Test2Container">
        <div id="TestName">
            <p>Select the name of the first quiz</p>
                    <select class="Namesel" id="Namesel2" name="name"">
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

    <br>

   <div id="graph" style="position: relative; height:30vh; width:70vw">
     <canvas id="graphanswers" responsive="true"></canvas>
   </div>
 </div>


</body>


    <!-- javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js"></script>

<script type="text/javascript">
var chartgraph;


$(".Namesel").change(function() {
    console.log("Part 1 works");
    if($("#Namesel2").val() && $("#Namesel1").val()){
	console.log("Both parts work!!!");
    	drawgraph();
    }
});

function drawgraph(){
    console.log("hello");
    $.ajax({
        url: "graphdata.php",
        data: {Tid1: $("#Namesel1").val(), Tid2: $("#Namesel2").val(), method: "compare"},
        dataType: "json",
        success: function(ans) {
            $("#graph").empty();
            $("#graph").append("<canvas id=\\"graphanswers\\" responsive=\\"true\\"></canvas>");
            var keys = [];
            var values = [];
            for (var i = 0; i < Object.keys(ans).length; i++){
                keys.push(Object.keys(ans)[i]);
            }
            var ctx = document.getElementById("graphanswers");
            chartgraph = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: Object.keys(ans.keys), //names from ans
                    datasets: [{
                        label: "Quiz 1 Answer percentages",
                        backgroundColor: \'rgba(33, 150, 243, 0.4)\',
                        borderColor: \'rgba(21, 101, 192, 0.6)\',
                        borderWidth: 2,
                        borderSkipped: "bottom",
                        hoverBackgroundColor: \'rgba(33, 150, 243, 0.7)\',
                        data: Object.values(ans[Object.keys(ans)[0]])//values //details from ans
                    },
                    {
                        label: "Quiz 2 Answer percentages",
                        backgroundColor: \'rgba(103, 58, 183, 0.4)\',
                        borderColor: \'rgba(69, 39, 160, 0.6)\',
                        borderWidth: 2,
                        borderSkipped: "bottom",
                        hoverBackgroundColor: \'rgba(103, 58, 183, 0.7)\',
                        data: Object.values(ans[Object.keys(ans)[1]])//values //details from ans
                    }]
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
                                    labelString: "Number of Students",
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
                                    labelString: "Quiz Score",
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