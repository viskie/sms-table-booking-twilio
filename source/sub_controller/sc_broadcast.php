<?php
require_once('library/storeCustomerManager.php');
$scObject= new StoreCustomerManager();



	switch($function){
			case "show_data":
			default:
				$data['allLists'] = $scObject->getAllCustomerLists($_SESSION['customer_id']);
			break;
			
			case "step2":
				//echo "<pre>"; print_r($_REQUEST); exit;
				$data['selectedCustomers'] = array();
				$selectedList = (int)trim($_REQUEST['cusomer_list']);
				if($selectedList == 0)
				{
					$data['selectedCustomers'] = $scObject->getAllStoreCustomers();
				}
				else
				{
					$data['selectedCustomers'] = $scObject->gtAllCustomersInList($selectedList);
				}
				
				$data['allLists'] = $scObject->getAllCustomerLists($_SESSION['customer_id']);				
			break;
			
		case "step3":
			$sc_id = $_REQUEST['sc_id'];
			$data['selectedCustomers'] = array();
			$data['customerIdString'] = "";
			foreach($sc_id as $value)
			{
				$data['selectedCustomers'][] =$scObject->getCustomerDetails($value);
				$data['customerIdString'].= $value.",";
			}
			$data['customerIdString'] = rtrim($data['customerIdString'], ",");
		break;
		
		case "step4":
			//echo "<pre>"; print_r($_REQUEST); exit;
			require_once('library/twilio_handlers/customvbx.class.php');
			$twilioObject= new TwilioExt();
			$selectedCustomers = explode(",",$_REQUEST['customer_id_string']);
			$broadcastMessage = $_REQUEST['broadcast_message'];
			if(trim($broadcastMessage) == "")
			{
				$notificationArray['type'] = 'Failed';
				$notificationArray['message'] = 'Broadcast Message cannot be Empty!!';
			}
			else
			{
				$fromNumber = getOne("select phone_number from phone_numbers where customer_id = '".$_SESSION['customer_id']."'");
				foreach($selectedCustomers as $value)
				{
					$customerNumber = $scObject->getCustomerNumber($value);
					$twilioObject->sendSMS($customerNumber,$fromNumber,$broadcastMessage);
				}
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = 'Message Broadcasted Sucessfully!';
				$data['allLists'] = $scObject->getAllCustomerLists($_SESSION['customer_id']);
			}
		break;
		}

?>
