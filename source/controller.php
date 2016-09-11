<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	Header("location: index.php");
}

require_once("library/groupObject.php");
$groupObject=new GroupManager();
$data = array();
$page = "";
$notification = "";	
$notificationArray = array();

purifyInputs();

if(isset($_POST['page']))
{
	$page = addslashes($_POST['page']);	
}
else{
	$page = getOne("select page_name from pages where page_id = (select landing_page from user_groups where group_id = '".$_SESSION['user_main_group']."')");
	$function="show_data";
}
//echo $_SESSION['user_id'];exit;
checkPagePermissions($page);

$can_add = false;
$can_edit = false;
$can_delete = false;
$function = "";
if(isset($_REQUEST['function']))
{
	$function = $_REQUEST['function'];
}
	$is_copy=false;// used later in code
	$is_edit=false;
	$is_exist=false;
	$no_access = false;
	//variables for CRUD permission
	
	$current_page_id=getOne("Select `page_id` from pages where page_name='".$page."'");
	
//	echo $page."||".$function;
	
	//echo "<pre>"; print_r($_SESSION); exit;
	
	if($_SESSION['user_main_group'] == '3')
	{
		if(checkFirstTimeCustomer())
		{
			$page = "buy_phone_number.php";
			$notificationArray['type'] = 'Message';
			$notificationArray['message'] = 'Select atlest one Phone Number to start using the application.';
		}
	}
	
	
	logActivity($page,$function);
	switch($page)
	{		
		//**********************************************************************************************************************************
		//**********************************************************************************************************************************
		case "manage_customers.php":
			include('sub_controller/sc_customers.php');
			break;
		//**********************************************************************************************************************************
		case "manage_groups.php":
			include('sub_controller/sc_groups.php');
			break;
		//**********************************************************************************************************************************
		case "manage_users.php":
			include('sub_controller/sc_users.php');	
			break;
		
		//**********************************************************************************************************************************
		case "home.php":
			include('sub_controller/sc_home.php');	
			break;
		
		//**********************************************************************************************************************************
		case "settings.php":
			include('sub_controller/sc_settings.php');	
			break;
			
		//**********************************************************************************************************************************
		case "view_queue_managers.php":
			include('sub_controller/sc_queue_manager.php');	
			break;
			
		//**********************************************************************************************************************************
		case "view_queue.php":
			include('sub_controller/sc_queue.php');	
			break;
			
		//**********************************************************************************************************************************
		case "view_phone_numbers.php":
			include('sub_controller/sc_phone_numbers.php');	
			break;
			
		//**********************************************************************************************************************************
		case "buy_phone_number.php":
			include('sub_controller/sc_phone_numbers.php');	
			break;
			
		//**********************************************************************************************************************************
		case "view_store_customers.php":
			include('sub_controller/sc_store_customers.php');	
			break;
			
		//**********************************************************************************************************************************
		case "view_history.php":
			include('sub_controller/sc_queue.php');	
			break;
			
		//**********************************************************************************************************************************
		case "view_customer_profile.php":
			include('sub_controller/sc_qprofile.php');	
			break;
			
		//**********************************************************************************************************************************
		case "view_unsuscribers.php":
			include('sub_controller/sc_store_customers.php');	
			break;
			
		//**********************************************************************************************************************************
		case "view_activity_logs.php":
			include('sub_controller/sc_activity_logs.php');	
			break;
			
		//**********************************************************************************************************************************
		case "broadcast.php":
			include('sub_controller/sc_broadcast.php');	
			break;
			
		//**********************************************************************************************************************************
		case "user_profile.php":
			include('sub_controller/sc_profile.php');	
			break;
			
		//**********************************************************************************************************************************
		case "manage_plans.php":
			include('sub_controller/sc_plans.php');	
			break;
			
		//**********************************************************************************************************************************
		case "view_payments.php":
			include('sub_controller/sc_payments.php');	
			break;


	}
	
	if($notification != "" )
	{
		echo "<div style='text-align:center' >".populateNotification($notification)."</div>";
	}
	if(!is_file('views/'.$page)){
		include('uc.php');
	}
	else{
		extract($data);
		include_once('views/'.$page);
	}

?>