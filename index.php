<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shift Bid Homepage</title>

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
        <div class="navbar navbar-default">
            <span class="navbar-brand">Shift Bid</span>
            <form action="check_login.php" class="navbar-form navbar-right" method="POST">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" name="email">
                </div>  
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <button class="btn btn-default">Log In</button>
            </form>
        </div>
        <div class="row">
            <div class="col-xs-6">
                 <img src="shiftBidLogo.png" id="logo">
            </div>
            <div class="col-xs-6">
                <span style="font-size:150%;padding-top:5%;">
                    Give your restaurant's best shifts, to the best people. 
                </span>
            </div>
        </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>