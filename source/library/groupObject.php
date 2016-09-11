<?
//Vishak Nair - 23/08/2012
//for group management
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class GroupManager extends commonObject
{
	//to get all the groups.
	/*function getAllGroups()
	{
		$userGroup = array();
		$userGroup = $_SESSION['user_group'];
		//print_r($userGroup);
		$first = true;
		$user_groups = "";
		foreach($userGroup as $key=>$value)
		{
			if(!$first)
				$user_groups.= ", ";
			else
				$first = false;		
			$user_groups.= $value;	
		}
		
		return $resultSet = getData("select * from  user_groups where is_active =1 AND group_id in (SELECT `permissioned_group_id` as `user_group` FROM `user_permissions_on_group` WHERE `group_id`IN (".$user_groups."))");
	}*/
	
	function getAllGroups(){
		return $resultSet = getData("select * from  user_groups where is_active =1");
	}
	
	//To get all the details of perticular user group using group_id
	function getGroupDetails($group_id)
	{
		return $resultSet = getRow("select * from  user_groups where is_active =1 AND group_id='".$group_id."'");
	}

	//To get name of perticular group using group_id
	function getGroupNameUsingId($group_id){
		return $resultSet = getOne("select group_name from user_groups where is_active =1 AND group_id='".$group_id."'");
	}
	
	function getCrudPermissionsForCurrentPage($group_id,$current_page_id){
			$result_set = getData("SELECT `add`,`edit`,`delete` FROM `user_crud_permissions` WHERE `is_active` =1 AND `group_id`=".$group_id." AND `page_id`=".$current_page_id."");
			return $result_set;
	}
	
	
	//get all details wether perticuler group has permission to add a page (todo)
	function getAllPermissionedPagesToAdd($groupId){
		
			$result_set = getData("SELECT `page_id` FROM `user_crud_permissions` WHERE `add` =1 AND `is_active` =1 AND `group_id`=".$groupId);
			$add_permission = array();
			for($i=0;$i<count($result_set);$i++){
				$add_permission[] = $result_set[$i]['page_id'];
			}
			//print_r($add_permission);exit;
			return $add_permission;
	}
	
	//get all details wether perticuler group has permission to edit a page (todo)
	function getAllPermissionedPagesToEdit($groupId){
		
			$result_set = getData("SELECT `page_id` FROM `user_crud_permissions` WHERE `edit` =1 AND `is_active` =1 AND `group_id`=".$groupId);
			$edit_permission = array();
			for($i=0;$i<count($result_set);$i++){
				$edit_permission[] = $result_set[$i]['page_id'];
			}
			//print_r($add_permission);exit;
			return $edit_permission;
	}
	
	//get all details wether perticuler group has permission to delete a page (todo)
	function getAllPermissionedPagesToDelete($groupId){
		
			$result_set = getData("SELECT `page_id` FROM `user_crud_permissions` WHERE `delete` =1 AND `is_active` =1 AND `group_id`=".$groupId);
			$delete_permission = array();
			for($i=0;$i<count($result_set);$i++){
				$delete_permission[] = $result_set[$i]['page_id'];
			}
			//print_r($add_permission);exit;
			return $delete_permission;
	}
	//To restrict duplicate in groups.
	function isGroupExist($group_name,$landing_page,$group_id=0){
		$query="select * from user_groups where group_name='".$group_name."' AND landing_page='".$landing_page."'";
		if($group_id!=0){
			$query="select * from user_groups where group_name='".$group_name."' AND landing_page='".$landing_page."' AND group_id!='".$group_id."'";
		}
		$resultSet = getData($query);
		if(sizeof($resultSet)>0){
			return true;
		}else{
			return false;
		}
	}
	
	//To update a row in user_group table using group_id. 
	function updateUsingId($dataArray){
		$updateQry=$this->getUpdateDataString($dataArray,"user_groups","group_id");
		updateData($updateQry);
	}
	
	//To get the page permission for group.
	function getAllPermissionedPagesOfGroup($group_id){
		$resultSet=getData("SELECT `page_id` FROM `user_permissions` WHERE is_active =1 AND `group_id`=".$group_id);
		$permissionedPages=array();
		for($i=0;$i<count($resultSet);$i++){
			$permissionedPages[]=$resultSet[$i]['page_id'];
		}
		return $permissionedPages;
	}
	
	//To set the page permission for group.
	function setPagePermissionsForGroup($group_id,$pageArray){
		$first=true;
		updateData("DELETE FROM `user_permissions` WHERE  page_id!=1 AND `group_id`=".$group_id);
		if(count($pageArray)>0){
			$query="INSERT INTO `user_permissions`(`group_id`, `page_id`) VALUES ";
			foreach($pageArray as $pageToAdd){
				if(!$first){
					$query.=", ";
				}else{
					$first=false;
				}
				$query.="('".$group_id."','".$pageToAdd."')";
			}
			updateData($query);
		}
		updateData("OPTIMIZE TABLE `user_permissions`");//To delete the data files related to the deleted records.
	}
	
	function setOnePagePermissionsForGroup($varArray){
		$insertQry = $this->getInsertDataString($varArray, 'user_permissions');
		updateData($insertQry);
		return mysql_insert_id();
	}
	
	//To get the group permission for group.
	function getAllPermissionedGroupsOfGroup($group_id){
		$resultSet=getData("SELECT `permissioned_group_id` FROM `user_permissions_on_group` WHERE is_active =1 AND `group_id`=".$group_id);
		$permissionedGroups=array();
		for($i=0;$i<count($resultSet);$i++){
			$permissionedGroups[]=$resultSet[$i]['permissioned_group_id'];
		}
		return $permissionedGroups;
	}
	
	//To make the HTML list of checkboxes for permission of group.
	function makeGroupPermissionList($permissionedGroups=array()){
		$permissionedGroupsStr="<ul class=\"groupsCheckboxes\">";
		$allGroups=$this->getAllGroups();
		for($i=0;$i<count($allGroups);$i++){
			$permissionedGroupsStr.="<li><input type=\"checkbox\" name=\"groups[]\" value=\"".$allGroups[$i]['group_id']."\"";
			if(in_array($allGroups[$i]['group_id'],$permissionedGroups)){
				$permissionedGroupsStr.="checked=\"checked\"";
			}
			$permissionedGroupsStr.=">".$allGroups[$i]['group_name']."</li>";
		}
		return $permissionedGroupsStr."</ul>";
	}
	
	//To set the group permission for group.
	function setGroupPermissionsForGroup($group_id,$groupArray){
		$first=true;
		updateData("DELETE FROM `user_permissions_on_group` WHERE `group_id`=".$group_id);
		if(count($groupArray)>0){
			$query="INSERT INTO `user_permissions_on_group`(`group_id`, `permissioned_group_id`) VALUES ";
			foreach($groupArray as $groupToAdd){
				if(!$first){
					$query.=", ";
				}else{
					$first=false;
				}
				$query.="('".$group_id."','".$groupToAdd."')";
			}
			updateData($query);
		}
		updateData("OPTIMIZE TABLE `user_permissions_on_group`");//To delete the data files related to the deleted records.
	}
	
	//To set user belonging to multiple groups (todo)
	function setGroupPermissionsForUser($user_id,$groupArray=array())
	{
		//echo("DELETE FROM `user_group_permissions` WHERE `user_id`=".$user_id);
		updateData("DELETE FROM `user_group_permissions` WHERE `user_id`=".$user_id);
		$first = true;
		//var_dump($groupArray);
		if(count($groupArray)>0)
		{
			$query = "INSERT INTO user_group_permissions (`user_id`,`group_id`) VALUES";
			foreach($groupArray as $groupToSet){
				if(!$first)
					$query.=", ";
				else
					$first = false;
				
				$query.="('".$user_id."','".$groupToSet."')";	
			}
			updateData($query);
		}
	}
	
	function deleteCRUDPermissionForGroup($group_id){
		updateData("DELETE FROM `user_crud_permissions` WHERE `group_id`='".$group_id."'");
		updateData("OPTIMIZE TABLE `user_crud_permissions`");
	}
	
	//function to set add/edit/delete perminsions of page to group (todo)
	function setCRUDPermissionForGroup($crud_permission = array(),$group_id,$pages_array=array())
	{
		updateData("DELETE FROM `user_crud_permissions` WHERE `group_id`=".$group_id);
		//echo "done delete";exit;
		
		if(count($pages_array)!==0){
			$page_permission_array = array();
			//print_r($crud_permission);print_r($pages_array);
			foreach($crud_permission as $crud_value)
			{
				$pageId_permission = explode("_",$crud_value);
				$page_id = $pageId_permission[0];
				$permission = $pageId_permission[1];
				
				if(in_array($page_id,$pages_array)){
					//echo "tru for page_id".$page_id."<br>";
					//print_r($pages_array);
					if(array_key_exists($page_id,$page_permission_array)){
						$page_permission_array[$page_id][$permission] = 1;
					}
					else{
						$page_permission_array[$page_id][0] = 0;
						$page_permission_array[$page_id][1] = 0;
						$page_permission_array[$page_id][2] = 0;	
						$page_permission_array[$page_id][$permission] = 1;
					}
				}else{
					//echo "else executed";exit;
				}
			}
			//print_r($page_permission_array);
			foreach($page_permission_array as $key=>$value)
			{
				
				$page_id = $key;
				$first = true;
				$permission = "";
				foreach($value as $key=>$value)
				{
					if(!$first)
						$permission.= ", ";
					else
						$first = false;		
					$permission.= $value;	
				}
						
				$query = "INSERT INTO `user_crud_permissions` (`group_id`,`page_id`,`add`,`edit`,`delete`) VALUES (".$group_id.",".$page_id.",".$permission.")";
				//echo $query;
				updateData($query);
			}
		}
		updateData("OPTIMIZE TABLE `user_crud_permissions`");
	}
	
	//To delete a row in user_group table using group_id. 
	function deleteUsingId($group_id){
		updateData("UPDATE `user_groups` SET `is_active`=false WHERE `group_id`='".$group_id."'");
		updateData("UPDATE `user_permissions_on_group` SET `is_active`=false WHERE `group_id`='".$group_id."'");
		$user_groups =  implode(",", $_SESSION['user_group']);
		updateData("UPDATE `user_group_permissions` SET `is_active`=false WHERE `group_id`='".$group_id."'");
		updateData("UPDATE `user_crud_permissions` SET `is_active`=false WHERE `group_id`='".$group_id."'");
	}
		
	function insertGroup($varArray)
	{
		//echo $_SESSION['user_main_group']; exit;
		$insertQry = $this->getInsertDataString($varArray, 'user_groups');
		updateData($insertQry);
		$insertedGroupId=mysql_insert_id();
		updateData("INSERT INTO `user_permissions_on_group`(`group_id`, `permissioned_group_id`) VALUES ('".$_SESSION['user_main_group']."','".$insertedGroupId."')");
		return $insertedGroupId;
	}
	
	function getGroupVariables()
	{
		$varArray['group_name'] = $_REQUEST['group_name'];
		$varArray['comments'] = $_REQUEST['comments'];
		$varArray['landing_page'] = $_REQUEST['landing_page'];
		return $varArray;
	}

}
?>