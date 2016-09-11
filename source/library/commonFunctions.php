<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	Header("location: index.php");
}

function getAllLanguages(){
	return getData("SELECT * FROM `language_master`");
}

function checkFirstTimeCustomer()
{
	$phCount = (int)getOne("select count(*) from phone_numbers where customer_id = '".$_SESSION['customer_id']."'");
	if($phCount>0)
	{	return false;}
	else
	{	return true;}	
}

function has_access($current_page_id,$which_access){
	$user_groups = implode(",",$_SESSION['user_group']);
	$result_set = getData("select * from `user_crud_permissions` where `page_id`='".$current_page_id."' and `group_id` IN (".$user_groups.") and `".$which_access."`='1'");
	//print_r($result_set);exit;
	if(count($result_set) >0)
		return true;
	else
		return false;	
}

function buildLanguageBox(){
	$selectStr="<select name='language' onchange='javascript:changeLanguage();' style=\"font-size:10px;height15px;padding:0;\">";
	$allLanguages=getAllLanguages();
	foreach($allLanguages as $language){
		$selected="";
		if($language['id']==$_SESSION['preferred_language']){
			$selected=" selected='selected'";
		}
		$selectStr.="<option".$selected." value='".$language['id']."'>".$language['language_name']."</option>";
	}
	$selectStr.="</select>";
	echo $selectStr;
}

function getSelectedPageLables($module_id,$language_id){
	$query = "SELECT `value` FROM `language_details` WHERE `module_id`='".$module_id."' AND `language_id`='".$language_id."'";
	$query=trim($query); 
	$result = mysql_query($query) or Handle_Mysql_Error($query,mysql_error(),mysql_errno());
	$resArr = array();
	while($res = mysql_fetch_array($result)) 
	{
		$resArr[] = $res['value'];
	}
	return $resArr;	
}

function getSelectedPageId($module_id,$language_id){
	$query = "SELECT `position_id` FROM `language_details` WHERE `module_id`='".$module_id."' AND `language_id`='".$language_id."'";
	$query=trim($query); 
	$result = mysql_query($query) or Handle_Mysql_Error($query,mysql_error(),mysql_errno());
	$resArr = array();
	while($res = mysql_fetch_array($result)) 
	{
		$resArr[] = $res['position_id'];
	}
	return $resArr;		
}

function getAllSidebarLabels($language_id){
	$resArr = getData("SELECT `position_id`,`value` FROM `language_details` WHERE `module_id`=1 AND `language_id`='".$language_id."' AND `position_id`>900");
	return $resArr;
}

function getPageTitle($module_id,$language_id,$position_id,$title_type=1){
	return getOne("SELECT `value` FROM `language_details` WHERE `module_id`='".$module_id."' AND `language_id`='".$language_id."' AND `position_id`='".$position_id."' AND `title_type`='".$title_type."'");
//	echo ("SELECT `value` FROM `language_details` WHERE `module_id`='".$module_id."' AND `language_id`='".$language_id."' AND `position_id`='".$position_id."'");
}

function getUserGroupPermissions()
{	
			$userMainGroup = (int)$_SESSION['user_main_group'];
			$pageArray = array();
			$retArray = array();
			
			if($userMainGroup != 1)
			{
				$first = true;

				$pageArray = getData("select * from pages where page_id in (select page_id from user_permissions where group_id = '".$userMainGroup."' and is_active = 1) and is_active = 1 and level = 1 order by `tab_order` ASC");
			}
			else
			{
					$pageArray = getData("select * from pages where is_active = 1 and level = 1 order by `tab_order` ASC");
			}
			
			foreach($pageArray as $value)
			{
					$retArray[$value['description']] = $value;
			}
			
			
			return $retArray;
}


