<?php

//Start the session
session_start();

//Function to add an employee to the database

//Make page to get information from previous page
//Get username from employee add page

// Hash the password to be stored securely in the database
$hashed_pword = password_hash($pword, PASSWORD_DEFAULT);

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
  $query = "INSERT INTO customer (custID, fname, lname, email, creditcard, membersince, renewaldate, password, username)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
  # Prepare the query statement
  if (!$stmt = mysqli_prepare($link, $query)) {
    die("Error in query");
  }

  # Bind parameters to markers
  mysqli_stmt_bind_param($stmt, 'sssssssss', $newCustID, $fname, $lname, $email, $cardNum, $memberSince, $renewalDate, $hashed_pword, $uname);
  
  # Execute the query statement
  mysqli_stmt_execute($stmt);
  
  //Display message to user and a link to login to their account
  echo "Registration successful -- <a href = 'login.php'>LOGIN</a>";
  
  # Close the statement
  mysqli_stmt_close($stmt);
}

# Close the connection
mysqli_close();

?>