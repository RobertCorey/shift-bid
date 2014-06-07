<?php 
/**
* Represents an Employee's view the schedule
*/
class Employee
{
    function __construct($id,$database)
    {
        $this->id = $id;
        $this->init();
    }
    public function init()
    {
        $result = $database->query("SELECT * FROM employee WHERE emp_number = '$this->id'");
        
    }
}
 ?>