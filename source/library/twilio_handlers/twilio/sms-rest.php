<?php
	error_reporting(E_ALL);
	//@ini_set('display_errors', 0);
	
	// include the PHP TwilioRest library
	require "Twilio.php";

	// set our AccountSid and AuthToken
	$AccountSid = "ACc2f0232d0b30e83aa6775eb2cb7211f4";
	$AuthToken = "c9e9a4ded5c3e5783b2d9c17257fdc48";

	// instantiate a new Twilio Rest Client
	$client = new Services_Twilio($AccountSid, $AuthToken);

	// make an associative array of people we know, indexed by phone number
	$people = array(
		"+14192905053"=>"Curious George"
	);
	
	// iterate over all our friends
	//foreach ($people as $number => $name) {

		// Send a new outgoinging SMS by POSTing to the SMS resource 
		$sms = $client->account->sms_messages->create(
			"+15672020707",
			"+14192905053",
			"Test Message"
		);

		echo "Sent message to test"; 
   // }
?>