function buildUserMenu()
{
	$userGroup = $_SESSION['user_group'];
	$pageArray = getData("select * from pages where page_id in (select page_id from user_permissions where group_id = '".$userGroup."' and is_active = 1) and is_active = 1 and level = 1");
	
	?>
    <script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
    <link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
    <ul id="MenuBar1" class="MenuBarHorizontal">
      <?
	  	for($i=0; $i<sizeof($pageArray);$i++)
		{
			?>
            <li><a class="MenuBarItemSubmenu" href="javascript:callPage('<?=$pageArray[$i]['page_name']?>','show_data')"><?=$pageArray[$i]['title']?></a>
            <?
				$subPageArray = getdata("select * from pages where page_id in (select page_id from user_permissions where group_id = '".$userGroup."' and is_active = 1) and is_active = 1 and level = 2 and parent_page_id = '".$pageArray[$i]['page_id']."'");
				if(sizeof($subPageArray)>0)
				{
					echo "<ul>";
					for($j=0;$j<sizeof($subPageArray);$j++)
					{
					?>
                    	<li><a href="javascript:callPage('<?=$subPageArray[$j]['page_name']?>')"><?=$subPageArray[$j]['title']?></a></li>                   
                    <?
					}
					echo "</ul>";
				}				
			?>
         	</li>            
            <?
		}
	  ?>      
    </ul>
    <script type="text/javascript">
    var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
    </script>   
    <?	
}
/*
function buildUserMenuMain($pageName="")
{
	$userGroup = (int)$_SESSION['user_group'];
	$userName = getOne("select name from users where user_id = '".$_SESSION['user_id']."'");
	$pageArray = array();
	if($userGroup != 1)
	{
		$pageArray = getData("select * from pages where page_id in (select page_id from user_permissions where group_id = '".$userGroup."' and is_active = 1) and is_active = 1 and level = 1 order by page_id");
	}
	else
	{
		$pageArray = getData("select * from pages where is_active = 1 and level = 1 order by page_id");
	}
	?>
    <div id="topmenu">
		<ul>
     <?
	 	$selected_page_id=0;
		$currentPage = addslashes($pageName);
		$currentPageId = getOne("select page_id from pages where page_name = '".$currentPage."'");
		
	  	for($i=0; $i<sizeof($pageArray);$i++)
		{
			$css_class = '';
			if($currentPageId == $pageArray[$i]['page_id'])
			{
				$css_class = " class='current'";
				$selected_page_id=$currentPageId;
			}
			
			?>
			<li<?=$css_class?>><a href="javascript:callPage('<?=$pageArray[$i]['page_name']?>')"><?=$pageArray[$i]['title']?></a></li>            
            <?
        }
		
	?>
        <li><a href="javascript:userLogout('')" class="last"><span>Logout</span></a></li>
        </ul>
	</div>
    </div>
	<?
		if($userGroup != 1)
		{
			$subPageArray = getdata("select * from pages where page_id in (select page_id from user_permissions where group_id = '".$userGroup."' and is_active = 1) and is_active = 1 and level = 2 and parent_page_id = '".$selected_page_id."'");
		}
		else
		{
			$subPageArray = getdata("select * from pages where is_active = 1 and level = 2 and parent_page_id = '".$selected_page_id."'");
		}
		?>
			<div id="top-panel">
				 <div id="panel">
		<?
		if(sizeof($subPageArray)>0)
		{
			?>
					<ul>
					<?
						for($i=0;$i<sizeof($subPageArray);$i++)
						{
							//var_dump($subPageArray[$i]);exit;
						?>
							<li><a href="javascript:callPage('<?=$subPageArray[$i]['page_name']?>')"><?=$subPageArray[$i]['title']?></a>             
						<?
						}
					?>
					</ul>
			<?
		}
		?>
				</div>
			</div>
		<?
}*/

