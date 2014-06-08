<?php 
require 'php/global.php';
$employees = $database->query("SELECT emp_num, emp_f_name, emp_l_name, emp_points FROM employee");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Task</title>
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
    <div class="page-header">
      <h1>Add A New Task</h1>
    </div>
    <div class="row">
      <div class="col-xs-2">
        <div class="row">
          <a href="createShift.php">
            <button type="button" class="btn btn-primary btn-lg menu-button">Create Shifts</button>
          </a>
        </div>
        <div class="row">
          <a href="employee.php">
            <button type="button" class="btn btn-primary btn-lg menu-button">Add Employee</button>
          </a>
        </div> 
        <div class="row">
          <a href="addPoints.php">
            <button type="button" class="btn btn-primary btn-lg menu-button">Grant Users Points</button>
          </a>
        </div>
        <div class="row">
          <a href="addTask.php">
            <button type="button" class="btn btn-primary btn-lg menu-button">Add New Task</button>
          </a>
        </div>
      </div>
      <div class="col-xs-offset-1 col-xs-9">
        <form action="process_task.php" method="POST">
          <div class="form-group">
            <label for="name">Task Name:</label>
            <input type="text" class="form-control" name="task_name" placeholder="Enter task name">
          </div>  
          <div class="form-group">
            <label for="description">Description:</label>
            <input type="text" class="form-control" name="description" placeholder="Enter description">
          </div>
          <div class="form-group">
            <label for="points">Points:</label>
            <input type="text" class="form-control" name="points" placeholder="Enter points">
          </div>
        <button type="submit" id="addTask" class="btn btn-default">Add Task</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/addPoints.js"></script>
</body>
</html>