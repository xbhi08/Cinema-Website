<?php
require_once("dbcontroller.php");
/* 
A domain Class to demonstrate RESTful web services
*/
Class customer {
	private $customer = array();
	
	public function getAllcustomer(){
		if(isset($_GET['customerID'])){
			$customerID = $_GET['customerID'];
			$query = 'SELECT * FROM booking WHERE customerID='.$customerID.' AND issuedTickets=0';
		} 
	 
		$dbcontroller = new DBController();
		$this->customer = $dbcontroller->executeSelectQuery($query);
		return $this->customer;
	}

	
	public function editCustomer(){
		if(isset($_POST['issuedTickets']) && isset($_GET['bookingID']) ){
			$issuedTickets = $_POST['issuedTickets'];
			$bookingID = $_GET['bookingID'];
			$query = "UPDATE booking SET issuedTickets = ? WHERE bookingID =?";
			$data = [$issuedTickets,$bookingID];
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