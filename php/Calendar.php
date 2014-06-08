<?php 
/**
* Represents a Calendar that can be clicked upon
*/
class Calender
{
    
    function __construct($days,$timezone, $database)
    {
        $this->days = $days;
        $this->database = $database;
        date_default_timezone_set($timezone);
    }
    private function buildDateArray($start, $end)
    {
        $dates = [];
        while($start < $end){
            $relativeDate = $start . " days";
            $dates[] = date("U",strtotime($relativeDate));
            $start += 1;
        }
        return $dates;
    }
    private function generateShiftBlock($id,$maxNumber)
    {
        $result = $this->database->query("SELECT `bid_emp_number`, `timestamp`, `wager` FROM `bids`
            WHERE shift = '$id'
            ORDER BY `timestamp` DESC");
        $leaderBoard = "<ul>";
        for ($i=0; $i < $maxNumber; $i++) { 
            $bidInfo = $result->fetch_assoc();
            $employeeID = $bidInfo['bid_emp_number'];
            $wager = $bidInfo['wager'];
            $employeeInfo = $this->database->query("SELECT emp_f_name, emp_l_name FROM employee WHERE emp_num = '$employeeID'");
            if ($employeeInfo->num_rows === 0) {
                if ($i === 0) {
                    $maxWager = 0;
                }
                $leaderBoard .= "<li> Shift Spot Open</li>";
            } else {
                if ($i === 0 ) {
                    $maxWager = $wager;
                }
                $employeeName = $employeeInfo->fetch_assoc();
                $leaderBoard .= "<li>" . $employeeName['emp_f_name'] . " " . $employeeName['emp_l_name'] . " Bid: " . $wager . "</li>";
            }
        }
        $leaderBoard .= "</ul>";
        $leaderBoard .= $this->drawBidButton($maxWager);
        return $leaderBoard;
    }
    private function drawBidButton($maxBid)
    {
        $str = 
      '<form action="validateBid.php">
        <input type="text" name="bidAmount" size="1" value="' . ($maxBid += 1) .'">
        <input type="hidden" name="maxBid" value="' . $maxBid . '">
        <button class="btn btn-default">Submit Bid!</button>
      </form>';
        return $str;
    }
    public function drawCalendar()
    {
        $unixDates = $this->buildDateArray(-1, $this->days);
        date_default_timezone_set("America/New_York");
        echo '<table class="table">';
        echo '<tr>';
        foreach ($unixDates as $key) {
            echo "<th>";
            echo date("m d Y", $key);
            echo "</th>";
        }
        echo "</tr>";
        echo "<tr>";
        foreach ($unixDates as $key) {
            $mysqlFormattedDate = date("Y m d",$key);
            $mysqlFormattedDate = str_replace(" ", "/", $mysqlFormattedDate);
            $result = $this->database->query("SELECT shift_id, max_num_employees
                FROM shifts 
                WHERE date_of_shift = '$mysqlFormattedDate'
                ");
            echo "<td class='shiftBlock'>";
            if ($result->num_rows === 0) {
                echo "No Shift during this time";
            } else {
                $data = $result->fetch_assoc();
                $id = $data['shift_id'];
                $maxNumEmployees =  $data['max_num_employees'];
                echo $this->generateShiftBlock($id,$maxNumEmployees);
            }
            echo "</td>";
        }
        echo "</tr>";
        echo "</table>";
    }
}
$database = mysqli_connect("localhost", "root", "jaFuw7eNu", "shift-bid") or die;
$cal = new Calender(4,"America/New_York", $database);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>
    <link rel="stylesheet" href="../css/global.css">
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
    <div class="container">
        <?php $cal->drawCalendar(); ?>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>