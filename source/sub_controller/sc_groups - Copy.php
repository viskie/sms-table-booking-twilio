<?php
	switch($function){
			case "show_data":
			break;
			
			case "show_add_group":
				$has_access = has_access($current_page_id,"add");
				if($has_access == true){	
					$page = "add_new_group.php";
				}else
				{
					$no_access = true;	
				}	
			break;
			
			case "add_group":
				$has_access = has_access($current_page_id,"add");
				if($has_access == true){
					require_once('library/groupObject.php');
					$groupObject = new GroupManager();
					$groupVariables = $groupObject->getGroupVariables();
					//print_r($_REQUEST);exit;
					if(!$groupObject->isGroupExist($groupVariables['group_name'],$groupVariables['landing_page'])){
						
						$group_id=$groupObject->insertGroup($groupVariables);
						
						$selectedPageArray=array();
						if(isset($_REQUEST['pages'])){
							$selectedPageArray=$_REQUEST['pages'];
						}
						$groupObject->setPagePermissionsForGroup($group_id,$selectedPageArray);
						
						$selectedGroupArray=array();
						if(isset($_REQUEST['groups'])){
							$selectedGroupArray=$_REQUEST['groups'];
						}
						$selectedGroupArray[]=$group_id;
						if(!in_array($_SESSION['user_group'],$selectedGroupArray)){
							$selectedGroupArray[]=$_SESSION['user_group'];
						}
						$groupObject->setGroupPermissionsForGroup($group_id,$selectedGroupArray);
						
						/*
						*	Code to insert crud permission into database
						*/
						$groupObject->setCRUDPermissionForGroup($_REQUEST['crud'],$group_id);
						
						$notification = "Group Added Successfully!";
					}else{
						$_SESSION['groupExist']=true;
						$page="add_new_group.php";
					}
				}else
				{
					$no_access = true;	
				}	
			break;
			
			case "edit_group":
			case "copy_group":
				$_SESSION['edit_group']="true";
				$_SESSION['group_id']=$_REQUEST['group_id'];
				
				if($function=="copy_group"){
					$is_copy=true;
				}
				$page="add_new_group.php";
			break;
			
			case "edit_group_entry":
				$has_access = has_access($current_page_id,"edit");
				if($has_access == true){
					require_once('library/groupObject.php');
					$groupObject = new GroupManager();
					$groupVariables = $groupObject->getGroupVariables();
					$groupVariables['group_id']=$_REQUEST['group_id'];
					if(!$groupObject->isGroupExist($groupVariables['group_name'],$groupVariables['landing_page'],$groupVariables['group_id'])){
						$groupObject->updateUsingId($groupVariables);
						$selectedPageArray=array();
						if(isset($_REQUEST['pages'])){
							$selectedPageArray=$_REQUEST['pages'];
						}
						$groupObject->setPagePermissionsForGroup($groupVariables['group_id'],$selectedPageArray);
						$selectedGroupArray=array();
						if(isset($_REQUEST['groups'])){
							$selectedGroupArray=$_REQUEST['groups'];
						}
						$groupObject->setGroupPermissionsForGroup($groupVariables['group_id'],$selectedGroupArray);
						if(isset($_REQUEST['crud'])){
							$groupObject->setCRUDPermissionForGroup($_REQUEST['crud'],$groupVariables['group_id']);
						}	
						$notification = "Group Updated Successfully!";
					}else{
						$_SESSION['groupExist']=true;
						$page="add_new_group.php";
					}
				}else
				{
					$no_access = true;		
				}	
			break;
			
			case "delete_group":
				$has_access = has_access($current_page_id,"delete");
				if($has_access == true){
					require_once('library/groupObject.php');
					$groupObject = new GroupManager();
					$group_id=$_REQUEST['group_id'];
					$groupObject->deleteUsingId($group_id);
					$notification = "Group Deleted Successfully!";
				}else
				{
					$no_access = true;		
				}
			break;
		}
?>