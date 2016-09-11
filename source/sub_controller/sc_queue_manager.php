<?php
require_once('library/userObject.php');
$userObject= new UserManager();

	switch($function){
			case "show_data":
			default:
				$data['allQManagers'] = $userObject->getAllQManagersForCustomer();
			break;
			
			
			
			case "add_user":
					require_once('library/userObject.php');
					$userObject = new UserManager();
					
					$userVariables = $userObject->getUserVariables();
					if(!$userObject->isUserExist($userVariables['user_name'])){
						
						$userPassword=$userVariables['user_password'];
						$userVariables['user_password']="";
						$user_id=$userObject->insertManager($userVariables);
						$userObject->setPassword($userPassword,$user_id);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = 'Queue Manager Added Successfully!';
						$page="view_queue_managers.php";
						
					}else{
						
						$data['allGroups']=$groupObject->getAllGroups();
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = 'Duplicate User with the same Username found!!';
					}
					$data['allQManagers'] = $userObject->getAllQManagersForCustomer();
				
			break;
			
			case "edit_user":				

				$userId = $_REQUEST['edit_id'];
				$userDetails=$userObject->getUserDetails($userId);
				$data['userDetails'] = $userDetails;
				$page="edit_manager.php";
			break;
			
			case "edit_user_entry":
				//echo "<pre>"; print_r($_REQUEST);
					$userVariables = $userObject->getUserVariables();
					$userVariables['user_id']=$_REQUEST['user_id'];
					
					if(!$userObject->isUserExist($userVariables['user_name'],$userVariables['user_id'])){
						$userPassword=$userVariables['user_password'];
					
						unset($userVariables['user_password']);
						$previousPass=$userObject->getUserPassword($userVariables['user_id']);
						$userObject->updateManagerUsingId($userVariables);
						$sha1_currentpass=sha1($userPassword);
						if(!($sha1_currentpass==$previousPass)  && !($sha1_currentpass==sha1('********'))){
							$userObject->setPassword($userPassword,$userVariables['user_id']);
						}
						
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = 'Queue Manager details Updated Successfully!';
						$page="view_queue_managers.php";
					}else{
						$userPassword=$userVariables['user_password'];
					
						unset($userVariables['user_password']);
						$previousPass=$userObject->getUserPassword($userVariables['user_id']);
						$userObject->updateManagerUsingId($userVariables);
						$sha1_currentpass=sha1($userPassword);
						if(!($sha1_currentpass==$previousPass)  && !($sha1_currentpass==sha1('********'))){
							$userObject->setPassword($userPassword,$userVariables['user_id']);
						}
						
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = 'Queue Manager details Successfully!';
						$page="view_queue_managers.php";
					}
					$data['allQManagers'] = $userObject->getAllQManagersForCustomer();
			
			break;
			
			case "delete_user":
			
					$user_id=$_REQUEST['edit_id'];
					$userDetails = $userObject->getUserDetails($user_id);
					if($userDetails['user_group'] == '3')
					{
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = 'User is a Customer Admin! Customer Admins connot be delted!';
					}
					else
					{
						$userObject->deleteManagerUsingId($user_id);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = 'User Deleted Successfully!';
					}
					$data['allQManagers'] = $userObject->getAllQManagersForCustomer();
					$page="view_queue_managers.php";
			
			break;
			
			case "view_history";
				
				require_once('library/storeCustomerManager.php');
				$scManager = new StoreCustomerManager();
				require_once('library/queueManager.php');
				$queueObject= new QueueManager();
				
				$queueManagerId = $_REQUEST['edit_id'];
				$data['queueHistory'] = $queueObject->getQueueHistoryForManager($queueManagerId);
				for($i=0;$i<sizeof($data['queueHistory']);$i++ )
				{
					$data['queueHistory'][$i]['store_customer_id'];
					$data['queueHistory'][$i]['storeCustomerDetails'] = $scManager->getCustomerDetails($data['queueHistory'][$i]['store_customer_id']);
				}	
				$page = "view_history.php";
				$data['new_page'] = "view_queue_managers.php";		
				$data['function'] = "show_manager_history_filtered";
				$data['edit_id'] = $queueManagerId;
			break;
			
			case "show_manager_history_filtered":
				require_once('library/storeCustomerManager.php');
				$scManager = new StoreCustomerManager();
				require_once('library/queueManager.php');
				$queueObject= new QueueManager();
				
				$startDate = strtotime($_REQUEST['start_date']);
				$endDate = strtotime($_REQUEST['end_date']);
				$endDate = strtotime('+1 day', $endDate);
				$queueManagerId = $_REQUEST['edit_id'];
				
				$data['queueHistory'] = $queueObject->getQueueHistoryForManager($queueManagerId,$startDate,$endDate);
				for($i=0;$i<sizeof($data['queueHistory']);$i++ )
				{
					$data['queueHistory'][$i]['store_customer_id'];
					$data['queueHistory'][$i]['storeCustomerDetails'] = $scManager->getCustomerDetails($data['queueHistory'][$i]['store_customer_id']);
				}	
				$data['new_page'] = "view_queue_managers.php";	
				$data['function'] = "show_manager_history_filtered";
				$page = "view_history.php";
				$data['edit_id'] = $queueManagerId;
			break;
		}

?>
