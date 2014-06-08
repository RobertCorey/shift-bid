<?php 
/*
	Page to view an employee's current points
*/

session_start();

//Get current username from previous page
//$emp_num= $_GET['emp_num'];   UNCOMMENT WHEN READY TO TEST!!!!!!!!!!

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Current Points</title>
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/global.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-xs-2">
          <div class="row">
            <button type="button" class="btn btn-primary btn-lg menu-button">Back to Calendar</button>
          </div>  
        </div>

    	<div class="jumbotron">
  			<h1><center>Current Points</center></h1>
  			<!-- php code to get current points for the employee-->
    		<?php

    		//Connect to the database
    		$database = mysqli_connect("localhost", "root", "", "shift-bid") or die(mysqli_error()); 

    		// Retrieve the points from the database with the given emp_num
			$query = "SELECT emp_points
			        FROM employee
			        WHERE emp_num = 1";
			        
			//Prepare the query statement
			if (!$stmt = mysqli_prepare($link, $query)) {
				die("Error in query");
			}

			//Execute the query statement
			mysqli_stmt_execute($stmt);
	
			//Bind the result to the variable 
			mysqli_stmt_bind_result($stmt, $points);

			//Fetch poitns
			mysqli_stmt_fetch($stmt)

      //Close the connection
      mysqli_close($database);
				
			?>

			<p><center><font size="24"><?php echo $points;?></font></center></p>
  		</div>
      </div>
      </div>
    </div>
  </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function(){
        var height = $(".container").height();
        height /= 3;
        $('.shiftBox').css("height",height);
    });
</script>
</body>
</html>