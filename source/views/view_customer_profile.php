<?
//echo "<pre>"; print_r($data);
?>
<? if($function == 'edit') { ?>
<input type="hidden" name="user_id" id="user_id" value="<?=$data['userDetails']['user_id']?>" />
<input type="hidden" name="customer_id" id="customer_id" value="<?=$data['customerDetails']['customer_id']?>" />
<? } ?>
                        <!-- Main Content -->
                        <div id="main-content">
                             <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                                <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                              <? }  else  if($notificationArray['type'] == "Failed") { ?>
                              <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                              <?   } } ?>
                            <!-- Messages -->
                         
                            <h2>My Profile</h2>
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
											<label>Business Name <span>*</span></label>
                                            <input type="text" id="customer_biz_name" name="customer_biz_name"  value='' />
										</li>
                                        <li>
											<label for="adduser-username">Email <span>*</span></label>
                                            <input type="text" id="customer_email" name="customer_email"  value='' />
										
											<label for="adduser-username">Phone <span>*</span></label>
                                            <input type="text" id="customer_phone" name="customer_phone"  value='' />
										</li>
                                        <li>
											<label for="adduser-username">Address <span></span></label>
                                            <textarea id="address" name="address" ></textarea>
										</li>
										<li>
											<li>
											<label for="adduser-username">City <span></span></label>
                                            <input type="text" id="city" name="city"  value='' />
										
											<label for="adduser-username">State <span></span></label>
                                            <input type="text" id="state" name="state"  value='' />
										</li>
										<li>
											<label for="adduser-username">Zip <span></span></label>
                                            <input type="text" id="zip" name="zip"  value='' />
										</li>
										<br />
										<li style="text-align:center">
                                           
                                            <button value="Submit" class="green"  onclick="return updateProfile('view_customer_profile.php','update_profile')">Update</button>
                                        	
                                        </li>
									</ul>
                                 
							</div>
                            <h2>My Plan Details</h2>
                            <div class="body-con">
                            	 <ul class="align-list" >
                                        <li>
                                        	<label>&nbsp;&nbsp;&nbsp;</label>
											<label style="font-weight:normal;">Plan :</label>
                                            <label style="text-align:left"> <?=$data['planDetails']['plan_name']?></label>
										</li>
                                        <li>
                                        	<label>&nbsp;&nbsp;&nbsp;</label>
											<label style="font-weight:normal;">Plan Credits :</label>
                                            <label style="text-align:left"><?=$data['planDetails']['plan_name']?></label>
                                            <label>&nbsp;&nbsp;&nbsp;</label>
                                            <label style="font-weight:normal;">Add-On Credits:</label>
                                            <label style="text-align:left"><?=$data['customerCredits']['addon_credits']?></label>
										</li>
                                        <li>
                                        	<label>&nbsp;&nbsp;&nbsp;</label>
											<label style="font-weight:normal;">Remaining Credits:</label>
                                            <label style="text-align:left"><?=$data['customerCredits']['main_credits']?> </label>
											<label>&nbsp;&nbsp;&nbsp;</label>
											<label style="font-weight:normal;">Plan Cost:</label>
                                            <label style="text-align:left;">USD <?=$data['planDetails']['cost']?></label>
										</li>
                                        <li>
                                        	<label>&nbsp;&nbsp;&nbsp;</label>
											<label style="vertical-align:top;font-weight:normal;">Subscription Date:</label>
                                            <label style="text-align:left;">Post Paymkent Gateway Impl.</label>
											<label>&nbsp;&nbsp;&nbsp;</label>
											<label style="vertical-align:top;font-weight:normal;">Renewal Date:</label>
                                            <label style="text-align:left">Post Paymkent Gateway Impl.</label>
										</li>
                                        <br />
                                        <li style="text-align:center">
                                            
                                            <button value="Submit" class="green"  onclick="return callPage('view_customer_profile.php','change_plan')">Change Plan</button>
                                            <label></label>
                                            <button value="Submit" class="green"  onclick="return false">Change Billing Info</button>
                                        </li>
                                 </ul>
                            </div>
  
                        </div>
                        <!-- END Main Content -->

                   <script type="text/javascript">
						$(document).ready( function () {
								<? foreach($data['customerProfile'] as $key=>$value ) { ?>
										$('#<?=$key;?>').val('<?=$value;?>');
								<? } ?>	
					
						});
                   </script>

                   
                   
