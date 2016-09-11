<?php
require_once('library/phoneManager.php');
$phoneObject= new phoneManager();
require_once('library/customerObject.php');
$customerObject= new customerManager();


	switch($function){
			case "show_data":
			default:
				$data['allNumbers'] = $phoneObject->getAllNumbersForCustomer();
			break;
			
			case "buy_new":
								
			break;
			
			case "buy_new_number":
				$customerAccount = $customerObject->getCurrentCutomerAccount();
				include_once('library/twilio_handlers/customvbx.class.php');
				$twilioObject = new TwilioExt();
				$newNumber = $_REQUEST['new_phone_number'];
				$numberDetails = $twilioObject->buyNewNumber($newNumber,$customerAccount);
				$customerObject->addPhoneNumberToCustomer($numberDetails,$_SESSION['customer_id']);
				$page = "view_phone_numbers.php";
				$data['allNumbers'] = $phoneObject->getAllNumbersForCustomer();
			break;
			
			case "view_available_numbers":
				include_once('library/twilio_handlers/customvbx.class.php');
				$twilioObject = new TwilioExt();
				$searchCriteria = $_REQUEST['search_criteria'];
				$data['availableNumbers'] = $twilioObject->searchForPhoneNumber($searchCriteria);	
							
			break;
			

		}

?>
