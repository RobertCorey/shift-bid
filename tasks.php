<!-- 

    Page to display current tasks an employee can complete to earn points

 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>How to earn points</title>

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
        <?php require('php/global.php');

            //Add navbar to the page
            addNavBar();

        ?>
        <div class="jumbotron">
            <h1><center><bold>Current Tasks</bold></center></h1>
        </div>
        <div class="jumbotron">

            <?php 
                //Start of php code

                //Set up query to query all open tasks in the database
                $query = "SELECT task_name, task_description, task_point_value FROM tasks WHERE task_status = 'Open'";

                //Check to see if link and query are correct
                if ($stmt = mysqli_prepare($database, $query)) {
                
                # Execute the query statement
                mysqli_stmt_execute($stmt);
                
                # Bind the result to the variables
                mysqli_stmt_bind_result($stmt, $name, $description, $pointValue);

                # Store the result so we can get the number of rows
                mysqli_stmt_store_result($stmt);
                
                # Find out how many rows in the result
                $rows = mysqli_stmt_num_rows($stmt);

                //Set up table
                echo "<table class='table table-hover'>";
                echo "<tr><th>NAME</th><th>DESCRIPTION</th><th>POINT VALUE</th></tr>";
                
                if ($rows > 0) {
                
                    # Loop through the rows of the result and print
                    while (mysqli_stmt_fetch($stmt)) {
                        echo "<tr><td>";
                        echo $name;
                        echo "</td><td>";
                        echo $description;
                        echo "</td><td>";
                        echo $pointValue;
                        echo "</td></tr>";
                    }
                }
                else {
                    echo "<tr>No open tasks at this time.</tr>";
                }

                //End the table
                echo "</table>";
            }

            ?>
        </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>