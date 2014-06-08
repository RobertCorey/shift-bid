<?php 
/*
    Page to add an employee into the database
    *Important: File doesn't check for CSRF Attack
*/

session_start();

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

  //Check to see if the two password matches
  if (!$password || !$verify_password){
    //display nothing
  }
  else{
    if ($password != $verify_password) {
        $mismatchErr = "Password verification does not match";
        $allCorrect = false;
    }
    else {
        $match = "match";
    }
}

  if ($allCorrect){
  
    // When all of the data passes the verification, session variables are set 
    // and page is redirected to register.php
  
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['emp_email'] = $email;
    $_SESSION['role'] = $role;
    $_SESSION['password'] = $password;
    header('Location: add_employee.php');
    exit();
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
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
    <div class="container">

        <div class="jumbotron">
            <p><bold><center><font size="40px">ADD EMPLOYEE</center></font></bold></p>
        </div>
        <div class="jumbotron">
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
                    <label for="role">Role:</label>
                    <input type="text" class="form-control" name="role" placeholder="Enter role" value=<?php if (isset($_POST['role'])){echo $_POST['role'];}?>>
                    <span class="error"> <?php echo $roleErr;?></span>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" name="email" placeholder="Enter email" value=<?php if (isset($_POST['email'])){echo $_POST['email'];}?>>
                    <span class="error"> <?php echo $emailErr;?></span>
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
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script ></script>
</body>
</html>

