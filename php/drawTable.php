<?php 
// function drawTable()
// {
//     $NUM_DAYS = 4;
//     date_default_timezone_set("America/New_York");
//     echo '<table class="table">';
//     echo '<tr>';
//     for ($i= -1; $i < $NUM_DAYS; $i++) {
//         $str = $i . " days";
//         echo "<th>";
//         echo date("F j, Y", strtotime($str) );
//         if ($i === 0) {
//             echo " (today)";
//         }
//         echo "</th>";
//     }
//     echo "</tr>";
//     for ($i= -1; $i < $NUM_DAYS; $i++) { 

//     }
//     echo "</table>";
// }
// function drawShiftBox($date)
// {

// }
date_default_timezone_set("America/New_York");
require 'php/global.php';
$test = date("Y m d");
$test = str_replace(" ", "/", $test);
echo $test;
$database->query("INSERT INTO shifts (date_of_shift, type) VALUES ('$test' , 'morning') ");
 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>
    <link rel="stylesheet" href="../css/global.css">
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
    <div class="container">
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>