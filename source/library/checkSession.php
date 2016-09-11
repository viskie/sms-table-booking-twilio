<?  
if($_SESSION['user_login']!=true)
{	
	header("location: index.php");
	exit;
}

require_once('Config.php');

$fileNameFull =  explode("/",$_SERVER["SCRIPT_NAME"]);
$splitSize = sizeof($fileNameFull);
$fileName = $fileNameFull[($splitSize - 1)];
checkPagePermissions($fileName);


function checkPagePermissions($fileName)
{
	$fileName = addslashes($fileName);
	//$userGroup = (int)$_SESSION['user_group'];
	$userGroup = $_SESSION['user_main_group'];
	//print_r($userGroup);
	$first = true;
	
	
	//$user_groups.=")";
	
	//echo "Select page_id from pages where page_name = '".$fileName."' <br />"; 
	$pageId = getOne("Select page_id from pages where page_name = '".$fileName."'");
	//echo "Select * from user_permissions where group_id = '".$userGroup."' and page_id = '".$pageId."' and is_active = '1'"; 
	$pagePermission= getData("Select * from user_permissions where group_id = '".$userGroup."' and page_id = '".$pageId."' and is_active = '1'");
	//echo $user_groups; exit;
	if((int)$userGroup != 1)
	{
		
		if(sizeof($pagePermission)>=1)
		{
			//Page-User Validated
		}
		else
		{	//echo $fileName;exit;
			//exit;
			 echo "
					<script type='text/javascript'>
						alert(\"You do not have permission to view this page.".$pageId." Please Contact administrator\");
						window.location = 'index.php';
					</script>
			 ";
			exit;
		}
	}
}
?>
