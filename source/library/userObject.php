<?
//Vishak Nair - 25/08/2012
//for user management
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class UserManager extends commonObject
{
	//to get all the users.
	/*function getAllUsers()
	{
		$userGroup = array();
		$userGroup = $_SESSION['user_group'];
		//print_r($userGroup);exit;
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
		//var_dump($user_groups);exit;
		return $resultSet = getData("SELECT * FROM `users` WHERE is_active =1 AND `user_id` in (SELECT `user_id` FROM `user_group_permissions` WHERE `group_id` IN (".$user_groups.") AND is_active=1) group by users.user_id");
	}*/
	
	function getAllUsers(){
		return $resultSet = getData("SELECT * FROM `users` WHERE is_active =1");
	}
	
	function getAllQManagersForCustomer()
	{
		return getData("SELECT * FROM `users` WHERE is_active =1 and (user_group = '4' or user_group = '3')  and customer_id = '".$_SESSION['customer_id']."'");
	}
	
	//To get all the details of perticular user using user_id
	function getUserDetails($user_id)
	{
		return getRow("select * from  users where is_active =1 AND user_id='".$user_id."'");
	}
	
	//To get all the details of perticular user using user_id
	function getUserPassword($user_id)
	{
		return getOne("select `user_password` from  users where is_active =1 AND user_id='".$user_id."'");
	}

	

	//To get name of perticular user using user_id
	

	function getAllPermissionedGroupsOfGroup($user_id){
		$resultSet=getData("SELECT `group_id` FROM `user_group_permissions` WHERE `user_id`=".$user_id);
		//echo ("SELECT `group_id` FROM `user_group_permissions` WHERE `user_id`=".$user_id);exit;
		$permissionedGroups=array();
		for($i=0;$i<count($resultSet);$i++){
			$permissionedGroups[]=$resultSet[$i]['group_id'];
		}
		return $permissionedGroups;	
	}
		
	//To restrict duplicate in users.
	function isUserExist($user_name,$user_id=0){
		$query="select * from users where user_name='".$user_name."'";
		if($user_id!=0){
			$query.=" AND user_id!=".$user_id;
		}
		$resultSet = getData($query);
		if(sizeof($resultSet)>0){
			return true;
		}else{
			return false;
		}
	}
	
	//To update a row in users table using user_id. 
	function updateUsingId($dataArray){
		$updateQry=$this->getUpdateDataString($dataArray,"users","user_id");
		updateData($updateQry);
	}
	
	//To update a row in users table using user_id. 
	function updateManagerUsingId($dataArray){
	    $updateQry=$this->getUpdateDataString($dataArray,"users","user_id");
		$updateQry.= " and customer_id='".$_SESSION['customer_id']."'";
		updateData($updateQry);
	}
	
	function setPassword($newPassword,$user_id){
		updateData("UPDATE `users` SET `user_password`=sha1('".$newPassword."') WHERE is_active =1 AND `user_id`=".$user_id);
	}
	
	function setLanguage($newLanguage,$user_id){
		updateData("UPDATE `users` SET `preferred_language`='".$newLanguage."' WHERE is_active =1 AND `user_id`=".$user_id);
	}
	
	//To delete a row in users table using user_id. 
	function deleteUsingId($user_id){
		updateData("UPDATE `users` SET `is_active`=false WHERE `user_id`='".$user_id."'");
	}
	
	function deleteManagerUsingId($user_id)
	{
		updateData("UPDATE `users` SET `is_active`=false WHERE `user_id`='".$user_id."' and user_group = '4' and customer_id='".$_SESSION['customer_id']."'");
	}
		
	function insertUser($varArray)
	{
		$insertQry = $this->getInsertDataString($varArray, 'users');
		updateData($insertQry);
		return mysql_insert_id();
	}
	
	function insertManager($varArray)
	{
		$insertQry = $this->getInsertDataString($varArray, 'users');
		$insertQry.= ", customer_id = '".$_SESSION['customer_id']."'";
		updateData($insertQry);
		return mysql_insert_id();
	}
	
	function getUserVariables()
	{
		$varArray['user_group'] = "";
		if($_SESSION['user_main_group'] == '3')
		{
			$varArray['user_group'] = '4';
		}
		else if($_SESSION['user_main_group'] == '4')
		{
			$varArray['user_group'] = '4';
		}
		else
		{
			$varArray['user_group'] = $_REQUEST['user_group'];
		}
		
		if(isset($_REQUEST['user_name']))
		{
			$varArray['user_name'] = $_REQUEST['user_name'];
		}
		$varArray['user_password'] = $_REQUEST['user_password'];
		$varArray['name'] = $_REQUEST['name'];
    	$varArray['user_email'] = $_REQUEST['user_email'];
		$varArray['user_phone'] = $_REQUEST['user_phone'];
	
		return $varArray;
	}
	
	function updateCustomerId($user_id,$customerId)
	{
		
		updateData("update users set customer_id ='".$customerId."' where user_id ='".$user_id."'");
	}
	
	//Vishak Nair - 04/09/2012
	//To get the branch permission for user.
/*	function getAllPermissionedBranchesOfUser($user_id){
		$resultSet=getData("SELECT `branch_id` FROM `user_permissions_on_company` WHERE `user_id`=".$user_id);
		$permissionedBranches=array();
		for($i=0;$i<count($resultSet);$i++){
			$permissionedBranches[]=$resultSet[$i]['branch_id'];
		}
		return $permissionedBranches;
	}*/
	
	
	//Vishak Nair - 04/09/2012
	//To set the branch permission for user.
/*	function setBranchPermissionsForUser($user_id,$branchArray){
		$first=true;
		updateData("DELETE FROM `user_permissions_on_company` WHERE `user_id`='".$user_id."'");
		updateData("DELETE FROM `user_permissions_on_original_company` WHERE `user_id`='".$user_id."'");
		if(count($branchArray)>0){
			$companyArray=getData("Select Distinct(`company_id`) from company_details where branch_id in (".implode(',',$branchArray).")");
			$query="INSERT INTO `user_permissions_on_original_company`(`user_id`, `company_id`) VALUES ";
			foreach($companyArray as $company){
				if(!$first){
					$query.=", ";
				}else{
					$first=false;
				}
				$query.="('".$user_id."','".$company['company_id']."')";				
			}
			updateData($query);
			
			$first=TRUE;
			$query="INSERT INTO `user_permissions_on_company`(`user_id`, `branch_id`) VALUES ";
			foreach($branchArray as $branchToAdd){
				if(!$first){
					$query.=", ";
				}else{
					$first=false;
				}
				$query.="('".$user_id."','".$branchToAdd."')";
			}
			updateData($query);
		}
		updateData("OPTIMIZE TABLE `user_permissions_on_original_company`");//To delete the data files related to the deleted records.
		updateData("OPTIMIZE TABLE `user_permissions_on_company`");//To delete the data files related to the deleted records.
	}*/
	
} 
?>
