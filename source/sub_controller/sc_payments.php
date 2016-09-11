<?php
require_once('library/paymentManager.php');
$paymentObject= new PaymentManager();


	switch($function){
			case "show_data":
					$data['allPayments'] = $paymentObject->getAllPayments();
			break;
			
			
			
		}

?>