function buildUserMenuMain()
{
	$userGroup = array();
	$userGroup = $_SESSION['user_group'];
	$first = true;
	$user_groups = "";
	foreach($userGroup as $key=>$value)
	{
		if(!$first)
			$user_groups.= ", ";
		else
			$first = false;		
		$user_groups.= $value;	
	}
	
	//$userGroup = $_SESSION['user_group'];
	$userName = getOne("select name from users where user_id = '".$_SESSION['user_id']."'");
	$pageArray = getData("select * from pages where page_id in (select page_id from user_permissions where group_id IN(".$user_groups.") and is_active = 1) and is_active = 1 and level = 1 order by `tab_order` ASC");
	//print_r($pageArray); exit;
	?>
    <div id="topmenu">
    <ul>
     <?
	  	for($i=0; $i<sizeof($pageArray);$i++)
		{
			if($pageArray[$i]['page_name'] == '#'){ ?>
				<li><a href="#" class="parent"><span><?=getPageTitle('1',$_SESSION['preferred_language'],$pageArray[$i]['page_id'])?></span></a>
			<? }else{
			?>
			<li><a href="javascript:callPage('<?=$pageArray[$i]['page_name']?>','show_data')" class="parent"><span><?=getPageTitle('1',$_SESSION['preferred_language'],$pageArray[$i]['page_id'])?></span></a>
			<? }
				$subPageArray = getdata("select * from pages where page_id in (select page_id from user_permissions where group_id IN(".$user_groups.") and is_active = 1) and is_active = 1 and level = 2 and parent_page_id = '".$pageArray[$i]['page_id']."' order by `tab_order` ASC");
				if(sizeof($subPageArray)>0)
				{
					echo "<ul class=\"mysubmenu\">";
					for($j=0; $j<sizeof($subPageArray); $j++)
					{
					?>
								 <? $sub_sub_PageArray = getdata("select * from pages where page_id in (select page_id from user_permissions where group_id IN(".$user_groups.") and is_active = 1) and is_active = 1 and level = 3 and parent_page_id = '".$subPageArray[$j]['page_id']."' order by `tab_order` ASC");
								
                           if(sizeof($sub_sub_PageArray)>0)
							{
								echo "<li class='sidemenu_parent'><a href=\"javascript:callPage('".$subPageArray[$j]['page_name']."','show_data')\"><span>".getPageTitle('1',$_SESSION['preferred_language'],$subPageArray[$j]['page_id'])."</span></a>";
								echo "<div class=\"sidemenu_container\">";	
								echo "<ul class=\"sidemenu\">";
								for($k=0; $k<sizeof($sub_sub_PageArray); $k++)
								{
								?>
									
									<li><a href="javascript:callPage('<?=$subPageArray[$j]['page_name']?>','show_data')"><span><?=getPageTitle('1',$_SESSION['preferred_language'],$sub_sub_PageArray[$k]['page_id'])?></span></a></li>
										
								<?
								}
								echo "</ul>"; 
								echo "</div></li>";
							}else{?>
                    	<li><a href="javascript:callPage('<?=$subPageArray[$j]['page_name']?>','show_data')"><span><?=getPageTitle('1',$_SESSION['preferred_language'],$subPageArray[$j]['page_id'])?></span></a></li>
                    <? }
					}
					echo "</ul>";
				}				
			?>
         	</li>            
            <?
        }
	?>
    <li><a href="javascript:userLogout('')" class="last"><span class="sb_label_01_995"></span></a>
    </ul>
</div>
    <?
}



function purifyInputs()
{
	foreach($_REQUEST as $key=>$value)
	{
		if(is_array($value)){	//Change: Msnthan Tripathi:25-Aug-2012. The function is giving error when passed array of checkboxes in query string.
			foreach($value as $keySub => $valueSub){
				if(is_array($valueSub)){
					foreach($valueSub as $key_sub_sub => $val_sub_sub){
						$value[$key_sub_sub] = addslashes($val_sub_sub);	
					}
				}
				else{
					$value[$keySub] = addslashes($valueSub);
				}
			}
		}else{
			$_REQUEST[$key] = addslashes($value);
		}
	}
}

function getAllUserGroups()
{
	$getQuery = "Select * from user_groups order by group_id";
	$userGroups = getData($getQuery);
	return $userGroups;
}

function getAllGlobalAdmins()
{
	$getQuery = "Select * from users where user_group = 1 order by user_id";
	$userGroups = getData($getQuery);
	return $userGroups;
}

function addNewGroup($group_name,$group_comments,$landing_page)
{
	$insQuery = "insert into user_groups set
					group_name = '".$group_name."',
					is_active = '1',
					comments = '".$group_comments."',
					landing_page = '".$landing_page."'					
				";
	updateData($insQuery);
	return "Group Added Successfully!!";
	
}

function addUser($user_name,$password,$full_name,$userGroup,$email,$user_phone_number)
{
	$CheckUserExists = getOne("select user_name from users where user_name = '".$user_name."'");
	
	if(trim($CheckUserExists) != "")
	{
		return "Duplicate User Found. Please use a different User Name.";
	}
	
	$spclCharArr = array(' ', '-', '(', ')' , '/'); 
	
	$user_phone_number = str_replace($spclCharArr,'',$user_phone_number);	
	
	$insQuery = "insert into users set
					user_group = '".$userGroup."',
					user_name = '".$user_name."',
					is_active = '1',
					user_password = sha1('".$password."'),
					name = '".$full_name."',
					user_email = '".$email."',
					user_phone = '".$user_phone_number."'								
				";
	updateData($insQuery);
	return "User Added Successfully!!";
	
}

