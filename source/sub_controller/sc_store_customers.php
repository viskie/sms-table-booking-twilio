<?php
require_once('library/storeCustomerManager.php');
$storeCustomerObject= new StoreCustomerManager();

	switch($function){
			case "show_data":
			default:
				$data['allCustomers'] = $storeCustomerObject->getAllStoreCustomers();
			break;
			
			case "show_unsub":
				$data['allCustomers'] = $storeCustomerObject->getAllUnsubscribers();				
				
			break;
			

		}

?>
