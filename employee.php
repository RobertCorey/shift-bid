<?php 
/*
    Page to add an employee into the database
    *Important: File doesn't check for CSRF Attack
*/
require 'php/global.php';
//Get current  from previous page
//$emp_num= $_SESSION['emp_num'];

$passwordErr = $verify_passwordErr = "";
$fnameErr = $roleErr = "";
$lnameErr = $emailErr = $mismatchErr = $match = "";

// Test the data entered into the form to make sure that required fields are 
// entered, password is verified

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
//First name
  $allCorrect = true;
  if (empty($_POST["first_name"])) {
    $fnameErr = "First name is required";
    $allCorrect = false;
}
else{
    $first_name = $_POST['first_name'];
}
//Last name
if (empty($_POST["last_name"])) {
    $lnameErr = "Last name is required";
    $allCorrect = false;
}
else{
    $last_name = $_POST['last_name'];
}
//email
if (empty($_POST["email"])) {
    $emailErr = "Email is required";
    $allCorrect = false;
}
else{
    $email = $_POST['email'];
}
//Password first entered
if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
    $allCorrect = false;
}
else{
    $password = $_POST['password'];
}
//Confirmed password
if (empty($_POST["verify_password"])) {
    $verify_passwordErr = "Password verification is required";
    $allCorrect = false;
}
else{
    $verify_password = $_POST['verify_password'];
}
//Role
if (empty($_POST["role"])) {
    $roleErr = "Role is required";
    $allCorrect = false;
}
else{
    $role = $_POST['role'];
}
if ($password != $verify_password) {
    $verify_passwordErr .= "<br>Password verification does not match";
    $allCorrect = false;
}
else {
    $match = "match";
}
if ($allCorrect){
    //insert into database  
    // Hash the password to be stored securely in the database
    $hashed_pword = md5($password);
    // Create query string with marker for $uname
    $query = "SELECT * FROM employee WHERE emp_email = ?";
    // Prepare the query statement
    if (!$stmt = mysqli_prepare($database, $query)) {
        die("Error in query");
    }
    // Bind the parameter $email to ? marker in the query string
    mysqli_stmt_bind_param($stmt, 's', $email);
    // Execute the query statement
    mysqli_stmt_execute($stmt);
    // Store the result so we can get number of rows
    mysqli_stmt_store_result($stmt);
    // Find out how many rows in the result 
    $rows = mysqli_stmt_num_rows($stmt);
    if ($rows != 0) {
        $emailErr .= "Email Already exists!";
        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        // Create query to submit the registration information to the database
        $query = "INSERT INTO employee (emp_f_name, emp_l_name, emp_role, emp_points, emp_email, emp_password)
            VALUES (?, ?, ?, 0, ?, ?)";
        // Prepare the query statement
        if (!$stmt = mysqli_prepare($database, $query)) {
            die("Error in query");
        }
        // Bind parameters to markers
        mysqli_stmt_bind_param($stmt, 'sssss', $first_name, $last_name, $role, $email, $hashed_pword);
        // Execute the query statement
        mysqli_stmt_execute($stmt);
        echo '<div class="alert alert-success">Registration Successful! <a href=\'index.php\'>LOGIN</a></div>';
        // Close the statement
            mysqli_stmt_close($stmt);
        }
    // Close the connection
    mysqli_close($database);
    }
}
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Employee Page</title>
  <link rel="stylesheet" href="css/global.css">
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
    <h1>Add An Employee</h1>
  </div>
    <div class="row">
      <div class="col-xs-2 float-left">
        <div class="row">
          <a href="createShift.php"><button type="button" class="btn btn-primary btn-lg menu-button">Create Shifts</button></a>
        </div>
        <div class="row">
          <button type="button" class="btn btn-primary btn-lg menu-button disabled">Add Employee</button>
        </div> 
      </div>
      <div class="col-xs-offset-1 col-xs-9">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" class="form-control" name="first_name" placeholder="Enter first name" value=<?php if(isset($_POST['first_name'])){ echo $_POST['first_name'];}?>>
            <span class="error"> <?php echo $fnameErr;?></span>
          </div>  
          <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" class="form-control" name="last_name" placeholder="Enter last name" value=<?php if (isset($_POST['last_name'])){echo $_POST['last_name'];}?>>
            <span class="error"> <?php echo $lnameErr;?></span>
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" name="email" placeholder="Enter email" value=<?php if (isset($_POST['email'])){echo $_POST['email'];}?>>
            <span class="error"> <?php echo $emailErr;?></span>
          </div>
          <div class="form-group">
            <label for="role">Role:</label>
              <select name="role" id="role" class="form-control">
                <option>Waiter/Waitress</option>
                <option>Manager</option>
                <option>Busboy</option>
                <option>Hostess</option>
                <option>Kitchen</option>
              </select>
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" placeholder="Enter password">
            <span class="error"> <?php echo $passwordErr;?></span>
          </div>
          <div class="form-group">
            <label for="verify_password">Verify Password:</label>
            <input type="password" class="form-control" name="verify_password" placeholder="Retype Password">
            <span class="error"> <?php echo $verify_passwordErr;?></span>
          </div>
          <center><button type = "submit" class="btn btn-primary" onclick="">Submit</button></center>
        </form>
      </div>
    </div>

  </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
  <script ></script>
</body>
</html>