function editUser($user_id, $user_name,$password,$full_name,$userGroup,$email,$user_phone_number)
{
	$CheckUserExists = getOne("select user_name from users where user_name = '".$user_name."' and user_id != '".$user_id."'");
	
	if(trim($CheckUserExists) != "")
	{
		return "Duplicate User Found. Please use a different User Name.";
	}
	
	$updateQuery = "update users set
						user_group = '".$userGroup."',
						user_name = '".$user_name."',
						is_active = '1',
						user_password = sha1('".$password."'),
						name = '".$full_name."',
						user_email = '".$email."',
						user_phone = '".$user_phone_number."'
					where
						user_id = '".$user_id."' and
						user_group = '".$userGroup."'			
				";
	updateData($updateQuery);
	return "User Updated Successfully!!";
}

function  deleteUser($user_id, $userGroup)
{
	if($user_id == '1')
	{
		return "System Super-User cannot be deleted!!";
	}
	else
	{
		$delQry = "delete from users where user_id = '".$user_id."' and user_group = '".$userGroup."'";
		updateData($delQry);
		return "User Deleted Successfully!!";
	}
}

function getUserName($user_id)
{
	$userName = getOne("select name from users where user_id = '".$user_id."'");
	return $userName;
}


function getAdminUsersCombo($boxName)
{
	$adminUsers = getAllAdmins();
	createComboBox($boxName,'user_id','name',$adminUsers);
}

function getGroupCombo($boxName,$selectedGroup='')
{	
	$userGroupArray = getData("select * from user_groups where is_active=1");
	createComboBox($boxName,'group_id','group_name', $userGroupArray,false,$selectedGroup);
}

function createComboBox($name,$value,$display, $data, $blankField=false, $selectedValue="",$display2="",$firstFieldValue='Please Select', $otherParameters = "")
{
	echo "<select id='".$name."' name = '".$name."' ".$otherParameters." >";
	if($blankField){
		echo "<option value='0'>".$firstFieldValue."</option>";
	}
	for($d=0;$d<sizeof($data);$d++)
	{
		$selectedString = "";
		$selectedValue = trim($selectedValue);
		if($data[$d][$value] == $selectedValue)
		{
			$selectedString = " selected = 'selected' ";
		}
		
		echo "<option value='".$data[$d][$value]."' ".$selectedString.">".$data[$d][$display];
		if($display2!=""){
			echo " (".$data[$d][$display2].")";
		}
		echo "</option>";
	}
	echo "</select>";
}
function getActiveEmployee($ph_id)
{
	$activeUser = getOne("select user_id from schedule where ph_id = '".$ph_id."' and is_active = '1'");
	return $activeUser;
}

function getAssignedBy($ph_id)
{
	$assignedBy = getOne("select assigned_by from schedule where ph_id = '".$ph_id."' and is_active = '1'");
	return $assignedBy;
}


function getTwlioCreds()
{
	$twilioArr = array();
	$twilioArr['sid'] = getConfigValue('twilio_sid');
	$twilioArr['auth_token'] = getConfigValue('twilio_auth_token');
	$twilioArr['app_sid'] = getConfigValue('twilio_app_sid');
	return $twilioArr;
}


function getConfigValue($key)
{
	return $value = getOne("Select config_value from settings where config_name = '".$key."'");
}

function updateConfigValue($key,$value)
{
	updateData("update settings set config_value = '".$value."' where config_name = '".$key."'");
}

function updateSettings($sid, $authToken,$twilio_app_sid)
{
	updateConfigValue('twilio_sid',$sid);
	updateConfigValue('twilio_auth_token',$authToken);
	updateConfigValue('twilio_app_sid',$twilio_app_sid);
	return "Settings Updated Successfully!!";
}

function buyNumber($newNumber)
{
	require_once('customvbx.class.php');
	$vbxClient = new TwilioExt();
	$status = $vbxClient->buyNumber($newNumber);
	if($status == "Success")
	{	$absNumber = substr($newNumber, -10); 
		addPhoneNumber($newNumber,"");
		return "Success";
	}
	else
	{
		return $status;
	}
	
}

