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
        $bids = [];
        $requiredBid = 1;
        //get information
        $result = $database->query("SELECT `emp_f_name`, `emp_l_name`, `bid_emp_number`, `timestamp`, `wager` FROM `bids`, `employee`
            WHERE shift = '$id'
            AND employee.emp_num = bids.bid_emp_number
            ORDER BY `timestamp` DESC");
        while($data = $result->fetch_assoc()){
            $bids[] = $data;
        }
        if ( count($bids) < $maxNumber ) {
            array_splice($bids,$maxNumber);
            $requiredBid = $bids[count($bids) - 1]['wager'];
        }
        $bidList = $this->drawBidList($bids);
        $bidList .= $this->drawBidButton($maxWager);
        return $bidList;
    }
    private function drawBidList($bids,$maxNumber)
    {
        $bidList = "<ul>";
        for ($i=0; $i < count($maxNumber); $i++) { 
            //if there are more spots than there are bids
            if ($i > count($bids)) {
                $bidList .= "<li> Open Shift Spot! </li>";
            } else {
                $bidList .= "<li>" . $bids['emp_f_name'] . " " . $bids['emp_l_name'] . " Bid: " . $bids['wager'] . "</li>";
            }
        }
        $bidList = "</ul>";
        return $bidList;
    }
    private function drawBidButton($minBid)
    {
        //Get the current Employee's number of points
        $id = $_SESSION['emp_num'];
        $result = $database->query("SELECT emp_points FROM employee WHERE emp_num = '$id'");
        $data = $result->fetch_assoc();
        $points = $data['emp_points'];
        $str = '<form action="php/submitBid.php" method="POST">';
        $str .= '<input type="hidden" name="maxBid" value="' . $maxBid . '">';
        $str .= '<button class="btn btn-success">';
        $str .= ' Claim a spot for ' . ($maxBid + 1) . ' points!</button>';
        $str .= '</form>';
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
// $cal = new Calender(4,"America/New_York", $database);
$result = $database->query("SELECT `emp_f_name`, `emp_l_name`, `bid_emp_number`, `timestamp`, `wager` FROM `bids`, `employee`
            WHERE shift = '15'
            AND employee.emp_num = bids.bid_emp_number
            ORDER BY `timestamp` ASC");
print_r($result->fetch_assoc());
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
        <?php //$cal->drawCalendar(); ?>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>