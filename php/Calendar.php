<?php
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
    
    function __construct($auctionData, $date, $maxNumber, $userEmail, $userBalance, $id)
    {
        $this->proccessBidData($auctionData);
        $this->date = $date;
        $this->maxNumber = $maxNumber;
        $this->userBalance = $userBalance;
        $this->id = $id;
        $this->userEmail = $userEmail;
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
            //min wager is 1 more than current wager
            $minWage = $lastPlaceBid->wager + 1;
            return $minWage;
        }
    } 
    private function isDateOkay()
    {
        $date = strtotime($this->date);
        $currentDate = time();
        $cutOff = $currentDate - (12 * 60 * 60);
        if ($date <= $cutOff) {
            return false;   
        } else {
            return true;
        }
    }
    private function userBalanceOkay()
    {
        if ($this->getMinimumBid() > $this->userBalance) {
            return false;
        } else {
            return true;
        }
    }
    private function userOnList()
    {
        $winners = $this->getWinningBids();
        for ($i=0; $i < count($winners); $i++) { 
            if ($winners[$i]->employee->email === $this->userEmail) {
                return true;            
            }
        }
        return false;
    }
    private function chooseDisplayButton()
    {
        if (!$this->isDateOkay()) {
            return "<button class='btn btn-lg btn-warning disabled'> Bidding Closed </button>";
        } elseif (!$this->userBalanceOkay()) {
            return "<button class='btn btn-lg btn-danger disabled'> Insufficient Points</button>";
        } elseif($this->userOnList()) {
            return "<button class='btn btn-lg btn-info disabled'> You're Currently Winning! </button>";
        } else {
            $form = '<form action="php/placeBid.php" method="POST">';
            $form .= '<input type="hidden" name="shiftID" value="' . $this->id . '">';
            $form .= '<input type="hidden" name="amount" value="' . $this->getMinimumBid() . '">';
            $form .= '<button class="btn btn-lg btn-success" id="bidButton" type="submit">';
            $form .= 'Bid ' . $this->getMinimumBid() . ' points';
            $form .= "</button>";
            $form .= "</form>";
            return $form;
        }
    }
    public function printAuctionModel()
    {
        echo "<h5>" . $this->maxNumber . " Servers needed</h5>";
        $winningBids = $this->getWinningBids();
        $printList = "<div class='spacer'>";
        $printList .= "<table class='table'>";
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
        $printList .= "</div>";
        $printList .= $this->chooseDisplayButton();
        echo $printList;
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
        $auction = new Auction($bids,$data['date_of_shift'], $data['max_num_employees'], $this->userEmail, $userPoints, $id);
        $auction->printAuctionModel();
    }
    public function drawCalendar()
    {
        $unixDates = $this->buildDateArray(-1, $this->days);
        echo '<table class="table">';
        echo '<tr>';
        foreach ($unixDates as $key) {
            echo "<th>";
            echo "<h4>" . str_replace(" ", "/", date("m d Y", $key)) . "</h4>";
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
