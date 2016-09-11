<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//echo "<pre>"; print_r($data);

$actionArrayNew = array(
						"0"=>array("display"=>"Select", "value"=>"0"),
						"1"=>array("display"=>"Accept", "value"=>"accept"),
						"2"=>array("display"=>"Ignore", "value"=>"ignore"),
					);

?>
<input type="hidden" name="edit_id" value="" id="edit_id" />

					<!-- Content -->
					<div id="content" class="clearfix">

                        <!-- Main Content -->
                       

                            <!-- All Users -->
                            <h2>Queue (<?=sizeof($data['queue'])?>)</h2>
                             <div align="center" id="mainQContainer">
                                 
                                  <div class='msg-info queue_row'>
                                        <div class="queue_cell" style="width:5%"><b>No</b></div>
                                        <div class="queue_cell" style="width:20%"><b>Customer Name</b></div>
                                        <div class="queue_cell" style="width:10%"><b>Phone Number</b></div>
                                        <div class="queue_cell" style="width:10%"><b>Arrival Time</b></div>
                                        <div class="queue_cell" style="width:20%"><b>Categorize</b></div>
                                        <div class="queue_cell" style="width:20%"><b>QueueManager</b></div>
                                        <div class="queue_cell" style="width:15%"><b>Action</b></div>
                                      
                                 </div>
                                 <div style="height:5px;">
                                 &nbsp;
                                 </div>
                                  <?	$count = 0;
									   foreach($data['queue'] as $value)
									   { $count++;
									   	 $class = 'msg-ok';
									   	 if($value['status'] == '2')
										 {
											$class = 'msg-alert';
										 }
									   
										   ?>
                                          	<div class='<?=$class?> queue_row'>
                                       			<div class="queue_cell" style="width:5%"><?=$count; ?></div>
                                                <div class="queue_cell" style="width:20%"><?=$value['store_customer_name']; ?></div>
                                                <div class="queue_cell" style="width:10%"><?=$value['phone_number']; ?></div>
                                                <div class="queue_cell" style="width:10%"><?=date(" g:i a",$value['arrival_timestamp']); ?></div>
                                                <div class="queue_cell" style="width:20%">
                                                <?
													if($value['status'] != '2')
													{	echo "TBA"; }
													else
													{ 	createComboBox($value['q_id'].'_category','list_id','list_name', $data['lists'], $blankField=true, "","",'',""); }
												?>                                                
                                                </div>
                                                <div class="queue_cell" style="width:20%">
												<?
													if($value['queue_manager_id'] == '0')
													{	echo "TBA"; }
													else
													{ 	echo $queueObject->getUserNameUsingId($value['queue_manager_id']); }
												?>
                                                </div>
                                               
												  <? if($value['status'] != '2')
													{	
														echo "<div class='queue_cell' style='width:15%;'>";
														createComboBox($value['q_id'].'_action','value','display', $actionArrayNew,false,"","",'', "onChange= \"processQueue('".$value['q_id']."','view_queue.php','process_queue')\"");
														echo "</div>";
													}
													else
													{ 	
														echo "<div class='queue_cell' style='width:15%; padding-top:0px;'>";
														echo "<input type='hidden' name='".$value['q_id']."_action'  id='".$value['q_id']."_action' value='dispatch' />";
														echo "<button class='green' onclick=\"return processQueue('".$value['q_id']."','view_queue.php','process_queue')\">Finished</button>";
														echo "</div>";
													}
												?>  
												
                                 			</div>	
                                           						   
										   <?
									   }
									  ?>
                                 
                             </div>
 <div id="jaxResp">Ajax Response</div>
                        <!-- END Main Content -->

					</div>
					<!-- END Content -->
<script type="text/javascript">
var counter = 0;
var max_queue_id = <?=$data['latest_q_id']?>;
function poll() 
{
    checkForNewQEntry(); 
    setTimeout(poll, 10000);
    // ...
}

setTimeout(poll, 10000);

function checkForNewQEntry()
{
	url = 'ajaxController.php';
	containerId = 'jaxResp';
	xmlHttp1=GetXmlHttpObject1();
	if(xmlHttp1==null) 
	{	alert ("Your browser does not support AJAX!");
		return;
	}
		//varStatus = offset;
		//alert(varStatus);
		
		var data = "page=view_queue.php&function=ajax_queue_poll";
		xmlHttp1.onreadystatechange=function()
		{
			if(xmlHttp1.readyState > 0 && xmlHttp1.readyState < 4)
			{
				
			}
			if(xmlHttp1.readyState==4)
			{
				//alert(xmlHttp1.responseText);
				counter++;
				var polResp = parseInt(xmlHttp1.responseText.trim());
				if(polResp == max_queue_id)
				{
					
				}
				else
				{
					refreshQueue(polResp);
				}
				//document.getElementById(containerId).innerHTML = xmlHttp1.responseText+"<br /> Current Max Q Id: "+max_queue_id;
			}
		}
		//alert(url);
		xmlHttp1.open("POST",url,true);
		xmlHttp1.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
		xmlHttp1.send(data);
}

function refreshQueue(polResp)
{
	url = 'ajaxController.php';
	containerId = 'mainQContainer';
	xmlHttp1=GetXmlHttpObject1();
	if(xmlHttp1==null) 
	{	alert ("Your browser does not support AJAX!");
		return;
	}
		//varStatus = offset;
		//alert(varStatus);
		
		var data = "page=view_queue.php&function=ajax_refresh_queue";
		xmlHttp1.onreadystatechange=function()
		{
			if(xmlHttp1.readyState > 0 && xmlHttp1.readyState < 4)
			{
				
			}
			if(xmlHttp1.readyState==4)
			{
				document.getElementById(containerId).innerHTML = xmlHttp1.responseText;
				max_queue_id = polResp;
			}
		}
		//alert(url);
		xmlHttp1.open("POST",url,true);
		xmlHttp1.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
		xmlHttp1.send(data);
}


</script>