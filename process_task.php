<?php

	//Require page
	require('php/global.php');

	//Get post variables from previous page

	$name = $_POST['task_name'];
	$description = $_POST['description'];
	$points = $_POST['points'];

	//Store the data in the database
	//Set up query
	$query = "INSERT INTO tasks (task_name, task_description, task_status, task_point_value)
        VALUES (?, ?, 'Open', ?)";

     # Prepare the query statement
	  if (!$stmt = mysqli_prepare($database, $query)) {
	    die("Error in query");
	  }

	  # Bind parameters to markers
	  mysqli_stmt_bind_param($stmt, 'sss', $name, $description, $points);
	  
	  # Execute the query statement
	  mysqli_stmt_execute($stmt);
	  
	  //Display message to user and a link to login to their account
	  echo "Task has been added! -- <a href = 'addTask.php'>Homepage</a>";
	  
	  # Close the statement
	  mysqli_stmt_close($stmt);

	# Close the connection
	mysqli_close($database);


?>