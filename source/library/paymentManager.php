<? error_reporting(-1);

if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class PaymentManager extends commonObject
{
		function getAllPayments()
		{
			return getData("select * from payments order by payment_id desc");
		}	
}

?>
