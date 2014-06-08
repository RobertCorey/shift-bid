<?php 

function protectPage()
{
    if (!isset($_SESSION['emp_email'])) {
        exit();
        die();
    }
}

if (isset($_SESSION)){
	//do nothing, session has already been started
}
else{
	//No session has been started, must start one
	session_start();
}

if (!isset($database)) {
    include 'databaseConnect.php';
}
protectPage();
?>