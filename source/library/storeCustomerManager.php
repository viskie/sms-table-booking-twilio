<?
//Vishak Nair - 25/08/2012
//for user management
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class StoreCustomerManager extends commonObject
{
		function getAllCustomerLists($customerId)
		{
			return getData("select * from store_customer_lists where customer_id = '".$customerId."'");
		}
		
		function getAllStoreCustomers()
		{
			return $resultSet = getData("SELECT * FROM `store_customers` where customer_id = '".$_SESSION['customer_id']."' ");
		}
		
		function gtAllCustomersInList($listId)
		{
			return getData("select * from store_customers where sc_id in (select DISTINCT store_customer_id from queue_history where list_id ='".$listId."')");	
		}
		
		function getCustomerVariables()
		{
			$varArray['customer_biz_name'] = $_REQUEST['customer_biz_name'];
			$varArray['customer_email'] = $_REQUEST['customer_email'];
			$varArray['customer_phone'] = $_REQUEST['customer_phone'];
			$varArray['address'] = $_REQUEST['address'];
			$varArray['city'] = $_REQUEST['city'];
			$varArray['state'] = $_REQUEST['state'];
			$varArray['zip'] = $_REQUEST['zip'];	
			$varArray['status'] = $_REQUEST['status'];		
			return $varArray;
		}
		
		
	function getCustomerDetails($sc_id)
	{
		return  getRow("select * from  store_customers where sc_id='".$sc_id."'");
	}
	
	function getCustomerNumber($sc_id)
	{
		return  getOne("select phone_number from  store_customers where sc_id='".$sc_id."'");
	}
	
	function getAllUnsubscribers()
	{
		$uSubData = getData("select * from unsubscribers where customer_id = '".$_SESSION['customer_id']."'");
		for($i=0;$i<sizeof($uSubData);$i++)
		{
			//echo "<pre>"; print_r($uSubData[$i]); exit;
			$customerDetails = $this->getCustomerDetails($uSubData[$i]['customer_id']);
			foreach($customerDetails as $key => $value1)
			{
				$uSubData[$i][$key] = $value1;
			}
		}
		return $uSubData;
	}
	
}

?>
