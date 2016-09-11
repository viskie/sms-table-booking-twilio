<?php
require_once('library/userObject.php');
$userObject= new UserManager();
require_once('library/groupObject.php');
$groupObject= new GroupManager();
require_once('library/customerObject.php');
$customerObject = new CustomerManager();
require_once('library/planManager.php');
$planObject = new PlanManager();


	switch($function){
			case "show_data":
					$data['allCustomers'] = $customerObject->getAllCustomers();
			break;
			
			case "show_add_customer":
				$page = "add_edit_customers.php";
				$data['allPlans'] = $planObject->getAllMainPlans();
				
			break;
			
			case "add_customer":
					$userVariables = $userObject->getUserVariables();
					if(!$userObject->isUserExist($userVariables['user_name'])){	
						
						$userPassword=$userVariables['user_password'];
						$userVariables['user_password']="";
						$user_id=$userObject->insertUser($userVariables);
						$userObject->setPassword($userPassword,$user_id);

						$customerVariables = $customerObject->getCustomerVariables();
						$customerVariables['customer_admin_user_id'] = $user_id;
						$customerIdInserted = $customerObject->insertCustomer($customerVariables);
											
						$userObject->updateCustomerId($user_id,$customerIdInserted);
					    
						$customerPlan = $_REQUEST['customer_plan'];
						$planApplied = $planObject->applyPlan($customerPlan, $customerIdInserted);
					    
						include_once('library/stripeManager.php');
						$stripeObject = new StripeManager();
						$customerVariables['card'] = $customerObject->getCustomerCardDetails();
						$customerVariables['customer_id'] = $customerIdInserted;
						$stripStatus = $stripeObject->createCustomer($customerVariables);
						
						$data['allGroups']=$groupObject->getAllGroups();
						$page = "manage_customers.php";
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = 'Customer Inserted Successfully!';
						
						
												
					}else{
						
						$data['allGroups']=$groupObject->getAllGroups();
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = 'Duplicate User with the same Username found!!';
					}
				$data['allCustomers'] = $customerObject->getAllCustomers();
					
				
			break;
			
			case "edit_customer":
				$customerId = $_REQUEST['edit_id'];				
				$customerDetails = $customerObject->getCustomerDetails($customerId);
			   $data['customerDetails'] = $customerDetails;				
			
				$userId  = $customerDetails['customer_admin_user_id'];
				$userDetails=$userObject->getUserDetails($userId);
				$data['userDetails'] = $userDetails;
				$data['allPlans'] = $planObject->getAllMainPlans();
				$page="add_edit_customers.php";
			break;
			
			case "edit_user_entry":
			//echo "<pre>"; print_r($_REQUEST); exit;
						
						$customerId = $_REQUEST['customer_id'];
						$customerPlan = $_REQUEST['customer_plan'];
						if($planObject->checkPlanChanged($customerPlan, $customerId))
						{
							$planApplied = $planObject->applyPlan($customerPlan, $customerId);
						}
						
						$userVariables = $userObject->getUserVariables();
						$customerVariables = $customerObject->getCustomerVariables();
						$customerVariables['customer_id'] = $_REQUEST['customer_id'];
						
						$userVariables['user_id']=$_REQUEST['user_id'];
						$userPassword=$userVariables['user_password'];
					
						unset($userVariables['user_password']);
						$previousPass=$userObject->getUserPassword($userVariables['user_id']);
						$userObject->updateUsingId($userVariables);
						$sha1_currentpass=sha1($userPassword);
						if(!($sha1_currentpass==$previousPass)  && !($sha1_currentpass==sha1('********'))){
							$userObject->setPassword($userPassword,$userVariables['user_id']);
						}
						
						$customerObject->updateUsingId($customerVariables);
						
						
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = 'Customer Updated Successfully!';
						$page="manage_customers.php";
						$data['']=$groupObject->getAllGroups();
					    $data['allCustomers'] = $customerObject->getAllCustomers();

			break;

			case "view_customer_details":
				
				$selectedCustomer = $_REQUEST['edit_id'];
				$data['customerProfile'] = $customerObject->getCustomerDetails($selectedCustomer);
				$data['planDetails'] = $planObject->getPlanDetails($data['customerProfile']['customer_plan']);
				$data['customerCredits'] = $planObject->getCustomerCredits($selectedCustomer);
				$page = "view_customer_details.php";
			break;
			
			case "disable_account":
				$customerId = $_REQUEST['edit_id'];
				$customerObject->disableAccount($customerId);
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = 'Customer Account Disabled Successfully!';
				$data['customerProfile'] = $customerObject->getCustomerDetails($customerId);
				$data['planDetails'] = $planObject->getPlanDetails($data['customerProfile']['customer_plan']);
				$data['customerCredits'] = $planObject->getCustomerCredits($customerId);
				$page = "view_customer_details.php";
			break;
			
			case "edit_credits":
				$customerId = $_REQUEST['edit_id'];
				$main_credits = $_REQUEST['main_credits'];
				$addon_credits = $_REQUEST['addon_credits'];
				$customerObject->updateCustomerCredits($customerId, $main_credits, $addon_credits);
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = 'Customer Credits Updated Successfully!';
				$data['customerProfile'] = $customerObject->getCustomerDetails($customerId);
				$data['planDetails'] = $planObject->getPlanDetails($data['customerProfile']['customer_plan']);
				$data['customerCredits'] = $planObject->getCustomerCredits($customerId);
				$page = "view_customer_details.php";
			break;
			
			case "buy_numbers_for_customer":
				$page = "buy_phone_number.php";
				$data['selected_customer'] = $_REQUEST['edit_id'];
			break;
			
			case "view_available_numbers_fc":
				$customerId = $_REQUEST['customer_id'];
				include_once('library/twilio_handlers/customvbx.class.php');
				$twilioObject = new TwilioExt();
				$searchCriteria = $_REQUEST['search_criteria'];
				$data['availableNumbers'] = $twilioObject->searchForPhoneNumber($searchCriteria);	
			break;
			
			case "buy_new_number_for_customer":
				$customerId = $_REQUEST['customer_id'];
				$customerAccount = $customerObject->getCutomerAccount($customerId);
				include_once('library/twilio_handlers/customvbx.class.php');
				$twilioObject = new TwilioExt();
				$newNumber = $_REQUEST['new_phone_number'];
				$numberDetails = $twilioObject->buyNewNumber($newNumber,$customerAccount);
				$customerObject->addPhoneNumberToCustomer($numberDetails,$_SESSION['customer_id']);
				$data['customerProfile'] = $customerObject->getCustomerDetails($customerId);
				$data['planDetails'] = $planObject->getPlanDetails($data['customerProfile']['customer_plan']);
				$data['customerCredits'] = $planObject->getCustomerCredits($customerId);
				$page = "view_customer_details.php";
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = 'Phone Number purchased Successfully for Customer!';
			break;
			
		}

?>
