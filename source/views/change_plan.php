<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//echo "<pre>"; print_r($data);
?>
<input type="hidden" id="selected_plan" name="selected_plan" value="" />
<input type="hidden" id="selected_plan_type" name="selected_plan_type" value="" />
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
                            <h2>Change Main Plan</h2>
					
							
							<table cellpadding="0" cellspacing="0" border="0" class="plan-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Plan Name</th>
                                        <th>Credits</th>
										<th>Phone Numbers</th>
										<th>Amount</th>
                                        <th>Action</th>								
                                    </tr>
                                </thead>
                                <tbody>
                                   <?  $cntr = 0;
									   foreach($data['allPlans'] as $value)
									   {	$cntr++;
										   ?>
										    <tr>
												<td class="tbold backcolor"><?=$cntr; ?></td>
												<td><?=$value['plan_name']; ?></td>
                                                <td><?=$value['credits']; ?></td>
                                                <td><?=$value['phone_numbers']; ?></td>
                                                <td>USD <?=$value['cost']; ?></td>
												<td><button onClick="return buyPlan('<?=$value['plan_id']?>','main','view_customer_profile.php','buy_plan')">Buy Plan</button></td>												
											</tr>								   
										   <?
									   }
									  ?>	
                                </tbody>
                            </table>	

                            <h2>Buy Add-on Plan</h2>

							<table cellpadding="0" cellspacing="0" border="0" class="plan-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Plan Name</th>
                                        <th>Credits</th>
										<th>Phone Numbers</th>
										<th>Amount</th>
                                        <th>Action</th>								
                                    </tr>
                                </thead>
                                <tbody>
                                   <?  $cntr = 0;
									   foreach($data['allAddonPlans'] as $value)
									   {	$cntr++;
										   ?>
										    <tr>
												<td class="tbold backcolor"><?=$cntr; ?></td>
												<td><?=$value['plan_name']; ?></td>
                                                <td><?=$value['credits']; ?></td>
                                                <td><?=$value['phone_numbers']; ?></td>
                                                <td>USD <?=$value['cost']; ?></td>
												<td><button onClick="return buyPlan('<?=$value['plan_id']?>','addon','view_customer_profile.php','buy_plan')">Buy Plan</button></td>												
											</tr>								   
										   <?
									   }
									  ?>	
                                </tbody>
                            </table>	
					
                            <!-- Users table --> 
                            
                            <!-- END Users table -->                           

                          
                            
                        </div>
                        <!-- END Main Content -->

					</div>
					<!-- END Content -->
					
					
