<?php

//Start the session
session_start();

//Function to add an employee to the database
public function add_employee($number, $fname, $lname, $email, $role, $password){

	//Make page to get information from previous page
	//Get username from employee add page

	$emp_num = $number;
	$emp_f_name = $fname;
	$emp_l_name = $lname;
	$emp_email = $email;
	$emp_role = $role
	$emp_password = $password

	// Hash the password to be stored securely in the database
	$emp_hashed_pword = password_hash($emp_password, PASSWORD_DEFAULT);

	// Connect to the database
	//include 'connect.php';
	$link = mysqli_connect("localhost", "root", "", "shift-bid") or die(mysqli_error()); 

	# Create query string with marker for $uname
	$query = "SELECT * FROM employee WHERE emp_username = ?";

	# Prepare the query statement
	if (!$stmt = mysqli_prepare($link, $query)) {
	  die("Error in query");
	}
	  
	# Bind the parameter $uname to ? marker in the query string
	mysqli_stmt_bind_param($stmt, 's', $uname);
	  
	# Execute the query statement
	mysqli_stmt_execute($stmt);
	  
	# Store the result so we can get number of rows
	mysqli_stmt_store_result($stmt);
	  
	# Find out how many rows in the result 
	$rows = mysqli_stmt_num_rows($stmt);
	  
	if ($rows != 0) {
	  //If the username already exists, admin must re-enter employee info
	  //with new username

	  echo "Username $uname already exists.";
	  //reload page with error message 
	  
	  # Close statement
	  mysqli_stmt_close($stmt);
	}
	else {

	  #Find the next available (highest) employee id number for new customer
	  $query = "SELECT emp_num FROM employee ORDER BY emp_num DESC LIMIT 1";

	    //Prepare the statement
	    if (!$stmt = mysqli_prepare($link, $query)){
	       die("Error in query");
	    }

	    //Execute the query statement
	    mysqli_stmt_execute($stmt);

	    # Store the result so we can get number of rows
	    mysqli_stmt_store_result($stmt);

	    # Bind the result to the variables related to the table show
	    mysqli_stmt_bind_result($stmt, $emp_num);

	    # Get the result and create new id
	    if (mysqli_stmt_fetch($stmt)) {
	      
	      //Compute new employee number
	      $newEmpNum = $emp_num + 1

	    }
	    else {
	      echo "<br>Could not complete transaction.";
	    }

	  # Close the statement
	  mysqli_stmt_close($stmt);

	  # Create query to submit the registration information to the database
	  $query = "INSERT INTO employee (emp_num, emp_f_name, emp_l_name, emp_role, emp_points, emp_email, emp_password)
	        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
	        
	  # Prepare the query statement
	  if (!$stmt = mysqli_prepare($link, $query)) {
	    die("Error in query");
	  }

	  # Bind parameters to markers
	  mysqli_stmt_bind_param($stmt, 'sssssssss', $emp_num, $emp_f_name, $emp_l_name, $emp_role, 0, $emp_email, $emp_hashed_password);
	  
	  # Execute the query statement
	  mysqli_stmt_execute($stmt);
	  
	  # Close the statement
	  mysqli_stmt_close($stmt);
	}

	# Close the connection
	mysqli_close();
}

//Function to remove an employee
public function add_points($pointsToAdd){

	//Query to get current employee points
	
	$

	//Create query to add points to the employee table
	$query = "UPDATE employee SET emp_points";


}

?>