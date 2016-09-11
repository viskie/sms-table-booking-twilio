<?
//Vishak Nair - 25/08/2012
//for user management
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class PhoneManager extends commonObject
{
		function getAllNumbersForCustomer()
		{
			return getData("SELECT * FROM `phone_numbers` where customer_id = '".$_SESSION['customer_id']."' ");
		}
		
}

?>
