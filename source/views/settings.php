<?
//echo "<pre>"; print_r($data); exit;
?>
                        <!-- Main Content -->
                        <div id="main-content">
                         <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
                            <!-- Messages -->
                         
                            <h2>Update Settings</h2>
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
											<label>Twilio SID <span>*</span></label>
                                            <input type="text" id="twilio_sid" name="twilio_sid"  value='<?=$data['allSettings'][0]['config_value']?>' />
										</li>
                                        <li>
											<label for="adduser-username">Twilio Auth Token <span>*</span></label>
                                            <input type="text" id="twilio_auth_token" name="twilio_auth_token"  value='<?=$data['allSettings'][1]['config_value']?>' />
										</li>
                                        <li>
											<label for="adduser-username">Application SID <span>*</span></label>
                                            <input type="text" id="twilio_app_sid" name="twilio_app_sid"  value='<?=$data['allSettings'][2]['config_value']?>' />
										</li>
										<li>
                                            <label></label>
                                            <button value="Submit" class="green"  onclick="javascript:editUser('settings.php','updateSettings')">Update</button>

                                        </li>

									</ul>
							</div>

                           
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
                   
                   
