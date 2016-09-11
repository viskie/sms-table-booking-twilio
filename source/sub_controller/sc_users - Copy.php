<?php
	switch($function){
			case "show_data":
			break;
			
			case "show_add_user":
				$has_access = has_access($current_page_id,"add");
				if($has_access == true){	
					$page = "add_new_user.php";
				}else
				{
					$no_access = true;	
				}	
			break;
			
			case "add_user":
				$has_access = has_access($current_page_id,"add");
				if($has_access == true){
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
						//print_r($selectedGroupArray);exit;
						$groupObject->setGroupPermissionsForUser($user_id,$selectedGroupArray);
						
	/*					$selectedBranchArray=array();
						if(isset($_REQUEST['branches'])){
							$selectedBranchArray=$_REQUEST['branches'];
						}
						$userObject->setBranchPermissionsForUser($user_id,$selectedBranchArray);
	*/					
						$notification = "User Added Successfully!";
					}else{
						$_SESSION['userExist']=true;
						$page="add_new_user.php";
					}
				}else
				{
					$no_access = true;	
				}	
			break;
			
			case "edit_user":
			case "copy_user":
				$_SESSION['edit_user']="true";
				$_SESSION['user_id_for_edit']=$_REQUEST['user_id'];
				
				if($function=="copy_user"){
					$is_copy=true;
				}
				$page="add_new_user.php";
			break;
			
			case "edit_user_entry":
				$has_access = has_access($current_page_id,"edit");
				if($has_access == true){
					require_once('library/userObject.php');
					$userObject = new UserManager();
					$userVariables = $userObject->getUserVariables();
					$userVariables['user_id']=$_REQUEST['user_id'];
					if(!$userObject->isUserExist($userVariables['user_name'],$userVariables['user_id'])){
						$userPassword=$userVariables['user_password'];
						//$userVariables['user_password']="";
						unset($userVariables['user_password']);
						$previousPass=$userObject->getUserPassword($userVariables['user_id']);
						$userObject->updateUsingId($userVariables);
						$sha1_currentpass=sha1($userPassword);
						if(!($sha1_currentpass==$previousPass)  && !($sha1_currentpass==sha1('********'))){
							$userObject->setPassword($userPassword,$userVariables['user_id']);
						}
	/*					$selectedBranchArray=array();
						if(isset($_REQUEST['branches'])){
							$selectedBranchArray=$_REQUEST['branches'];
						}
						$userObject->setBranchPermissionsForUser($userVariables['user_id'],$selectedBranchArray);*/
						
						$selectedGroupArray=array();
						if(isset($_REQUEST['groups'])){
							$selectedGroupArray=$_REQUEST['groups'];
						}
						array_push($selectedGroupArray ,$_REQUEST['user_group']);
						//print_r($selectedGroupArray);exit;
						$groupObject->setGroupPermissionsForUser($userVariables['user_id'],$selectedGroupArray);
						$notification = "User Updated Successfully!";
					}else{
						$_SESSION['userExist']=true;
						$page="add_new_user.php";
					}
				}else
				{
					$no_access = true;	
				}	
			break;
			
			case "delete_user":
				$has_access = has_access($current_page_id,"delete");
				if($has_access == true){
					require_once('library/userObject.php');
					$userObject = new UserManager();
					$user_id=$_REQUEST['user_id'];
					$userObject->deleteUsingId($user_id);
					$notification = "User Deleted Successfully!";
				}else
				{
					$no_access = true;	
				}	
			break;
		}

?>