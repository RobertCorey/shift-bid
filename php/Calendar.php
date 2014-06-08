<?php
/**
* 
*/
class Employee
{
    
    function __construct($firstName,$lastName,$email)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }
    public function printName()
    {
        return $this->firstName . " " . $this->lastName;
    }
}
/**
* represents a Bid
*/
class Bid
{
    
    function __construct($bidData)
    {
        $this->proccessBidData($bidData);
    }
    private function proccessBidData($data)
    {
        $this->employee = new Employee(
            $data['emp_f_name'],
            $data['emp_l_name'],
            $data['emp_email']);
        $this->wager = $data['wager'];
        $this->timestamp = $data['timestamp'];
    }
    public function printBidRow()
    {
        $rowStr = "";
        $rowStr .= "<td>" . $this->employee->printName() . "</td>";
        $rowStr .= "<td>" . $this->wager . " points</td>";
        return $rowStr;
    }

}
/**
* Auction List
*/
class Auction
{
    
    function __construct($auctionData,$date,$maxNumber,$userEmail,$userBalance)
    {
        $this->proccessBidData($auctionData);
        $this->date = $date;
        $this->maxNumber = $maxNumber;
        $this->userBalance = $userBalance;
    }

    private function proccessBidData($auctionData)
    {
        $this->bids = [];
        for ($i=0; $i < count($auctionData); $i++) {
            $this->bids[] = new Bid($auctionData[$i]);
        }
        $this->numBids = count($this->bids);
    }
    // Assumes bids are sorted newest to oldest and that a newer bid cannot be entered if it's wager is smaller
    private function getWinningBids()
    {
        //if the number of bids is less than max they're all winners
        if ($this->numBids < $this->maxNumber) {
            return $this->bids;
        } else {
            return array_slice($this->bids,0,$this->maxNumber);
        }
    }
    private function getMinimumBid()
    {
        //if there are spots the minimum is 1
        if ( count($this->bids) < $this->maxNumber ) {
            return 1;
        } else {
            $winningBids = $this->getWinningBids();
            $lastPlaceBid = $winningBids[count($winningBids) - 1];
        }
    } 
    private function isDateOkay()
    {
        $date = strtotime($this->date);
        $currentDate = time();
        $cutOff = $currentDate - (12 * 60 * 60);
        if ($date > $cutOff) {
            return false;   
        } else {
            return true;
        }
    }
    private function userBalanceOkay()
    {
    
    }
    private function printWinnerList()
    {
        $winningBids = $this->getWinningBids();
        $printList = "<table class='table'>";
        $printList .= "<tr> <th> Name </th> <th> Bid </th> </tr> ";
        for ($i=0; $i < $this->maxNumber; $i++) { 
            $printList .= "<tr>";
            if (isset($this->bids[$i])) {
                $printList .= $this->bids[$i]->printBidRow();
            } else {
                $printList .= "<td> Spot Open, Bid Now! </td><td> 0 </td>";
            }
            $printList .= "</tr>";
        }
        $printList .= "</table>";
        if (!$this->isDateOkay()) {
            $printList .= "<button class='btn btn-lg btn-warning disabled'> Bidding Closed </button>";
        } elseif (true) {
            echo "true";
        }
        echo $printList;
    }
    public function test()
    {
        print_r($this->printWinnerList());
    }
    public function printAuctionStatus($value='')
    {
        
    }

}
/**
* Represents a Calendar that can be clicked upon
*/
class Calendar
{
    function __construct($days, $timezone, $database, $userEmail)
    {
        $this->days = $days;
        $this->database = $database;
        $this->userEmail = $userEmail;
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
        $result = $this->database->query("SELECT `emp_f_name`, `emp_l_name`, `emp_email`, `wager` , `timestamp`  FROM `bids`, `employee`
            WHERE shift = '$id'
            AND employee.emp_num = bids.bid_emp_number
            ORDER BY `timestamp` DESC");
        while($data = $result->fetch_assoc()){
            $bids[] = $data;
        }
        $result = $this->database->query("SELECT `date_of_shift`, `max_num_employees` FROM `shifts` WHERE `shift_id` = '$id'");
        $data = $result->fetch_assoc();
        $result = $this->database->query("SELECT `emp_points` FROM `employee` WHERE emp_email = '$this->userEmail' ");
        $userPoints = $result->fetch_assoc()['emp_points'];
        $auction = new Auction($bids,$data['date_of_shift'], $data['max_num_employees'], $this->userEmail, $userPoints);
        $auction->test();
    }
    private function drawBidList($bids,$maxNumber)
    {
        $bidList = "<table class='table table-condensed'>";
        $bidList .= "<tr> <th> Employee </th> <th>Bid</th> </tr>";
        for ($i=0; $i < $maxNumber; $i++) {
            $bidList .= "<tr>";
            //if there are more spots than there are bids
            if ($i >= count($bids)) {
                $bidList .= "<td> Open Shift Spot! </td>";
            } else {
                $bidList .= "<td>" . $bids[$i]['emp_f_name'] . " " . $bids[$i]['emp_l_name'];
                $bidList .= "<td>" . $bids[$i]['wager'] . "</td>";
            }
            $bidList .= "</tr>";
        }
        $bidList .= "</table>";
        return $bidList;
    }
    private function drawBidButton($minBid)
    {
        
        $email = $this->userEmail;
        $result = $this->database->query("SELECT emp_points FROM employee WHERE emp_email = '$email'");
        $data = $result->fetch_assoc();
        $points = $data['emp_points'];
        $str = '<form action="php/submitBid.php" method="POST">';
        $str .= '<input type="hidden" name="maxBid" value="' . $minBid . '">';
        $str .= '<button class="btn btn-success">';
        $str .= ' Claim a spot for ' . ($minBid + 1) . ' points!</button>';
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
