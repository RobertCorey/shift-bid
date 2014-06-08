<?php
/*
	Logout page to log a user out of the web site
*/

//Set the session variable to nothing
$_SESSION['emp_email'] = "";

//Use session destroy
session_destroy();

//Redirect user back to index.php
header('Location: index.php');

?>