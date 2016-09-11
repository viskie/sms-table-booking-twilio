<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

//echo "<pre>"; print_r($data); exit;
?>
<input type="hidden" name="edit_id" value="" id="edit_id" />

					<!-- Content -->
					<div id="content" class="clearfix">

                     <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
            
                       


                        <!-- Main Content -->
                        <div id="main-content">

                            <!-- All Users -->
                            <h2>All Un-Subscribers (<?=sizeof($data['allCustomers'])?>)</h2>
                            
                            
                                
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Customer Name</th>
                                        <th>Phone Number</th>
                                        <th>Un-Subscription Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?	$counter=0;
									   foreach($data['allCustomers'] as $value)
									   {	$counter++;
										   ?>
										    <tr>
												<td class="tbold backcolor"><?=$counter; ?></td>
												<td><?=$value['store_customer_name']; ?></td>
												<td><?=$value['phone_number']; ?></td>
												<td><?=date("F j, Y, g:i a ",$value['time_stamp']) ?></td>
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
