<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//echo "<pre>"; print_r($data);
?>
<?
if($function == 'show_data' || $function == "step2" || $function == "step4")
{
?>
<input type="hidden" id="new_phone_number" name="new_phone_number" value="" />
					<!-- Content -->
					<div id="content" class="clearfix">

                     <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <? }  else  if($notificationArray['type'] == "Message") { ?>
                      <div class="msg-info enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } 
					  
					  } ?>

                        <!-- Main Content -->
                        <div id="main-content">

                            <!-- All Users -->
                            <h2>Select Customers - Step 1</h2>

							<label class="up-align">Select List</label>
							<? createComboBox('cusomer_list','list_id','list_name', $data['allLists'], $blankField=true, $selectedValue="",$display2="",$firstFieldValue='All Customers', $otherParameters = "")?>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="up-align" type="green" onClick="return callPage('broadcast.php','step2')">Get Customer List</button>
							<br /><br />
                            
                           
<? if ($function == 'step2') {?>

	<h2>Select Customers - Step 2</h2>
							<table cellpadding="0" cellspacing="0" border="0" class="data-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Customer Name</th>
                                        <th>Phone Number</th>
										<th>Store Visits</th>
										<th>Select All <input type="checkbox" onClick="toggle(this)" /></th>
                                        								
                                    </tr>
                                </thead>
                                <tbody>
                                   <?  $cntr = 0;
									   foreach($data['selectedCustomers'] as $value)
									   {	$cntr++;
										   ?>
										    <tr>
												<td class="tbold backcolor"><?=$cntr; ?></td>
												<td><?=$value['store_customer_name']; ?></td>
                                                <td><?=$value['phone_number']; ?></td>
                                                <td><?=$value['store_visits']; ?></td>
												<td><input type="checkbox" name="sc_id[]" checked="checked" value="<?=$value['sc_id'];?>" id="chk_<?=$value['sc_id'];?>" ></td>												
											</tr>								   
										   <?
									   }
									  ?>	
                                </tbody>
                            </table>
                              <ul class="align-list">
                                        <li style="text-align:center">
									   		<button value="Submit" class="green"  onclick="return callPage('broadcast.php','step3')">Select Customers</button>
                                        </li>
                              </ul>                 
	<? } ?>
					
                        </div>
                        <!-- END Main Content -->
					</div>
					<!-- END Content -->
<? } else if($function == 'step3') {
	//echo "<pre>"; print_r($data); exit;
	//echo $data['customerIdString'];
	?>
    <input type="hidden" name="customer_id_string" id="customer_id_string" value="<?=$data['customerIdString']?>" />
	 <!-- Main Content -->
     <div id="content" class="clearfix">
                        <div id="main-content">

                            <!-- All Users -->
                            <h2>Selected Customers - Step 3 (<?=sizeof($data['selectedCustomers'])?> Customers Selected)</h2>
                            <div style="width:100%; height:150px; overflow:auto">
							<? foreach($data['selectedCustomers'] as $value)
							{ ?>
                            <div class="msg-info" style="width:200px; float:left; margin-left:10px;"><?=$value['store_customer_name'].":  ".$value['phone_number'] ?></div>  
                            <? } ?>
                            </div>
                           <h2>Broadcast Text Message</h2>
                            <label class="up-align">Message</label>
                            <textarea id="broadcast_message" name="broadcast_message" style="width:500px; height:50px" ></textarea>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label class="center-align">
                            	<button value="Broadcast" class="green"  onclick="return broadcastMessage('broadcast.php','step4')">Broadcast Message</button>
                            </label>
                            <br />
                            <div style="width:100%;text-align:center">
                            	
                            </div>
                        </div>
                        </div>
    
    
    <? } ?>