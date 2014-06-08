<?php
require 'global.php'; 
protectPage();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //get user id
    $email = $_SESSION['emp_email'];
    $result = $database->query("SELECT emp_num, emp_points FROM employee WHERE emp_email = '$email'");
    $data = $result->fetch_assoc();
    $id = $data['emp_num'];
    $points = $data['emp_points'];
    //get shiftID from post array
    $shiftID = $_POST['shiftID'];
    $time = time();
    $amount = $_POST['amount'];
    //insert bid
    $database->query("INSERT INTO bids (bid_emp_number, timestamp, shift, wager)
        VALUES ('$id', '$time', '$shiftID', '$amount')");
    //decrements users points
    echo $points;
    echo "<br>";
    echo $amount;
    $points = $points - $amount; 
    $database->query("UPDATE employee SET emp_points='$points' WHERE emp_num='$id'");
    header("Location: ../employeeCalendarView.php");
    exit();
    die();
} else {
    exit();
    die();
}
?>