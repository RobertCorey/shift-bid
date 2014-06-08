<?php 
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    print_r($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Calendar View</title>
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
      <h1>Create A Shift</h1>
    </div>
    <div class="row">
      <div class="col-xs-2">
        <div class="row">
        <button type="button" class="btn btn-primary btn-lg menu-button disabled">Create Shifts</button>
        </div>
        <div class="row">
          <a href="employee.php"><button type="button" class="btn btn-primary btn-lg menu-button">Add Employee</button></a>
        </div> 
      </div>
      <div class="col-xs-offset-1 col-xs-9">
      <form role="form" action="createShift.php" method="POST">
          <div class="form-group">
          <label for="shiftDate">What Day is the Shift?</label>
          <input type="date" class="form-control" name="shiftDate">
        </div>
        <div class="form-group">
          <label for="numStaffNeeded">How many Staff Members will be needed that day?</label>
          <input type="number" name="numStaffNeeded" min="1" max="99">
        </div>
        <button class="btn btn-default" type="submit">Add Shift</button>
      </form>
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