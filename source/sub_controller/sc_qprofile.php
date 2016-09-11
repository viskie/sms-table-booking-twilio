<?php
require_once('library/customerObject.php');
$customerObject= new CustomerManager();
require_once('library/planManager.php');
$planObject = new PlanManager();

	switch($function){
			case "show_data":
			default:
				$data['customerProfile'] = $customerObject->getCustomerDetails($_SESSION['customer_id']);
				$data['planDetails'] = $planObject->getPlanDetails($data['customerProfile']['customer_plan']);
				$data['customerCredits'] = $planObject->getCurrentCustomerCredits();
			break;
			
			case "update_profile":
				//echo "<pre>"; print_r($_REQUEST); exit;
				$customerVariables = $customerObject->getCustomerVariables();
				$customerVariables['customer_id'] = $_SESSION['customer_id'];
				$customerObject->updateUsingId($customerVariables);
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = 'Profile Updated Successfully!';
				$data['customerProfile'] = $customerObject->getCustomerDetails($_SESSION['customer_id']);
			break;
			
			case "change_plan":
				$page = "change_plan.php";
				$data['allPlans'] = $planObject->getRealMainPlans();
				$data['allAddonPlans'] = $planObject->getRealAddonPlans();
				
			break;
			
			case "buy_plan":
				include_once("library/stripeManager.php");
				$stipeObject = new StripeManager();
				
				$planType = trim($_REQUEST['selected_plan_type']);
				$customerPlan = $_REQUEST['selected_plan'];
				if($planType == 'main')
				{
					$stripeStatus = $stipeObject->updateCustomerPlan($_SESSION['customer_id'], $customerPlan);
					if($stripeStatus['stripeStatus']==1)
					{
						$planApplied = $planObject->applyPlan($customerPlan, $_SESSION['customer_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = 'Plan Applied Succesfully!';
					}
					else
					{
						$notificationArray['type'] = 'Failure';
						$notificationArray['message'] = $stripeStatus['error'];
					}
				}
				else if($planType == 'addon')
				{
					$stripeStatus = $stipeObject->chargeForAddonPlan($_SESSION['customer_id'], $customerPlan);
					if($stripeStatus['stripeStatus']==1)
					{
						$planApplied = $planObject->applyAddonPlan($customerPlan, $_SESSION['customer_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = 'Plan Applied Succesfully!';
					}
					else
					{
						$notificationArray['type'] = 'Failure';
						$notificationArray['message'] = $stripeStatus['error'];
					}					
				}
				
				
				$data['customerProfile'] = $customerObject->getCustomerDetails($_SESSION['customer_id']);
				$data['planDetails'] = $planObject->getPlanDetails($data['customerProfile']['customer_plan']);
				$data['customerCredits'] = $planObject->getCurrentCustomerCredits();
			break;
			
	}

?>
