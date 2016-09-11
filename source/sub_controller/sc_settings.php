<?php
	switch($function)
		{
			case "show_data":
			$data['allSettings'] = getData("select * from settings");
			break;
			
			case "updateSettings":
				$twilio_sid = $_REQUEST['twilio_sid'];
				$twilio_auth_token = $_REQUEST['twilio_auth_token'];
				$twilio_app_sid = $_REQUEST['twilio_app_sid'];
				//$notification = updateSettings($twilio_sid,$twilio_auth_token,$twilio_app_sid);
				$page= "settings.php";
			    $notificationArray['type'] = 'Success';
			   $notificationArray['message'] = 'Settings Updated Successfully!';
			   	$data['allSettings'] = getData("select * from settings");
			break;
		}
?>
