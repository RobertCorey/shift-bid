<?php
/**
* Represents a Calendar that can be clicked upon
*/
class Calendar
{
    function __construct($days, $timezone, $database)
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
        $result = $this->database->query("SELECT `emp_f_name`, `emp_l_name`, `bid_emp_number`, `timestamp`, `wager` FROM `bids`, `employee`
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
        $bidList = $this->drawBidList($bids,$maxNumber);
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
        
        $email = $_SESSION['email'];
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
?>
