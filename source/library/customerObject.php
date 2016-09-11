<?
//Vishak Nair - 25/08/2012
//for user management
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class CustomerManager extends commonObject
{
		function getAllCustomers()
		{
			return $resultSet = getData("SELECT * FROM `customers` ");
		}
		
		function getCustomerVariables()
		{
			$varArray['customer_biz_name'] = $_REQUEST['customer_biz_name'];
			$varArray['customer_email'] = $_REQUEST['customer_email'];
			$varArray['customer_phone'] = $_REQUEST['customer_phone'];
			$varArray['customer_plan'] = $_REQUEST['customer_plan'];
			$varArray['address'] = $_REQUEST['address'];
			$varArray['city'] = $_REQUEST['city'];
			$varArray['state'] = $_REQUEST['state'];
			$varArray['zip'] = $_REQUEST['zip'];	
			if(isset($_REQUEST['status']))
			{
				$varArray['status'] = $_REQUEST['status'];		
			}
			return $varArray;
		}
		
		function getCustomerCardDetails()
		{
			$varArray['name'] = $_REQUEST['customer_card_name'];
			$varArray['number'] = $_REQUEST['customer_card_number'];
			$varArray['exp_month'] = $_REQUEST['card_expiry_month'];
			$varArray['exp_year'] = $_REQUEST['card_expiry_year'];
			$varArray['cvc'] = $_REQUEST['card_cvc'];
			return $varArray;
		}
		
		function insertCustomer($customerArray)
		{
			$insertQry = $this->getInsertDataString($customerArray, 'customers');
			updateData($insertQry);
			$newCustomerId =  mysql_insert_id();
			$this->insertIntoCustomerBx($newCustomerId);
			
			return $newCustomerId;
		}
		
	function insertIntoCustomerBx($newCustomerId)
	{
		updateData("insert into customer_bx set customer_id = '".$newCustomerId."', sub_account = '0'");
	}
	
	function getCustomerDetails($user_id)
	{
		return $resultSet = getRow("select * from  customers where customer_id='".$user_id."'");
	}
	
	function updateUsingId($customerArray)
	{
			$updateQry=$this->getUpdateDataString($customerArray,"customers","customer_id");
			updateData($updateQry);
	}
	
	function getCurrentCutomerAccount()
	{
		$customer_id = $_SESSION['customer_id'];
		$customerSubAccount = (int)getOne("select sub_account from customer_bx where customer_id = '".$customer_id."'");
		if($customerSubAccount == 0)
		{
			include_once('library/twilio_handlers/customvbx.class.php');
			$twilioObject = new TwilioExt();
			
			$customerBizName = $this->getCustomerBizName($customer_id);
			$accountSid = $twilioObject->createNewSubAccount($customerBizName);
			updateData(" update customer_bx set sub_account = '".$accountSid."' where customer_id = '".$customer_id."'");
			return $accountSid;
		}
		else
		{
			return $customerSubAccount;
		}
		
	}
	
	function getCutomerAccount($customer_id)
	{
		$customerSubAccount = (int)getOne("select sub_account from customer_bx where customer_id = '".$customer_id."'");
		if($customerSubAccount == 0)
		{
			include_once('library/twilio_handlers/customvbx.class.php');
			$twilioObject = new TwilioExt();
			
			$customerBizName = $this->getCustomerBizName($customer_id);
			$accountSid = $twilioObject->createNewSubAccount($customerBizName);
			updateData(" update customer_bx set sub_account = '".$accountSid."' where customer_id = '".$customer_id."'");
			return $accountSid;
		}
		else
		{
			return $customerSubAccount;
		}
		
	}
	
	function getCustomerBizName($customer_id)
	{
		return getOne("select customer_biz_name from customers where customer_id = '".$customer_id."'");
	}
	
	function getCustomerByPhoneNumber($phoneNumber)
	{
		//echo "select * from customers where customer_id = (select customer_id from phone_numbers where phone_number like '%".substr($phoneNumber,-10)."%')";
		return getOne("select customer_id from customers where customer_id = (select customer_id from phone_numbers where phone_number like '%".substr($phoneNumber,-10)."%')");
	}
	
	function addPhoneNumberToCustomer($numberDetails,$customerId)
	{
		updateData("insert into phone_numbers set 
						phone_number = '".$numberDetails->phone_number."',
						customer_id = '".$customerId."',
						is_active = '1',
						sid = '".$numberDetails->sid."'					
				  ");
	}
	
	function getCustomerLogs($customer_id)
	{
		return getData("select * from activity_log where customer_id = '".$customer_id."' order by time_stamp desc");
	}
	
	function disableAccount($customer_id)
	{
		updateData("update customers set status='In-Active' where customer_id = '".$customer_id."'");
	}
	
	function updateCustomerCredits($customer_id, $mainC, $addonC)
	{
		updateData("update customer_bx set main_credits = '".$mainC."', addon_credits = '".$addonC."' where customer_id  = '".$customer_id."'");
	}
	

}

?>
