<?
//Vishak Nair - 25/08/2012
//for user management
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class QueueManager extends commonObject
{
		function getQueue()
		{
			return getData("SELECT * FROM `queue` where customer_id = '".$_SESSION['customer_id']."' order by status desc, q_id  ");
		}
		
		function latestQueueId()
		{
			$max_id = getOne("select MAX(q_id) from queue  where customer_id = '".$_SESSION['customer_id']."' ");	
			if(trim($max_id) == "")
			{
				$max_id = 0;
			}
			return $max_id;
		}
		
		function getQueueHistory($start_date='',$end_date='')
		{
			if($start_date!='' && $end_date!='')
			{
				return getData("SELECT * FROM `queue_history` where customer_id = '".$_SESSION['customer_id']."' and arrival_timestamp > '".$start_date."' and arrival_timestamp < '".$end_date."' order by arrival_timestamp desc  ");
			}
			else
			{
				return getData("SELECT * FROM `queue_history` where customer_id = '".$_SESSION['customer_id']."' order by arrival_timestamp desc  ");
			}
		}
		
		
		function getQueueHistoryForManager($queueManagerId,$start_date='',$end_date='')
		{
			if($start_date!='' && $end_date!='')
			{
				return getData("SELECT * FROM `queue_history` where customer_id = '".$_SESSION['customer_id']."' and queue_manager_id = '".$queueManagerId."'  and arrival_timestamp > '".$start_date."' and arrival_timestamp < '".$end_date."' order by arrival_timestamp desc ");
			}
			else
			{
				return getData("SELECT * FROM `queue_history` where customer_id = '".$_SESSION['customer_id']."' and queue_manager_id = '".$queueManagerId."' order by arrival_timestamp desc ");
			}
			
		}
		
		function getLists()
		{
			return getData("select * from store_customer_lists where customer_id = '".$_SESSION['customer_id']."'");
		}
		
		function getListName($list_id)
		{
			return getOne("select list_name from store_customer_lists where list_id = '".$list_id."'");
		}
		
		function processQueue($q_id,$action,$category='')
		{
			if($action == 'accept')
			{	include_once('twilio_handlers/customvbx.class.php');
				$twilioObject = new TwilioExt();
				$from = getOne("select phone_number from phone_numbers where customer_id = '".$_SESSION['customer_id']."'");
				$to = getOne("select phone_number from queue where q_id ='".$q_id."'");
				
				updateData("update queue set processing_timestamp = '".time()."', status = '2', queue_manager_id = '".$_SESSION['user_id']."' where q_id = '".$q_id."'");
				$twilioObject->sendSMS($to,$from,"We are ready for! Our expert will be with you shortly!");
			}	
			else if($action == 'ignore')
			{
				$this->processesCustomer($q_id,'Ignored');
			}
			else if($action == 'dispatch')
			{
				$this->processesCustomer($q_id,'Served',$category);
			}
		}
		
		
		function processesCustomer($q_id,$status,$category='')
		{
			$customerDetails = getRow("select * from queue where q_id = '".$q_id."'");
			$store_customer_id = "";
			$store_customer_id = $this->insertStoreCustomer($customerDetails);
			$this->moveToHistory($customerDetails,$store_customer_id,$status,$category);
			$this->deleteFromQueue($q_id);

		}
		
		function insertStoreCustomer($customerDetails)
		{
			$customerCount = (int)getOne("select count(*) from store_customers where phone_number = '".$customerDetails['phone_number']."'");
			if($customerCount > 0)
			{
				$customer_id = getOne("select sc_id from store_customers where phone_number = '".$customerDetails['phone_number']."' and customer_id = '".$_SESSION['customer_id']."'");
				updateData("update store_customers set store_visits = (store_visits+1) where phone_number = '".$customerDetails['phone_number']."'  and customer_id = '".$_SESSION['customer_id']."'");
				return $customer_id;
			}
			else
			{			
				$insertQry = "Insert into store_customers set
							customer_id = '".$_SESSION['customer_id']."',
							store_customer_name = '".$customerDetails['store_customer_name']."',
							phone_number = '".$customerDetails['phone_number']."',
							store_visits = '1'
						";
				updateData($insertQry);
				return mysql_insert_id();
			}
		}
		
		function moveToHistory($customerData,$store_customer_id,$status,$category)
		{
			$insertQry = "Insert into queue_history set
							customer_id = '".$_SESSION['customer_id']."',
							store_customer_id = '".$store_customer_id."',
							arrival_timestamp = '".$customerData['arrival_timestamp']."',
							processing_timestamp = '".$customerData['processing_timestamp']."',
							dispatch_timestamp = '".time()."',
							list_id = '".$category."',
							queue_manager_id = '".$customerData['queue_manager_id']."',
							status = '".$status."'
						";
			updateData($insertQry);
		}
		
		function deleteFromQueue($q_id)
		{
			updateData("delete from queue where q_id = '".$q_id."'");
		}
		
		function addEntryfromSMS($smsObject)
		{	
			$cutomerObject = new CustomerManager();
			
			
			$twilioObject = new TwilioExt();
			//echo "test2"; exit;
			$customerId = $cutomerObject->getCustomerByPhoneNumber($smsObject['To']);
			if(trim($customerId)!="")
			{
				$sms_message = trim(strtoupper($smsObject['Body']));
				if($sms_message == "STOP")
				{
					$store_customer_id = getOne("select sc_if from store_customers where phone_number like '%".substr(trim($smsObject['From']),-10)."%'");
					if($store_customer_id != "")
					{
						updateData("insert into unsubscribers set store_customer_id = '".$store_customer_id."', time_stamp = '".time()."', customer_id = '".$customerId."'");
					}
				}
				else
				{
					
					$updateQry = "Insert into queue set 
									customer_id = '".$customerId."',
									store_customer_name = '".$smsObject['Body']."',
									phone_number = '".trim($smsObject['From'])."',
									arrival_timestamp = '".time()."',
									status = '1'
								 ";
					updateData($updateQry);
					$twilioObject->sendSMS($smsObject['From'],$smsObject['To'],"You have been added to the queue. We will be sending you another message when ready for you.");
				}
			}
	
		}
		
		function addEntryfromHost($customerName, $phone_number, $fromNumber)
		{
			
			$cutomerObject = new CustomerManager();
			
			$twilioObject = new TwilioExt();

			$customerId = $_SESSION['customer_id'];
			
			
			if(trim($customerId)!="")
			{
				$sms_message = trim(strtoupper($customerName));
									
					$updateQry = "Insert into queue set 
									customer_id = '".$customerId."',
									store_customer_name = '".$customerName."',
									phone_number = '".trim($phone_number)."',
									arrival_timestamp = '".time()."',
									status = '1'
								 ";
					updateData($updateQry);
					$twilioObject->sendSMS($fromNumber,$phone_number,"You have been added to the queue. We will be sending you another message when ready for you.");
			}
	
		}


}

?>
