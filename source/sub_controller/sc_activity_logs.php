<?php
require_once('library/customerObject.php');
$customerObject = new CustomerManager();


	switch($function){
			case "show_data":
				$data['allCustomers'] = $customerObject->getAllCustomers();
				$countSz = sizeof($data['allCustomers']);
				$data['allCustomers'][$countSz]['cutomer_id'] = '0';
				$data['allCustomers'][$countSz]['customer_biz_name'] = 'Admin & General Data';
			break;
			
			case "get_logs":
				$selectedCustomer = $_REQUEST['customer'];
				$data['customerLogs'] = $customerObject->getCustomerLogs($selectedCustomer);
				$data['allCustomers'] = $customerObject->getAllCustomers();
				$countSz = sizeof($data['allCustomers']);
				$data['allCustomers'][$countSz]['cutomer_id'] = '0';
				$data['allCustomers'][$countSz]['customer_biz_name'] = 'Admin & General Data';
			break;
	}