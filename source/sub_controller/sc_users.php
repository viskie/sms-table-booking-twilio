<?php
require_once('library/userObject.php');
$userObject= new UserManager();
require_once('library/groupObject.php');
$groupObject= new GroupManager();

	switch($function){
			case "show_data":
				$data['allUsers'] = $userObject->getAllUsers();
				$data['allGroups']=$groupObject->getAllGroups();
			break;
			
			case "show_add_user":
				$has_access = has_access($current_page_id,"add");
				if($has_access == true){	
					$data['allGroups']=$groupObject->getAllGroups();
					$allLanguages=getAllLanguages();
					$defaultLanguage=1;
					foreach($allLanguages as $language){
						if($language['is_default']=='1'){
							$data['defaultLanguage']=$language['id'];
							break;
						}
					}
					$data['allLanguages'] = $allLanguages;
					$page = "add_new_user.php";
				}else
				{
					$no_access = true;	
				}	
			break;
			
			case "add_user":
					require_once('library/userObject.php');
					$userObject = new UserManager();
					require_once('library/groupObject.php');
					$groupObject = new GroupManager();
					
					$userVariables = $userObject->getUserVariables();
					if(!$userObject->isUserExist($userVariables['user_name'])){
						
						$userPassword=$userVariables['user_password'];
						$userVariables['user_password']="";
						$user_id=$userObject->insertUser($userVariables);
						$userObject->setPassword($userPassword,$user_id);
						
						$selectedGroupArray=array();
						if(isset($_REQUEST['groups'])){
							$selectedGroupArray=$_REQUEST['groups'];
						}
						array_push($selectedGroupArray ,$_REQUEST['user_group']);

						$groupObject->setGroupPermissionsForUser($user_id,$selectedGroupArray);
						$data['allGroups']=$groupObject->getAllGroups();
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = 'User Added Successfully!';
						$page="manage_users.php";
						
					}else{
						
						$data['allGroups']=$groupObject->getAllGroups();
						$notificationArray['type'] = 'Failed';
						$notificationArray['message'] = 'Duplicate User with the same Username found!!';
					}
					$data['allUsers'] = $userObject->getAllUsers();
				
			break;
			
			case "edit_user":
			case "copy_user":
				$data['allGroups'] = $groupObject->getAllGroups();
			
				//echo "<pre>"; print_r($_REQUEST);
				
				$userId = $_REQUEST['edit_id'];
				$userDetails=$userObject->getUserDetails($userId);
					//$userDetails['selectedGroups']=$userObject->getAllPermissionedGroupsOfGroup($userId);
				$data['userDetails'] = $userDetails;
					//		$userDetails['selectedBranches']=$userObject->getAllPermissionedBranchesOfUser($userId);

				$page="edit_user.php";
			break;
			
			case "edit_user_entry":
				//echo "<pre>"; print_r($_REQUEST);
					$userVariables = $userObject->getUserVariables();
					$userVariables['user_id']=$_REQUEST['user_id'];
					
					if(!$userObject->isUserExist($userVariables['user_name'],$userVariables['user_id'])){
						$userPassword=$userVariables['user_password'];
					
						unset($userVariables['user_password']);
						$previousPass=$userObject->getUserPassword($userVariables['user_id']);
						$userObject->updateUsingId($userVariables);
						$sha1_currentpass=sha1($userPassword);
						if(!($sha1_currentpass==$previousPass)  && !($sha1_currentpass==sha1('********'))){
							$userObject->setPassword($userPassword,$userVariables['user_id']);
						}
						$data['allUsers']=$userObject->getAllUsers();

						$selectedGroupArray=array();
						if(isset($_REQUEST['groups'])){
							$selectedGroupArray=$_REQUEST['groups'];
						}
						array_push($selectedGroupArray ,$_REQUEST['user_group']);
			
						$groupObject->setGroupPermissionsForUser($userVariables['user_id'],$selectedGroupArray);
						
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = 'User Updated Successfully!';
						$page="manage_users.php";
					}else{
						$userDetails = $userObject->getUserVariables();
						$userDetails['user_id'] = $userVariables['user_id'];
						$selectedGroupArray=array();
						if(isset($_REQUEST['groups'])){
							$selectedGroupArray=$_REQUEST['groups'];
						}
						array_push($selectedGroupArray ,$_REQUEST['user_group']);
						$userDetails['selectedGroups'] = $selectedGroupArray;
						
						$groupObject->setGroupPermissionsForUser($userVariables['user_id'],$selectedGroupArray);
						$data['userDetails']=$userDetails;
						
						$is_exist=true;
						$is_edit=true;
						$page="add_new_user.php";
					}
					$data['allGroups']=$groupObject->getAllGroups();
			
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
						$userObject->deleteUsingId($user_id);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = 'User Deleted Successfully!';
					}
					
					$data['allUsers'] = $userObject->getAllUsers();
					$data['allGroups'] = $groupObject->getAllGroups();
						
						$page="manage_users.php";
			
			break;
		}

?>
