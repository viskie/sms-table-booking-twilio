<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//echo "<pre>"; print_r($data);
?>
<input type="hidden" id="customer_id" name="customer_id" value="" />
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
                            <h2>Select A Customer</h2>
                           
						
							<label class="up-align">Select Customer</label>
							<? createComboBox('customer','customer_id','customer_biz_name', $data['allCustomers'] )?>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="up-align" type="green" onClick="return callPage('view_activity_logs.php','get_logs')">Search</button>
							<br /><br />
                            <? if($function=='get_logs') { ?>
							<h2>Activity Logs</h2>							
							
							<table cellpadding="0" cellspacing="0" border="0" class="data-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User</th>
                                        <th>Page</th>
										<th>Function</th>
                                        <th>Date Time</th>	
																	
                                    </tr>
                                </thead>
                                <tbody>
                                   <?  $cntr = 0;
									   foreach($data['customerLogs'] as $value)
									   {	$cntr++;
										   ?>
										    <tr>
												<td class="tbold backcolor"><?=$cntr; ?></td>
												<td><?=$customerObject->getUserNameUsingId($value['user_id']); ?></td>
                                                <td><?=$value['page']; ?></td>
                                                <td><? if(trim($value['function']) == "") {echo "View";} else { echo $value['function'];}  ?></td>
                                                <td><?=date("d-m-Y g:i a",$value['time_stamp']); ?></td>										
											</tr>								   
										   <?
									   }
									  ?>	
                                </tbody>
                            </table>	
							<? }?>
                            <!-- Users table --> 
                            
                            <!-- END Users table -->                           

                          
                            
                        </div>
                        <!-- END Main Content -->

					</div>
					<!-- END Content -->
					
					