function mailUser($transcript, $phoneNumber, $CallSid)
{	//echo "select user_id from schedule where ph_id = (select ph_id from phone_numbers where phone_number like '%".trim($phoneNumber)."') and is_active=1";
	 $inCallEmployeeId = getOne("select user_id from schedule where ph_id = (select ph_id from phone_numbers where phone_number like '%".trim($phoneNumber)."') and is_active=1");
	$inCallEmployeeMail = getOne("select user_email from users where user_id = '".$inCallEmployeeId."'");
	$voiceURL = getOne("select recording_url from incomming_calls where call_sid = '".$CallSid."'");
	
	
	if(trim($inCallEmployeeMail) != "")
	{
		$message = "
			<h3> New Call for you..!!</h3>
			<br />
			You have a new message.<br />
			Transcription: ".$transcript."<br />
			Voice Url: ".$voiceURL."<br /><br />
			Log in to VBX scheduler for more details.<br />
			Thanks.		
		";
		mailEmployee($inCallEmployeeMail, $message);
	}
}

function mailEmployee($to, $message) 
{		
				$headers = "From: VBX Scheduler <admin@poc.lifechurch.tv>\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$subject = 'New Call for you';
				
				if(mail($to,$subject, $message,$headers))
					//{}
					echo $testyry=  "Mail sent .........";
				else
					echo $testyry=  "Mail not sent........";
		
}

function getAllPhoneNumbers()
{
	$getQuery = "Select * from phone_numbers order by ph_id";
	$userGroups = getData($getQuery);
	return $userGroups;
}


function editPhoneNumber($phone_id,$phone_number,$text_message)
{
	$CheckNumberExists = getOne("select phone_number from phone_numbers where phone_number = '".$phone_number."' and ph_id != '".$phone_id."'");
	
	if(trim($CheckNumberExists) != "")
	{
		return "Phone Number already exists in the System!";
	}
	
	$updateQuery = "update phone_numbers set
						phone_number = '".$phone_number."',
						text_message = '".$text_message."',
						is_active = '1'
					where
						ph_id = '".$phone_id."'		
				";
	updateData($updateQuery);
	return "Phone Number settings updated Successfully!!";
}

function addPhoneNumber($phone_number,$text_message)
{
	
	$CheckNumberExists = getOne("select phone_number from phone_numbers where phone_number = '".$phone_number."'");
	
	if(trim($CheckNumberExists) != "")
	{
		return "Phone Number already exists in the System!";
	}
	
	$insQuery = "insert into phone_numbers set
					phone_number = '".$phone_number."',
					text_message = '".$text_message."',
					is_active = '1'				
				";
	updateData($insQuery);
	return "Phone Number Added Successfully!!";
	
}

function deletePhoneNumber($ph_id)
{
	$delQry = "Delete from phone_numbers where ph_id = '".$ph_id."'";
	updateData($delQry);
	return "Phone Number deleted Successfully!!";
}

function logActivity($page1,$function1)
{
	if($function1 != 'show_data')
	{
		$request_text = '';
		foreach($_REQUEST as $key=>$value)
		{
			if(is_array($value)){	//Change: Msnthan Tripathi:25-Aug-2012. The function is giving error when passed array of checkboxes in query string.
				foreach($value as $keySub => $valueSub){
					if(is_array($valueSub)){
						foreach($valueSub as $key_sub_sub => $val_sub_sub){
							$request_text.= $key_sub_sub."->".$val_sub_sub." || ";
						}
					}
					else{
						$request_text.= $keySub."->".$valueSub." || ";
					}
				}
			}else{
				$_REQUEST[$key] = addslashes($value);
				$request_text.= $key."->".$value." || ";
				
			}
		}
		
		$user_id = $_SESSION['user_id'];
		
		$customer_id="";
		if(isset($_SESSION['customer_id']))
		{
			$customer_id = $_SESSION['customer_id'];
		}
		
		updateData("insert into activity_log set 
						user_id='".$user_id."',
						customer_id='".$customer_id."',
						page='".$page1."',
						function='".$function1."',
						request_paramers='".$request_text."',
						time_stamp = '".time()."'
				  ");
	}
}
?>
