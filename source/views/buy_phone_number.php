<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//echo "<pre>"; print_r($data);

if(($function == "buy_numbers_for_customer") || ($function == "view_available_numbers_fc"))
{
	echo "<input type='hidden' name='customer_id' id='customer_id' value='".$data['selected_customer']."'";
}
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
                            <h2>Search For Avialble Phone Numbers</h2>
                           
						
							<label class="up-align">Search Criteria</label>
							<input type="text" name="search_criteria" id="search_criteria" class="up-align">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            
                             <? if(($function == "buy_numbers_for_customer") || ($function == "view_available_numbers_fc")) {  ?>
												<button class="up-align" type="green" onClick="return callPage('manage_customers.php','view_available_numbers_fc')">Search</button>
												<? } else { ?>
                                                <button class="up-align" type="green" onClick="return callPage('buy_phone_number.php','view_available_numbers')">Search</button>
                                                <? } ?>
							<br /><br />
                            <? if($function=='view_available_numbers') { ?>
							<h2>Avaialable Phone Numbers</h2>							
							
							<table cellpadding="0" cellspacing="0" border="0" class="data-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Phone Number</th>
                                        <th>Rate Center</th>
										<th>Region</th>
										<th>Postal Code</th>
                                        <th>Country</th>
                                        <th>Action</th>									
                                    </tr>
                                </thead>
                                <tbody>
                                   <?  $cntr = 0;
									   foreach($data['availableNumbers'] as $value)
									   {	$cntr++;
										   ?>
										    <tr>
												<td class="tbold backcolor"><?=$cntr; ?></td>
												<td><?=$value->friendly_name; ?></td>
												<td><?=$value->rate_center; ?></td>
												<td><?=$value->region; ?></td>
												<td><?=$value->postal_code; ?></td>
												<td><?=$value->iso_country; ?></td>
												<td>
                                                <? if($function == "buy_numbers_for_customer") {  ?>
												<button onClick="return buyNumber('<?=$value->phone_number?>','manage_customers.php','buy_new_number_for_customer')">Buy for Customer</button>
												<? } else { ?>
                                                <button onClick="return buyNumber('<?=$value->phone_number?>','buy_phone_number.php','buy_new_number')">Buy Number</button>
                                                <? } ?>
                                                </td>												
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
					
					
