<?
session_start();
$page = $_REQUEST['page'];
$function = $_REQUEST['function'];

switch($page)
{
	case "view_queue.php";
		include_once('sub_controller/sc_queue.php');
	break;	

}



?>