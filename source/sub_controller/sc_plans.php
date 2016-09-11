<?php
require_once('library/planManager.php');
$planObject= new PlanManager();

	switch($function){
			case "show_data":
					$data['allPlans'] = $planObject->getRealMainPlans();
					$data['allAddonPlans'] = $planObject->getRealAddonPlans();
					$page = "manage_plans.php";
			break;
			
			case "edit_plan":
					$edit_id = $_REQUEST['edit_id'];
					$data['planDetils'] = $planObject->getPlanDetails($edit_id);
					$page = "add_new_plan.php";
			break;
			
			case "edit_plan_entry":
					require_once('library/stripeManager.php');
					$stripeObject= new StripeManager();
					$planDetails = $planObject->getPlanVariables();
					$planDetails['plan_id'] = $_REQUEST['edit_id'];
					
					if($planDetails['type']=="main")
					{
						$stripeInsertStatusArr = $stripeObject->updatePlan($planDetails);

						if($stripeInsertStatusArr['stripeStatus'] == 1)
						{
							$planObject->updateUsingId($planDetails);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] = 'Plan Modified Successfully!';
						}
						else
						{
							$notificationArray['type'] = 'Failed';
							$notificationArray['message'] = $stripeInsertStatusArr['error'];
						}
					}
					else
					{
						$planObject->updateUsingId($planDetails);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = 'Plan Modified Successfully!';
					}
					
					$data['allPlans'] = $planObject->getRealMainPlans();
					$data['allAddonPlans'] = $planObject->getRealAddonPlans();
			break;
			
			case "add_plan":
					$page = "add_new_plan.php";
			break;
			
			case "add_plan_entry":
					require_once('library/stripeManager.php');
					$stripeObject= new StripeManager();
					
					$planDetails = $planObject->getPlanVariables();
					
					if($planDetails['type']=="main")
					{
						$planDetails['plan_id'] = $planObject->getNextAutoId();
						$stripeInsertStatusArr = $stripeObject->createPlan($planDetails);

						if($stripeInsertStatusArr['stripeStatus'] == 1)
						{
							$planObject->insertPlan($planDetails);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] = 'Plan Added Successfully!';
						}
						else
						{
							$notificationArray['type'] = 'Failed';
							$notificationArray['message'] = $stripeInsertStatusArr['error'];
						}
					}
					else
					{
						$planObject->insertPlan($planDetails);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = 'Plan Added Successfully!';
					}
					$data['allPlans'] = $planObject->getRealMainPlans();
					$data['allAddonPlans'] = $planObject->getRealAddonPlans();
			break;
			
			case 'delete_plan':
			
			break;
			
			
		}

?>
