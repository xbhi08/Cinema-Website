<?php
require_once("dbcontroller.php");
/* 
A domain Class to demonstrate RESTful web services
*/
Class customers {
	private $customers = array();
	
	public function getAllcustomer(){
		if(isset($_GET['issuedTickets'])){
			$issuedTickets = $_GET['issuedTickets'];
			$query = 'SELECT * FROM booking WHERE issuedTickets=0';
		} 
		$dbcontroller = new DBController();
		$this->customers = $dbcontroller->executeSelectQuery($query);
		return $this->customers;
	}

	
	public function editcustomer(){
		if(isset($_POST['issuedTickets']) && isset($_GET['bookingID'])){
			$issuedTickets = $_POST['issuedTickets'];
			$booking_id = $_GET['bookingID'];
			$query = "UPDATE booking SET issuedTickets = 1";
			$data = [$issuedTickets];
			$dbcontroller = new DBController();
			$result= $dbcontroller->executeQuery($query, $data);
			if($result != 0){
				$result = array('success'=>1);
				return $result;
			}
		}
		
	}
	
}
?>