<?
//Vishak Nair - 25/08/2012
//for user management
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class PlanManager extends commonObject
{
		function getPlanVariables()
		{
			$planDetails = array();
			$planDetails['plan_name'] = $_REQUEST['plan_name'];
			$planDetails['phone_numbers'] = $_REQUEST['phone_numbers'];
			$planDetails['credits'] = $_REQUEST['credits'];
			$planDetails['type'] = $_REQUEST['type'];
			$planDetails['cost'] = $_REQUEST['cost'];
			$planDetails['is_active'] = $_REQUEST['is_active'];
			
			return $planDetails;
		}
		
		function getNextAutoId()
		{
			$tableStatus = getRow("SHOW TABLE STATUS WHERE name = 'plans';");
			return $autoIncrementId = $tableStatus['Auto_increment'];
		}
		
		function updateUsingId($dataArray)
		{
			$updateQry=$this->getUpdateDataString($dataArray,"plans","plan_id");
			updateData($updateQry);
		}
		
		function insertPlan($varArray)
		{
			$insertQry = $this->getInsertDataString($varArray, 'plans');
			updateData($insertQry);
			return mysql_insert_id();
		}
		
		function getPlanDetails($planId)
		{
			return getRow("select * from plans where plan_id = '".$planId."'");
		}
		
		function getAllMainPlans()
		{
			return getData("SELECT * FROM `plans` where type='main'");
		}
		
		function getRealMainPlans()
		{
			return getData("SELECT * FROM `plans` where type='main' and plan_name != 'Trial Plan'");
		}
		
		function getRealAddonPlans()
		{
			return getData("SELECT * FROM `plans` where type='addon' and plan_name != 'Trial Plan'");
		}
		
		function checkPlanChanged($planId, $customerId)
		{
			$currentaPlanId = (int)getOne("select customer_plan from customers where customer_id = '".$customerId."'");
			$planId = (int)$planId;
			if($currentaPlanId == $planId)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		function applyPlan($planId, $customerId)
		{
			$planCredits = getOne("select credits from plans where plan_id = '".$planId."'");
			updateData("update customer_bx set main_credits = '".$planCredits."' where customer_id = '".$customerId."'");
		}
	
		function applyAddonPlan($planId, $customerId)
		{
			$planCredits = getOne("select credits from plans where plan_id = '".$planId."'");
			updateData("update customer_bx set addon_credits = (addon_credits + '".$planCredits."') where customer_id = '".$customerId."'");
		}
		
		function getCustomerCredits($customerId)
		{
			return getRow("select * from customer_bx where customer_id = '".$customerId."'");
		}
		
}

?>
