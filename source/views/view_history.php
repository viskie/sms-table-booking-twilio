<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//echo "<pre>"; print_r($data);
$pageTitle = "Queue History";
if($data['new_page'] == "view_queue_managers.php")
{
	echo '<input type="hidden" name="edit_id" value="'.$data['edit_id'].'" id="edit_id" />';
	$pageTitle = "Queue Manager History";
}
?>


					<!-- Content -->
					<div id="content" class="clearfix">

                     <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
            
                       


                        <!-- Main Content -->
                        <div id="main-content" >
	 						<h2>Filter Data</h2>
							<label class="up-align">Start Date</label>
							<input type="text" name="start_date" id="start_date" class="box-small date_picker_1 up-align">
                            <label class="up-align">End Date</label>
							<input type="text" name="end_date" id="end_date" class="box-small date_picker_1 up-align">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="up-align" type="green" onClick="return callPage('<?=$data['new_page']?>','<?=$data['function']?>')">Search</button>
							<br /><br />
                            <!-- All Users -->
                            <h2><?=$pageTitle?> (<?=sizeof($data['queueHistory'])?>)</h2>
                            
                            
                                
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Customer Name</th>
                                        <th>Phone Number</th>
                                        <th>Date</th>
                                        <th>Arrival Time</th>
                                        <th>Dispatch Time</th>
                                        <th>Categorized <br /> List</th>
                                        <th>Queue Manager</th>


                                    </tr>
                                </thead>
                                <tbody>
                                   <?	$counter=0;
									   foreach($data['queueHistory'] as $value)
									   {	$counter++;
										   ?>
										    <tr>
												<td class="tbold backcolor"><?=$counter; ?></td>
												<td><?=$value['storeCustomerDetails']['store_customer_name']; ?></td>
                                                <td><?=$value['storeCustomerDetails']['phone_number']; ?></td>
												<td><?=date("M j Y",$value['arrival_timestamp']); ?></td>
                                                <td><?=date("g:i a",$value['arrival_timestamp']); ?></td>
                                                <td><?=date("g:i a",$value['dispatch_timestamp']); ?></td>
												<td><?=$queueObject->getListName($value['list_id']); ?></td>
                                                <td><?=$queueObject->getUserNameUsingId($value['queue_manager_id']); ?></td>
											</tr>								   
										   <?
									   }
									  ?>	
                                </tbody>
                            </table>
                            <!-- END Users table -->                           
                          
                            
                        </div>
                        <!-- END Main Content -->

					</div>
					<!-- END Content -->
