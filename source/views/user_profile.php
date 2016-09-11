<?
//echo "<pre>"; print_r($data);

?>
                        <!-- Main Content -->
                        <div id="main-content">
 					 <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <? }  else  if($notificationArray['type'] == "Message") { ?>
                      <div class="msg-info enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } 
					  
					  } ?>

                            <!-- Messages -->
                         
                            <h2>My Profile</h2>
                            
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
                                            <label for="adduser-username">Username <span>*</span></label>
                                            <input type="text" id="user_name" name="user_name" disabled="disabled"  value='<?=$data['userDetails']['user_name']?>' />
                                            <span class="msg-form-info">Alphanumeric characters only!</span>
                                        </li>
                                        <li>
                                            <label for="adduser-email">Email <span>*</span></label>
                                          <input type="text" id="user_email" name="user_email"  value='<?=$data['userDetails']['user_email']?>' />
                                        </li>
                                        <li>
                                            <label for="adduser-password">Password <span>*</span></label>
                                            <input type="password" id="user_password" name="user_password" value="********" />
                                            <span class="msg-form-info">At least 6 characters!</span>
                                        </li>
                                        <li>
                                            <label for="adduser-firstname">Name</label>
                                            <input type="text" id="name" name="name"  value='<?=$data['userDetails']['name']?>' />
                                        </li>
                                        <li>
                                            <label for="adduser-info">Phone</label>
                                             <input type="text" id="user_phone" name="user_phone"  value='<?=$data['userDetails']['user_phone']?>' />
                                        </li>
                                        <li>
                                            <label></label>
                                            <button value="Submit" class="green"  onclick="javascript:updateProfile('user_profile.php','save')">Update</button>

                                        </li>
                                    </ul>
                                    
                           
                                <!-- END Add user form -->
                                
                            </div>
                            
                        </div>
                        <!-- END Main Content -->
