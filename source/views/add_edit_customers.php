<?
//echo "<pre>"; print_r($data);
?>
<? if($function == 'edit_customer') { ?>
<input type="hidden" name="user_id" id="user_id" value="<?=$data['userDetails']['user_id']?>" />
<input type="hidden" name="customer_id" id="customer_id" value="<?=$data['customerDetails']['customer_id']?>" />
<? } ?>
                        <!-- Main Content -->
                        <div id="main-content">
                            
                            <!-- Messages -->
                         
                            <h2><? if($_REQUEST['function']=='show_add_customer') { echo "Add Customer"; } else { echo "Edit Customer";} ?></h2>
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
											<label>Business Name <span>*</span></label>
                                            <input type="text" id="customer_biz_name" name="customer_biz_name"  value='' />
										</li>
                                        <li>
											<label for="adduser-username">Email <span>*</span></label>
                                            <input type="text" id="customer_email" name="customer_email"  value='' />
										</li>
                                        <li>
											<label for="adduser-username">Phone <span>*</span></label>
                                            <input type="text" id="customer_phone" name="customer_phone"  value='' />
										</li>
                                        <li>
											<label for="adduser-username">Product Plan <span>*</span></label>
											
											  <?  if($_REQUEST['function'] == 'edit_customer') {    
                                               createComboBox('customer_plan','plan_id','plan_name', $data['allPlans'], false,$data['customerDetails']['customer_plan']);
                                               } else {
                                                createComboBox('customer_plan','plan_id','plan_name', $data['allPlans'], false);
											   }  ?>
                                            
										</li>
                                        <li>
											<label for="adduser-username">Address <span></span></label>
                                            <input type="text" id="address" name="address"  value='' />
										</li>
										<li>
											<li>
											<label for="adduser-username">City <span></span></label>
                                            <input type="text" id="city" name="city"  value='' />
										</li>
										<li>
											<label for="adduser-username">State <span></span></label>
                                            <input type="text" id="state" name="state"  value='' />
										</li>
										<li>
											<label for="adduser-username">Zip <span></span></label>
                                            <input type="text" id="zip" name="zip"  value='' />
										</li>
										<li>
											<label for="adduser-username">Status <span></span></label>
											<select id="status" name="status" value="status">
												<option value="Active" selected="selected">Active</option>
												<option value="InActive">InActive</option>
												<option value ="Disabled">Disabled</option>
											</select>
										</li>

									</ul>
							</div>
                            <h2>Customer Billing Info</h2>
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
											<label>Name on thr Card<span>*</span></label>
                                            <input type="text" id="customer_card_name" name="customer_card_name"  value='' />
										</li>
                                        <li>
											<label>Card Number<span>*</span></label>
                                            <input type="text" id="customer_card_number" name="customer_card_number"  value='' />
										</li>
                                        <li>
											<label for="adduser-username">Expiry Month<span>*</span></label>
                                            <input type="text" id="card_expiry_month" name="card_expiry_month"  value='' />
										</li>
                                        <li>
											<label for="adduser-username">Expiry Year<span>*</span></label>
                                            <input type="text" id="card_expiry_year" name="card_expiry_year"  value='' />
										</li>
                                        <li>
											<label for="adduser-username">CVC <span></span></label>
                                            <input type="text" id="card_cvc" name="card_cvc"  value='' />
										</li>
									</ul>
							</div>
                            
                            <h3> Admin User for the Customer</h3>
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
                                            <label for="adduser-username">Username <span>*</span></label>
                                            <input type="text" id="user_name" name="user_name"  value='' />
                                            <span class="msg-form-info">Alphanumeric characters only!</span>
                                        </li>
                                        <li>
                                            <label for="adduser-email">Email <span>*</span></label>
                                          <input type="text" id="user_email" name="user_email"  value='' />
                                        </li>
                                        <li>
                                            <label for="adduser-password">Password <span>*</span></label>
                                            <input type="password" id="user_password" name="user_password" />
                                            <span class="msg-form-info">At least 6 characters!</span>
                                        </li>
                                         <?  if($_REQUEST['function'] != 'edit_customer') {    ?>  
                                        <li>
                                            <label for="adduser-password">Confirm Password <span>*</span></label>
                                            <input type="password" id="cfm_password" name="cfm_password" />
                                            <span id="spn_password" style="color:red" class="msg-form-info"></span>
                                        </li>
                                         <? } ?>
                                        <li>
                                            <label for="adduser-firstname">Name</label>
                                            <input type="text" id="name" name="name"  value='' />
                                        </li>
                                        <li>
                                            <label for="adduser-info">Phone</label>
                                             <input type="phone" id="user_phone" name="user_phone"  value='' />
                                        </li>
                                        <li>
                                            <label for="adduser-birthdate">Role</label>
											<select name="user_group" id="user_group">
												<option value='3'>Customer Admins</option>
											</select> 
                                        </li>
                                        <li>
                                            <label></label>
                                            <?  if($_REQUEST['function'] == 'edit_customer') {    ?>     
                                             <input type="button" value="Update" class="green"  onclick="javascript:updateCustomer('<?=$data['customerDetails']['customer_id']?>','manage_customers.php','edit_user_entry')" >
                                            <? } else { ?>
                                           <input type="button" value="Insert" class="green"  onclick="javascript:addCustomer('manage_customers.php','add_customer')" >
                                           <? } ?>
                                        </li>
                                    </ul>
                                    
                           
                                <!-- END Add user form -->
                                
                            </div>
                            
                        </div>
                        <!-- END Main Content -->
                   <?
                   if($_REQUEST['function'] == 'edit_customer') {    ?>     
                   <script type="text/javascript">
						$(document).ready( function () {
								<? foreach($data['customerDetails'] as $key=>$value ) { ?>
										$('#<?=$key;?>').val('<?=$value;?>');
										
								<? } ?>	
								
								<? foreach($data['userDetails'] as $key=>$value ) { ?>
										$('#<?=$key;?>').val('<?=$value;?>');
								<? } ?>	
									$('#user_password').val('');					
						});
                   </script>
                   
                   <? } ?>
                   
                   
