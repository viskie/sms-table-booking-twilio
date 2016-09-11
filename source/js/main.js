// JavaScript Document
function GetXmlHttpObject1()
{	var xmlHttp1=null;
	try
	{
	// Firefox, Opera 8.0+, Safari
	xmlHttp1=new XMLHttpRequest();
	}
	catch (e)
	{	//Internet Explorer
		try
		{
			xmlHttp1=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			xmlHttp1=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp1;
}

function toggle(source) {
	
  checkboxes = document.getElementsByName('sc_id[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
	var chk_id = checkboxes[i].id;
	var two = $('#'+chk_id).attr("checked", source.checked);
	$.uniform.update(two);
  }
}

function submitenter(myfield,e)
{
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	
	if (keycode == 13)
	   {
	   myfield.form.submit();
	   return false;
	   }
	else
	   return true;
}

function callPage(page,function_name)
{
	if(page != "")
	{
		document.getElementById('page').value = page;
		if(function_name==""){
			document.getElementById('function').value = "show_data";
		}else{
			document.getElementById('function').value = function_name;
		}
		
		document.getElementById('mainForm').submit();
	}
}

function addNewGroup()
{
	if($('#group_name').val() == "")
	{
		alert("Please Enter A Group Name");
	}
	else if($('#group_comments').val() == "")
	{
		alert("Please Enter Group Comments");
	}
	else if($('#landing_page').val() == "")
	{
		alert("Please Enter the Groups Landing Page");
	}
	else
	{
		$('#page').val('manage_groups.php');
		$('#function').val('addnewgroup');
		$('#mainForm').submit();
	}
}

function addUser(page, func)
{
	if($('#user_name').val() == "")
	{
		alert("Please Enter A User Name");
	}
	else if($('#user_password').val() == "")
	{
		alert("Please Enter Password");
	}
	else if($('#full_name').val() == "")
	{
		alert("Please Enter the User's Full Name");
	}
	else if($('#email').val() == "")
	{
		alert("Please Enter the Email Id");
	}
	else if($('#user_phone_number').val() == "")
	{
		alert("Please Enter the User's Phone Number");
	}
	else if(($('#user_password').val()) != ($('#cfm_password').val()))
	{
		alert("Passwords do not match!!");
	}
	else
	{
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
}

function addADUser(page, func)
{
	if($('#userName').val() == "")
	{
		alert("Please Enter A User Name");
	}
	else if($('#displayName').val() == "")
	{
		alert("Please Enter a Display Name");
	}
	else if($('#userMail').val() == "")
	{
		alert("Please Enter the Email Id");
	}
	else if($('#userPhone').val() == "")
	{
		alert("Please Enter the User's Phone Number");
	}
	else
	{
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
}

function clearUserFields(header)
{
	$('#popHeaderSpn').html(header);
	$('#user_name').val("");
	$('#full_name').val("");
	$('#user_id').val("");
	$('#email').val("");
	$('#user_phone_number').val("");
	document.getElementById('editUser').style.display = "none";
	document.getElementById('addUser').style.display = "";	
}

function clearPhoneFields(header)
{
	$('#popHeaderSpn').html(header);
	$('#phone_number').val("");
	document.getElementById('editNumber').style.display = "none";
	document.getElementById('addNumber').style.display = "";	
}

function setEditAssignedEmployee(id,ph_number,user)
{
	$('#phone_number').val(ph_number);
	$('#on_call_emp').val(user);
	$('#ph_id').val(id);
}

function setEditUser(id, uname, full_name, email, phone)
{
	$('#popHeaderSpn').html('Edit User Details');
	$('#user_name').val(uname);
	$('#full_name').val(full_name);
	$('#user_id').val(id);
	$('#email').val(email);
	$('#user_phone_number').val(phone);
	document.getElementById('addUser').style.display = "none";
	document.getElementById('editUser').style.display = "";
}

function setEditPhone(id,ph_number,text_message)
{	
	$('#popHeaderSpn').html('Edit Phone Settings');
	$('#phone_number').val(ph_number);
	$('#text_message').val(text_message);
	
	$('#ph_id').val(id);
	document.getElementById('addNumber').style.display = "none";
	document.getElementById('editNumber').style.display = "";
}

function changePhoneEmployee(page, func)
{
	if($('#phone_number').val() == "")
	{
		alert("Please Select A Phone Number.");
	}
	else if($('#on_call_emp').val() == "")
	{
		alert("Please select an On-Call-Employee.");
	}
	else if($('#ph_id').val() == "")
	{
		alert("Please Select a phone number to Edit.");
	}
	else
	{
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
}

function editNumber(page, func)
{
	if($('#phone_number').val() == "")
	{
		alert("Please Enter A Phone Number.");
	}
	else if($('#text_message').val() == "")
	{
		alert("Please Enter the Text Reply to be sent to the User.");
	}
	else if($('#ph_id').val() == "")
	{
		alert("Please Select a phone number to Edit.");
	}
	else
	{
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
}

function editUser(page, func)
{
	if($('#user_name').val() == "")
	{
		alert("Please Enter A User Name.");
	}
	else if($('#password').val() == "")
	{
		alert("Please Enter Password.");
	}
	else if($('#full_name').val() == "")
	{
		alert("Please Enter the User's Full Name.");
	}
	else if($('#email').val() == "")
	{
		alert("Please Enter the Email Id");
	}
	else if($('#user_phone_number').val() == "")
	{
		alert("Please Enter the User's Phone Number");
	}
	else
	{
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
}

function deleteUser(id,uname,page,func)
{
	if(confirm("Do you really want to delete the User: "+uname))
	{	$('#edit_id').val(id);
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
}

function deletePhone(id,phone,page)
{
	if(confirm("Do you really want to delete the Phone Number: "+phone))
	{	$('#ph_id').val(id);
		$('#page').val(page);
		$('#function').val('deletephone');
		$('#mainForm').submit();
	}
}

function addNumber(page, func)
{
	if($('#phone_number').val() == "")
	{
		alert("Please Enter A Phone Number.");
	}
	else if($('#phone_number').val().length < 10)
	{
		alert("Phone Number must be 10 digits in length.");
	}
	else if($('#admin_user').val() == "")
	{
		alert("Please Select an Admin user to Manage the number.");
	}
	else
	{
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
}

function viewHistory(id,page,func)
{
		$('#ph_history').val(id);
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
}

function userLogout()
{
	$('#page').val('home.php');
	$('#function').val('logout');
	$('#mainForm').submit();
}

function changeLanguage()
{
	$('#page').val('home.php');
	$('#function').val('language_change');
	$('#mainForm').submit();
}

function updateSettings(page, func)
{
	if(confirm("Confirm settings change! Incorrect Settings will cause the App to stop working!!"))
	{	
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
}

function searchTwiNum()
{
	var inp = $('#pattern').val();
	if(inp.length >= 3)
	{
		if(isNaN(inp))
		{
			alert("Please enter only Numbers");
			 $('#pattern').val('')
		}
		else
		{
			getData('buyNewPhone.php?stat=2&sample='+inp, 'ajaxResponse');
		}
	}
}

function searchForUser()
{
	var inp = $('#srchusername').val();
	if(inp.length > 1)
	{
			getData('searchForUser.php?stat=2&sample='+inp, 'ajaxResponse');
	}
	else
	{
		alert("Please enter a userName");
		 $('#pattern').val('')
	}
}


function buyNumber(num, page, func)
{
	if(confirm("Do you really want to buy number " +num+ "? Changes would be Ir-reversible!"))
	{
		$('#new_phone_number').val(num);
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
	
	return false;
}

function openEditUser(user_id,page,func)
{
	$('#edit_id').val(user_id);
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
}

function openEditCustomerDetails(id, page, func)
{
		$('#edit_id').val(id);
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();	
}

function openEditManager(user_id,page,func)
{
		$('#edit_id').val(user_id);
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
}

function setTranscription(value)
{
	$('#callTranscriptionDiv').html(value);
}

function phoneMgmtChng(page, func)
{
	var phone_num = $('#phone_number').val();
	var user =  $('#admin_user').val();
	
	var url = page + "?func="+func+"&phone_number="+phone_num+"&admin_user="+user;
	
	getData(url, 'phoneAdminsSpn');
	
}

function ajaxFileUpload()
	{
		$.ajaxFileUpload
		(
			{
				url:'doajaxfileupload.php',
				secureuri:false,
				fileElementId:'fileToUpload',
				dataType: 'json',
				data:{name:'logan', id:'id'},
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert(data.error);
						}else
						{
							alert(data.msg);
						}
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		
		return false;

	}
	
	function addCustomer(page,func)
	{
		if($('#customer_biz_name').val() == "")
		{
			alert("Please Enter the Business Name for the Customer.");
		}
		else if($('#customer_email').val() == "")
		{
			alert("Please Enter the Email for the Customer.");
		}
		else if($('#customer_phone').val() == "")
		{
			alert("Please Enter the Phone Number of the Customer.");
		}
		else if($('#user_name').val() == "")
		{
			alert("Please Enter A User Name for the Admin User.");
		}
		else if($('#user_password').val() == "")
		{
			alert("Please Enter Password for the Admin User.");
		}
		else if($('#name').val() == "")
		{
			alert("Please Enter the User's Full Name for the Admin User.");
		}
		else if($('#user_email').val() == "")
		{
			alert("Please Enter the Email for the Admin User.");
		}
		else if(($('#user_password').val()) != ($('#cfm_password').val()))
		{
			$('#spn_password').html("Passwords do not match")
		}
		else
		{
			$('#page').val(page);
			$('#function').val(func);
			$('#mainForm').submit();
		}
	}
	
	function openEditCustomer(id,page,func)
	{
		$('#edit_id').val(id);
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
	
	function updateCustomer(id,page,func)
	{
		if($('#customer_biz_name').val() == "")
		{
			alert("Please Enter the Business Name for the Customer.");
		}
		else if($('#customer_email').val() == "")
		{
			alert("Please Enter the Email for the Customer.");
		}
		else if($('#customer_phone').val() == "")
		{
			alert("Please Enter the Phone Number of the Customer.");
		}
		else if($('#user_name').val() == "")
		{
			alert("Please Enter A User Name for the Admin User.");
		}
		else if($('#name').val() == "")
		{
			alert("Please Enter the User's Full Name for the Admin User.");
		}
		else if($('#user_email').val() == "")
		{
			alert("Please Enter the Email for the Admin User.");
		}
		else
		{
			$('#edit_id').val(id);
			$('#page').val(page);
			$('#function').val(func);
			$('#mainForm').submit();
		}
	}
	
function addManager(page,func)
{

	if($('#user_name').val() == "")
	{
		alert("Please Enter A User Name");
	}
	else if($('#user_password').val() == "")
	{
		alert("Please Enter Password");
	}
	else if($('#full_name').val() == "")
	{
		alert("Please Enter the User's Full Name");
	}
	else if($('#email').val() == "")
	{
		alert("Please Enter the Email Id");
	}
	else if($('#user_phone_number').val() == "")
	{
		alert("Please Enter the User's Phone Number");
	}
	else if(($('#user_password').val()) != ($('#cfm_password').val()))
	{
		alert("Passwords do not match!!");
	}
	else
	{
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
}
	
function processQueue(id,page,func)
{
	var action = $('#'+id+'_action').val();
	
	if(action == 'ignore')
	{
		var ignoreCfm = confirm("Do you really want to ignore the Customer? If selected Yes the customer will be removed form the queue")
		if(!ignoreCfm)
		{
			return false;
		}
	}
	
	if(action == 'dispatch')
	{
		var category = $('#'+id+'_category').val();
		if(category == '0')
		{
			var ignoreCfm = confirm("You have not selected any list for the customer. Do you want to continue??")
			if(!ignoreCfm)
			{
				return false;
			}
		}
	}

	$('#edit_id').val(id);
	$('#page').val(page);
	$('#function').val(func);
	$('#mainForm').submit();
}

function updateProfile(page, func)
{
	if($('#user_name').val() == "")
	{
		alert("Please Enter A User Name");
	}
	else if($('#user_email').val() == "")
	{
		alert("Please Enter the Email Id");
	}
	else if($('#name').val() == "")
	{
		alert("Please Enter the User's Full Name");
	}
	else
	{
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
}

function viewQManagerHistory(id,page,func)
{
	$('#edit_id').val(id);
	$('#page').val(page);
	$('#function').val(func);
	$('#mainForm').submit();
	return false;
}

function buyPlan(id,type,page,func)
{
	$('#selected_plan').val(id);
	$('#selected_plan_type').val(type);
	$('#page').val(page);
	$('#function').val(func);
	$('#mainForm').submit();
	return false;
}

function deletePlan(id, name, page, func)
{
	if(confirm("Do you really want to delete this plan! All customers with plan will be effected"))
	{
		$('#edit_id').val(id);
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
	
	return false;
}

function broadcastMessage(page, func)
{
	if($('#broadcast_message').val() == "")
	{
			alert("Cannot Broadcast empy message, kindly enter a Message!");
	}
	else
	{
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
	return false;
}

function insertScCustomer(page, func)
{
	if($('#store_customer_name').val() == "")
	{
			alert("Store Customer name cannot be Blank!");
	}
	else if($('#phone_number').val() == "")
	{
			alert("Store Customer Phone cannot be Blank!");
	} 
	else
	{
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
	return false;
}

function updateProfile(page, func)
{
		if($('#customer_biz_name').val() == "")
		{
			alert("Please Enter the Business Name for the Customer.");
		}
		else if($('#customer_email').val() == "")
		{
			alert("Please Enter the Email for the Customer.");
		}
		else if($('#customer_phone').val() == "")
		{
			alert("Please Enter the Phone Number of the Customer.");
		}
		else
		{
			$('#page').val(page);
			$('#function').val(func);
			$('#mainForm').submit();
		}
		return false;
}

function updateProfile(page, func)
{
		if($('#customer_biz_name').val() == "")
		{
			alert("Please Enter the Business Name for the Customer.");
		}
		else if($('#customer_email').val() == "")
		{
			alert("Please Enter the Email for the Customer.");
		}
		else if($('#customer_phone').val() == "")
		{
			alert("Please Enter the Phone Number of the Customer.");
		}
		else
		{
			$('#page').val(page);
			$('#function').val(func);
			$('#mainForm').submit();
		}
		return false;
}


function updatePlans(id, page, func)
{
		if($('#plan_name').val() == "")
		{
			alert("Please Enter the Plan Name.");
		}
		else if($('#phone_numbers').val() == "")
		{
			alert("Please Enter the Maximum phone numbers for the Plan.");
		}
		else if($('#credits').val() == "")
		{
			alert("Please Enter the Credits Issued for the Plan.");
		}
		else if($('#cost').val() == "")
		{
			alert("Please Enter the Cost of the plan.");
		}
		else
		{
			$('#edit_id').val(id);
			$('#page').val(page);
			$('#function').val(func);
			$('#mainForm').submit();
		}
		return false;
}

function addPlan(page, func)
{
	if($('#plan_name').val() == "")
		{
			alert("Please Enter the Plan Name.");
		}
		else if($('#phone_numbers').val() == "")
		{
			alert("Please Enter the Maximum phone numbers for the Plan.");
		}
		else if($('#credits').val() == "")
		{
			alert("Please Enter the Credits Issued for the Plan.");
		}
		else if($('#cost').val() == "")
		{
			alert("Please Enter the Cost of the plan.");
		}
		else
		{
			$('#page').val(page);
			$('#function').val(func);
			$('#mainForm').submit();
		}
		return false;
}

function openEditPlan(id, page, func)
{
	$('#edit_id').val(id);
	$('#page').val(page);
	$('#function').val(func);
	$('#mainForm').submit();
}

function disableCustomerAccount(id, page, func)
{
	if(confirm("Do you really want to Disable the Customers Account. The customers would not be able to log in again!"))
	{
		$('#edit_id').val(id);
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
	
	return false;
}

function editCredits()
{
	document.getElementById('editCreditsLi').style.display = "";
	return false;
}

function editCreditsEntry(id, page, func)
{
	if(confirm("Do you really want to Edit the Customer's Credits!"))
	{
		$('#edit_id').val(id);
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
	}
	
	return false;
}

function buyPhoneForCustomer(id, page, func)
{
		$('#edit_id').val(id);
		$('#page').val(page);
		$('#function').val(func);
		$('#mainForm').submit();
}



	
	$(function() {
    $( "#datepicker" ).datepicker();
  	});

	$(document).ready( function () {
		$('.data-table').dataTable({
			"iDisplayLength": 15,
			"aLengthMenu": [[15,30,100,-1], [15,30,100,"All"]],
			"sPaginationType": "full_numbers",
			"oLanguage": {"sLengthMenu": "Show:_MENU_"}
		});
		
		$('.user-table').dataTable({
			"iDisplayLength": 10,
			"aLengthMenu": [[10,20,50,-1], [10,20,100,"All"]],
			"sPaginationType": "full_numbers",
		});
		
		$('.plan-table').dataTable({
			"iDisplayLength": 15,
			"bFilter": false,
			"bSearchable":false,
			"bInfo":false,
			"bLengthChange": false,
		});
		
		$('.date_picker_1').datepicker({
			"dateFormat" : "yy-mm-dd",
		});
	});
