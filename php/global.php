<?php 

function protectPage()
{
    if (!isset($_SESSION['emp_email'])) {
        exit();
        die();
    }
}
if (!isset($_SESSION)){
	//No session has been started, must start one
	session_start();
}

if (!isset($database)) {
    $database = mysqli_connect("localhost", "root", "", "shift-bid") or die("Could not connect");
}
?>