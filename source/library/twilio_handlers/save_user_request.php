<?
if(isset($_REQUEST['To']))
{
	require_once("../creditManager.php");
	require_once("../queueManager.php");
	require_once("../customerObject.php");
	require_once("customvbx.class.php");

	$creditObject = new CreditManager();
	$queueObject = new QueueManager();
	
	$smsObject['SmsSid'] = $_REQUEST['SmsSid'];
	$smsObject['Body'] = $_REQUEST['Body'];
	$smsObject['To'] = $_REQUEST['To'];
	$smsObject['From'] = $_REQUEST['From'];
	//echo "Test"; exit;
	
	$creditObject->deductCreditforQueueEntry($To);
	$queueObject->addEntryfromSMS($smsObject);
}
?>