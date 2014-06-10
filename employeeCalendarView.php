<?php
require 'php/global.php';
require 'php/Calendar.php';
protectPage();
if (isset($_POST)) {
    unset($_POST);
}
$email = $_SESSION['emp_email'];
$result = $database->query("SELECT emp_f_name, emp_l_name, emp_points
    FROM employee
    WHERE emp_email = '$email'");
$currentUserInfo = $result->fetch_assoc();
$calendar = new Calendar(3, "America/New_York", $database, $email);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Employee Calendar</title>
  <link rel="stylesheet" href="css/global.css">
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
  <?php
    //Add nav bar to the page
    addNavBar();
  ?>
  <div class="container">
    <?php $calendar->drawCalendar(); ?>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function(){
        var height = $(".container").height();
        height /= 3;
        $('.spacer').css("height",height);
    });
  </script>
</body>
</html>