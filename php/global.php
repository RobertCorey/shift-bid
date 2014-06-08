<?php 
function protectPage()
{
    if (!isset($_SESSION['emp_num'])) {
        exit();
        die();
    }
}
session_start();
if (isset($database)) {
    require 'databaseConnect.php';
}
protectPage();
?>