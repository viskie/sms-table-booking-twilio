<? if((isset($_POST['wl-username'])) && (trim($_POST['wl-password']) != ""))
{	require_once('library/loginObject.php');
	$inpUsername = $_POST['wl-username'];
	$inpPassword = $_POST['wl-password'];	
	
	if(checkLogin($inpUsername,$inpPassword))
	{
		session_start();
		setUserDetails($inpUsername);
		header("Location: home.php");
		exit;
	}
	else
	{
		$notification = "Username & Password Incorrect";
	}
}
?>
