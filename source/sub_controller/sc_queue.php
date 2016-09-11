<?php
require_once('library/queueManager.php');
$queueObject= new QueueManager();

	switch($function){
			case "show_data":
			default:
				$data['queue'] = $queueObject->getQueue();
				$data['lists'] = $queueObject->getLists();
				$data['latest_q_id'] = $queueObject->latestQueueId(); 
			break;
			
			case "host_entry":
				include_once('library/customerObject.php');
				include_once('library/twilio_handlers/customvbx.class.php');
				$scName = $_REQUEST['store_customer_name'];
				$scPhoneNumber = $_REQUEST['phone_number'];
				$fromNumber = getOne("select phone_number from phone_numbers where customer_id = '".$_SESSION['customer_id']."'");
				$queueObject->addEntryfromHost($scName,$scPhoneNumber,$fromNumber);
				$data['queue'] = $queueObject->getQueue();
				$data['lists'] = $queueObject->getLists();
				$data['latest_q_id'] = $queueObject->latestQueueId(); 
			break;
			
			case "process_queue":				
				$q_id = $_REQUEST['edit_id'];
				$action = $_REQUEST[$q_id.'_action']; 
				$list_id = '';
				if(isset($_REQUEST[$q_id.'_category']))
				{
					$list_id = $_REQUEST[$q_id.'_category'];
				}
				
				$queueObject->processQueue($q_id,$action,$list_id);
				$data['queue'] = $queueObject->getQueue();
				$data['lists'] = $queueObject->getLists();
				$data['latest_q_id'] = $queueObject->latestQueueId(); 
			break;
			
			
			//For queue History
			case "show_history":
				require_once('library/storeCustomerManager.php');
				$scManager = new StoreCustomerManager();
				$data['queueHistory'] = $queueObject->getQueueHistory();
				for($i=0;$i<sizeof($data['queueHistory']);$i++ )
				{
					$data['queueHistory'][$i]['store_customer_id'];
					$data['queueHistory'][$i]['storeCustomerDetails'] = $scManager->getCustomerDetails($data['queueHistory'][$i]['store_customer_id']);
				}	
				$data['function'] = "show_history_filtered";
				$data['new_page'] = "view_history.php";		
			break;
			
			case "show_history_filtered":
				require_once('library/storeCustomerManager.php');
				$scManager = new StoreCustomerManager();
				$startDate = strtotime($_REQUEST['start_date']);
				$endDate = strtotime($_REQUEST['end_date']);
				$endDate = strtotime('+1 day', $endDate);
				$data['queueHistory'] = $queueObject->getQueueHistory($startDate,$endDate);
				for($i=0;$i<sizeof($data['queueHistory']);$i++ )
				{
					$data['queueHistory'][$i]['store_customer_id'];
					$data['queueHistory'][$i]['storeCustomerDetails'] = $scManager->getCustomerDetails($data['queueHistory'][$i]['store_customer_id']);
				}
				$data['function'] = "show_history_filtered";
				$data['new_page'] = "view_history.php";	
			break;
			
			case "ajax_queue_poll":
				echo $data['latest_q_id'] = $queueObject->latestQueueId(); 			
			break;
			
			case "ajax_refresh_queue":
				$data['queue'] = $queueObject->getQueue();
				$data['lists'] = $queueObject->getLists();
				include_once('library/commonFunctions.php');
				include_once('views/jaxRespForQueue.php');
			break;
			
		}

?>
