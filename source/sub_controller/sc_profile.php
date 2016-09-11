<?php
require_once('library/userObject.php');
$userObject= new UserManager();
require_once('library/groupObject.php');
$groupObject= new GroupManager();
$data['userDetails'] = $userObject->getUserDetails($_SESSION['user_id']);
	switch($function){
			case "show_data":

			break;
		
			case "save":
				//echo "<pre>"; print_r($_REQUEST); exit;
					$userVariables = $userObject->getUserVariables();
					$userVariables['user_id']=$_SESSION['user_id'];
					
					
						$userPassword=$userVariables['user_password'];
					
						unset($userVariables['user_password']);
						$previousPass=$userObject->getUserPassword($userVariables['user_id']);
						$userObject->updateUsingId($userVariables);
						$sha1_currentpass=sha1($userPassword);
						if(!($sha1_currentpass==$previousPass)  && !($sha1_currentpass==sha1('********'))){
							$userObject->setPassword($userPassword,$userVariables['user_id']);
						}
						$data['allUsers']=$userObject->getAllUsers();

						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = 'Profile Updated Successfully!';
						
					$data['allGroups']=$groupObject->getAllGroups();
			
			break;
			
			
		}

?>
