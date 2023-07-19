<?php
require_once("SimpleRest.php");
require_once("customer.php");
		
class CustomerRestHandler extends SimpleRest {

	function getAllCustomer() {	

		$customer = new customer();
		$rawData = $customer->getAllCustomer();

		if(empty($rawData)) {
			$statusCode = 404;
			$rawData = array('success' => 0);		
		} else {
			$statusCode = 200;
		}

		//var_dump($rawData);
		
		$requestContentType = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : null;
		
		$this->setHttpHeaders($requestContentType, $statusCode);
		
		$result["output"] = $rawData;
				
		if(strpos($requestContentType,'json') !== false){
		
			//echo "sss";
			$response = $this->encodeJson($result);
			echo $response;
		}
		
	}
	
	function editCustomerById() {	
		$customer = new customer();
		$rawData = $customer->editCustomer();
		if(empty($rawData)) {
			$statusCode = 404;
			$rawData = array('success' => 0);		
		} else {
			$statusCode = 200;
		}
		
		$requestContentType = $_SERVER['HTTP_ACCEPT'];
		$this ->setHttpHeaders($requestContentType, $statusCode);
		$result = $rawData;
				
		if(strpos($requestContentType,'application/json') !== false){
			$response = $this->encodeJson($result);
			echo $response;
		}
	}
	
	public function encodeJson($responseData) {
		$jsonResponse = json_encode($responseData);
		return $jsonResponse;		
	}
}
?>