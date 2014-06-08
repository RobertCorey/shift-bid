<?php 
require 'global.php';
if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $id = $_GET['empID'];
    $result = $database->query("SELECT `emp_f_name`, `emp_l_name`, `emp_points` FROM `employee`
        WHERE emp_num = '$id'");
    $message = $result->fetch_assoc();
    $json = json_encode($message);
    echo $json;
} elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
    $amount = $_POST['amount'];
    $id = $_POST['id'];
    $result = $database->query("SELECT emp_points FROM employee WHERE emp_num = '$id'");
    $balance = $result->fetch_assoc()['emp_points'];
    $sum = $balance + $amount;
    $result = $database->query("UPDATE employee SET emp_points = '$sum' WHERE emp_num = '$id'");
}
 ?>