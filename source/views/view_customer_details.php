<?
//echo "<pre>"; print_r($data);
?>

<input type="hidden" name="edit_id" id="edit_id" value="" />


                        <!-- Main Content -->
                        <div id="main-content">
                             <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                                <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                              <? }  else  if($notificationArray['type'] == "Failed") { ?>
                              <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                              <?   } } ?>
                            <!-- Messages -->
                         
                            <h2>Customer Profile</h2>
                            <div class="body-con">

                                    <ul class="align-list">
                                         <li>
                                        	<label>&nbsp;&nbsp;&nbsp;</label>
											<label style="font-weight:normal;">Business Name :</label>
                                            <label style="text-align:left"> <?=$data['customerProfile']['customer_biz_name']?></label>
										
                                        	<label>&nbsp;&nbsp;&nbsp;</label>
											<label style="font-weight:normal;">Email :</label>
                                            <label style="text-align:left"> <?=$data['customerProfile']['customer_email']?></label>
										</li>
                                         <li>
                                        	<label>&nbsp;&nbsp;&nbsp;</label>
											<label style="font-weight:normal;">Address :</label>
                                            <label style="text-align:left"> <?=$data['customerProfile']['address']?></label>
										</li>
                                        <li>
                                        	<label>&nbsp;&nbsp;&nbsp;</label>
											<label style="font-weight:normal;">Phone :</label>
                                            <label style="text-align:left"> <?=$data['customerProfile']['customer_phone']?></label>
										    <label>&nbsp;&nbsp;&nbsp;</label>
											<label style="font-weight:normal;">City :</label>
                                            <label style="text-align:left"> <?=$data['customerProfile']['city']?></label>
										</li>
                                        <li>
                                        	<label>&nbsp;&nbsp;&nbsp;</label>
											<label style="font-weight:normal;">State :</label>
                                            <label style="text-align:left"> <?=$data['customerProfile']['state']?></label>
                                        	<label>&nbsp;&nbsp;&nbsp;</label>
											<label style="font-weight:normal;">Zip :</label>
                                            <label style="text-align:left"> <?=$data['customerProfile']['zip']?></label>
										</li>
                                        <li>
                                        	<label>&nbsp;&nbsp;&nbsp;</label>
											<label style="font-weight:normal;">Account Status :</label>
                                            <label style="text-align:left"> <?=$data['customerProfile']['status']?></label>
                                        	
										</li>
                                        
									</ul>
                                 
							</div>
                            <h2>Customer Plan Details</h2>
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
                                 </ul>
                            </div>
  							 <h2>Customer Payment Details</h2>
                            <div class="body-con">
                            	 <ul class="align-list" >
                                        <li>
                                        	Will be updated after payment gateway integration
										</li>
                                </ul>
                            </div>
                            </div>
  							 <h2>Customer Override Options</h2>
                            <div class="body-con">
                            	 <ul class="align-list" >
                                        <li style="text-align:center">
                                            <button value="Submit" class="green"  onclick="return disableCustomerAccount('<?=$data['customerProfile']['customer_id']?>','manage_customers.php','disable_account')">Disable Account</button>
                                            <button value="Submit" class="green"  onclick="return editCredits()">Add/Edit Credits</button>
                                            <button value="Submit" class="green"  onclick="return buyPhoneForCustomer('<?=$data['customerProfile']['customer_id']?>','manage_customers.php','buy_numbers_for_customer')">Buy Phone Numbers</button>
                                        	
                                        </li>
                                        <li style="display:none" id="editCreditsLi">
                                        <label >Main Credits:</label>
                                        <label >
                                        	<input type="text"  value="<?=$data['customerCredits']['main_credits']?>" name="main_credits" id="main_credits" class="box-small" />
                                        </label>
                                        <label >Add-On Credits:</label>
                                        <label >
                                        	<input type="text"  value="<?=$data['customerCredits']['addon_credits']?>" name="addon_credits" id="addon_credits" class="box-small" />
                                        </label>
                                        <label >
                                        	 <button value="Submit" class="green"  onclick="return editCreditsEntry('<?=$data['customerProfile']['customer_id']?>','manage_customers.php','edit_credits')">Update Credits</button>
                                        </label>
                                        </li>
                                </ul>
                            </div>
                       		
                        <!-- END Main Content -->

                   
                   
