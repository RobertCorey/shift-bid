<!-- 

	Page to check user login information 

 -->
<?php
	//session_start();
	//Connect to the database
	//$link = mysqli_connect("localhost", "root", "", "shift-bid") or die(mysqli_error()); 

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
			header('Location: adminCalendarView.php'); //Change to calendarView.php once created

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