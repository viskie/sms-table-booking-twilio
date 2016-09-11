<?

if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class CreditManager extends commonObject
{
	
	function deductCreditforQueueEntry($phone_number)
	{
		$customerId = getOne("select customer_id from phone_numbers where phone_number = '".trim($phone_number)."'");
		$this->deductCredit($customerId);
	}
	
	function deductCredit($customerId)
	{
		
	}

}

?>
