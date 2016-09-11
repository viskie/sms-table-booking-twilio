<?php
require_once('customvbx.class.php');
$twilioExt = new TwilioExt();

$appSid = $twilioExt->createNewAccount("Test");

$twilioExt->getAllAcounts();


?>