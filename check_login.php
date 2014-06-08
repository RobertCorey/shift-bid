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

			//See if the user is a manager, this is an admin function
			//No user was found when checking the database
			//Direct manager to employee.php to add user to the database

			//Set up query to query the database to see if the user is a manager
			$query = "SELECT emp_role FROM employee WHERE emp_email = ?";

			# Prepare the query statement
			if (!$stmt = mysqli_prepare($database, $query)) {
		  	die("Error in query");
			}
				
			# Bind the parameter $uname to the ? marker in the query string
			mysqli_stmt_bind_param($stmt, 's', $email);
				
			# Execute the query statement
			mysqli_stmt_execute($stmt);
				
			# Bind the result to the variables $retrievedPwd and $cnum
			mysqli_stmt_bind_result($stmt, $role);

			//Check to see if role is a manager
			if ($role == 'manager')
			{
				//Direct manager to admin page
				header('Location: adminCalendarView.php');
			}
			else
			{
				//Direct user to calendar page
				header('Location: employeeCalendarView.php'); 
			}
		}
		else
		{
			//Set up query to query the database to see if the user is a manager
			$query = "SELECT emp_role FROM employee WHERE emp_email = ?";

			# Prepare the query statement
			if (!$stmt = mysqli_prepare($database, $query)) {
		  	die("Error in query");
			}
				
			# Bind the parameter $uname to the ? marker in the query string
			mysqli_stmt_bind_param($stmt, 's', $email);
				
			# Execute the query statement
			mysqli_stmt_execute($stmt);
				
			# Bind the result to the variables $retrievedPwd and $cnum
			mysqli_stmt_bind_result($stmt, $role);
			
			//Check to see if role is a manager
			if ($role == 'manager')
			{
				echo "User was not found in the database<br>";
				echo "<a href='employee.php'>Register a new employee</a>";
			}
			else
			{
				echo "Please ask your manager to make an account for you.<br>";
				echo "<a href='index.php'>Return to home page</a>";
			}

			//Close the database connection
			mysqli_close($database);
		}

	}
	else
	{	
		//no email or password was provided from index.php
		echo "No email or password provided!<br>";
		echo "<a href='index.php'>Please try logging in again</a>";
	}	

?>