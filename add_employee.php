<?php 
/*
    Page that will add the employee to the database
    after verification
*/

session_start();

//Check to make sure employee is logged in 
include 'global.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Employee</title>
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
    <div class="container">
    <?php

    	//Retrieve verified data from session
		$first_name = $_SESSION['first_name'];
		$last_name= $_SESSION['last_name'];
		$email = $_SESSION['email'];
		$role = $_SESSION['role'];
		$email = $_SESSION['email'];
		$password = $_SESSION['password'];

		// Hash the password to be stored securely in the database
		$hashed_pword = md5($password);

		// Connect to the database
		$link = mysqli_connect("localhost", "root", "", "shift-bid") or die(mysqli_error()); 

		# Create query string with marker for $uname
		$query = "SELECT * FROM employee WHERE emp_email = ?";

		# Prepare the query statement
		if (!$stmt = mysqli_prepare($link, $query)) {
		  die("Error in query");
		}
		  
		# Bind the parameter $email to ? marker in the query string
		mysqli_stmt_bind_param($stmt, 's', $email);
		  
		# Execute the query statement
		mysqli_stmt_execute($stmt);
		  
		# Store the result so we can get number of rows
		mysqli_stmt_store_result($stmt);
		  
		# Find out how many rows in the result 
		$rows = mysqli_stmt_num_rows($stmt);
		  
		if ($rows != 0) {
		  # if email already exists, offer to try again to register or
		  # log in with existing email
		?>
		  <p>Email already exists!<p>
		  <p> Register employee with a new email: <a href= 'employee.php'>ADD EMPLOYEE</a>

		<?php
		  
		  # Close statement
		  mysqli_stmt_close($stmt);
		}
		else {

		  # Create query to submit the registration information to the database
		  $query = "INSERT INTO employee (emp_f_name, emp_l_name, emp_role, emp_points, emp_email, emp_password)
		        VALUES (?, ?, ?, 0, ?, ?)";
		        
		  # Prepare the query statement
		  if (!$stmt = mysqli_prepare($link, $query)) {
		    die("Error in query");
		  }

		  # Bind parameters to markers
		  mysqli_stmt_bind_param($stmt, 'sssss', $first_name, $last_name, $role, $email, $hashed_pword);
		  
		  # Execute the query statement
		  mysqli_stmt_execute($stmt);
		  
		  echo "<p>Registration Successful!</p><br>";
		  echo "<a href='index.php'>LOGIN</a>";

		  # Close the statement
		  mysqli_stmt_close($stmt);
		}

		# Close the connection
		mysqli_close($link);

		?>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>

