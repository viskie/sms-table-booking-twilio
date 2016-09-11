<?php
require_once('library/groupObject.php');
$groupObject = new GroupManager();
require_once('library/pageObject.php');
$pageObject= new PageManager();

	switch($function){
			case "show_data":
				$data['allGroups']=$groupObject->getAllGroups();
			break;
			
			case "show_add_group":
				$has_access = has_access($current_page_id,"add");
				if($has_access == true){
					$data['allPages']=$pageObject->getAllPages(true);		
					$page = "add_new_group.php";
				}else
				{
					$no_access = true;	
				}	
			break;
			
			case "add_group":
				$has_access = has_access($current_page_id,"add");
				if($has_access == true){
					
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
						$groupObject->setCRUDPermissionForGroup($_REQUEST['crud'],$group_id,$selectedPageArray);
						
						$notification = "Group Added Successfully!";
					}else{
						$groupDetails=$groupObject->getGroupVariables();
						$groupDetails['selectedPages']=array();
						if(isset($_REQUEST['pages'])){
							$groupDetails['selectedPages']=$_REQUEST['pages'];
						}
						
						$groupDetails['selectedGroups']=array();
						if(isset($_REQUEST['groups'])){
							$groupDetails['selectedGroups']=$_REQUEST['pages'];
						}
						$is_exist=true;
						$page="add_new_group.php";
					}
					$data['allGroups']=$groupObject->getAllGroups();
				}else
				{
					$no_access = true;	
				}	
			break;
			
			case "edit_group":
			case "copy_group":
				$_SESSION['group_id']=$_REQUEST['group_id'];
				
				if($function=="edit_group"){
					$is_edit=true;
				}
				
				$groupId=$_SESSION['group_id'];
				$groupDetails=$groupObject->getGroupDetails($groupId);
				$groupDetails['selectedPages']=$groupObject->getAllPermissionedPagesOfGroup($groupId);
				$groupDetails['selectedGroups']=$groupObject->getAllPermissionedGroupsOfGroup($groupId);
				$groupDetails['selected_add'] = $groupObject->getAllPermissionedPagesToAdd($groupId);
				$groupDetails['selected_edit'] = $groupObject->getAllPermissionedPagesToEdit($groupId);
				$groupDetails['selected_delete'] = $groupObject->getAllPermissionedPagesToDelete($groupId);
					
				
				$data['allPages']=$pageObject->getAllPages(true);
				$data['groupDetails'] = $groupDetails;
				unset($_SESSION['group_id']);
				$page="add_new_group.php";
			break;
			
			case "edit_group_entry":
				$has_access = has_access($current_page_id,"edit");
				if($has_access == true){
					$groupVariables = $groupObject->getGroupVariables();
					$groupVariables['group_id']=$_REQUEST['group_id'];
					if(!$groupObject->isGroupExist($groupVariables['group_name'],$groupVariables['landing_page'],$groupVariables['group_id'])){
						$groupObject->updateUsingId($groupVariables);
						$selectedPageArray=array();
						if(isset($_REQUEST['pages'])){
							$selectedPageArray=$_REQUEST['pages'];
							//$data['selectedPageArray'] = $selectedPageArray;
						}
						$groupObject->setPagePermissionsForGroup($groupVariables['group_id'],$selectedPageArray);
						
						$selectedGroupArray=array();
						if(isset($_REQUEST['groups'])){
							$selectedGroupArray=$_REQUEST['groups'];
							//$data['selectedGroupArray'] = $selectedGroupArray;
						}
						$groupObject->setGroupPermissionsForGroup($groupVariables['group_id'],$selectedGroupArray);
						
						if(isset($_REQUEST['crud'])){
							$groupObject->setC