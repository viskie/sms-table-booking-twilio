<?
class commonObject
{	
	public function getInsertDataString($dataArray, $tableName)
	{
		$subQryArr = array();
		foreach($dataArray as $key => $value)
		{
			$subQryArr[] = $key." = '".addslashes($value)."'";
		}
		$subQry = implode(", ",$subQryArr);
		$insertQry = "insert into ".$tableName." set ".$subQry;
		return $insertQry;	
	}
	
	//Vishak Nair - 09-08-2012
	//To generate string for update query form array.
	//Note: $dataArray must contain the id. $idFieldName is the name of the field which contains the id.
	function getUpdateDataString($dataArray,$tableName,$idFieldName){
		$subQryArr = array();
		foreach($dataArray as $key => $value)
		{
			if(!($key==$idFieldName))
				$subQryArr[] = $key." = '".addslashes($value)."'";
		}
		$subQry = implode(", ",$subQryArr);
		$updateQry = "Update ".$tableName." set ".$subQry." where ".$idFieldName."='".$dataArray[$idFieldName]."'";
		return $updateQry;
	}
	
	function getUserIdUsingName($user_name){
		return $resultSet = getOne("select user_id from users where is_active =1 AND user_name='".$user_name."'");
	}
	
	//To get name of perticular user using user_id
	function getUserNameUsingId($user_id){
		return $resultSet = getOne("select name from users where is_active =1 AND user_id='".$user_id."'");
	}
	function getCurrentCustomerCredits()
	{
		return getRow("select * from customer_bx where customer_id = '".$_SESSION['customer_id']."'");
	}
	
	
}
?>
