<?php

//Adapted from https://phppot.com/php/php-restful-web-service/
require_once("CustomerRestHandler.php");
$method = $_SERVER['REQUEST_METHOD'];
$view = "";

if(isset($_GET["resource"]))
	$resource = $_GET["resource"];
if(isset($_GET["page_key"]))
	$page_key = $_GET["page_key"];
/*
controls the RESTful services
URL mapping
*/


switch($resource){
	case "customer":	
		switch($page_key){

			case "list":
				// to handle REST Url /Customer/list/
				
				//echo "list invoked from Customer";
				$customerRestHandler = new CustomerRestHandler();
				$result = $customerRestHandler->getAllCustomers();
			break;
	
			case "update":
				//echo "update invoked from Customer";
				// to handle REST Url /Customer/update/<row_id>
				$customerRestHandler = new CustomerRestHandler();
				$customerRestHandler->editCustomerById();
			break;
		}
	break;	
	
}	
?>
