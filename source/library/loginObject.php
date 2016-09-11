<?if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	Header("location: index.php");
}
require_once('library/Config.php');
//require_once('library/LDAP/LDAP.php');

function checkLogin($user,$pass) 
{
	$user = addslashes($user);
	$pass = addslashes($pass);
	$query="SELECT * FROM users WHERE user_name='".$user."' AND user_password = sha1('".$pass."')";
	$result= getData($query);
	$userCount = (int) sizeof($result);
	if($userCount > 0) return true;
	else return false;
}

function setUserDetails($user)
{
	$user = addslashes($user);
	$query="SELECT * FROM users WHERE user_name='".$user."'"; 	
	$userDetails = getData($query);
	if(sizeof($userDetails)>0)
	{
		 $_SESSION['user_id'] = $userDetails[0]['user_id'];
		 $_SESSION['user_name'] = $userDetails[0]['user_name'];
		 $_SESSION['user_main_group'] = $userDetails[0]['user_group'];
		 $_SESSION['name'] = $userDetails[0]['name'];
		 $_SESSION['user_login'] = true;
         
         if($userDetails[0]['user_group'] == '3')
         {
         	$_SESSION['customer_id'] = getOne("select customer_id from customers where customer_admin_user_id = '".$userDetails[0]['user_id']."'");
         }
         else if($userDetails[0]['user_group'] == '4')
         {
        	$_SESSION['customer_id'] = getOne("select customer_id from users where user_id = '".$userDetails[0]['user_id']."'");
         }
         
	}
	
	
}
?>
