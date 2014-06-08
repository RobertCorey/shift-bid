<?php
	//session_start();
	//Connect to the database
	require 'php/global.php';

	//Gather variables from form
	$email = $_POST['email'];
	$password = $_POST['password'];

	//Check to see if email and password was provided
	if ($email && $password)
	{
		//Encrypt password in MD5
		$encrypted_password = md5($password);

		//Username and password was provided
		$query = mysqli_query($database, "SELECT * FROM employee WHERE emp_email = '$email' && emp_password = '$encrypted_password'");
		$numRows = mysqli_num_rows($query);

		if ($numRows != 0)
		{
			$_SESSION['email'] = $email;

			//Direct user to calendar page
			header('Location: employeeCalendarView.php'); 

			//Close the database connection
			mysqli_close($database);
		}
		else
		{
	
		}

	}
	else
	{	
		
	}	

?>