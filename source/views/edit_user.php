<?
//echo "<pre>"; print_r($data);

?>
<input type="hidden" name="user_id" id="user_id" value="<?=$data['userDetails']['user_id']?>" />
                        <!-- Main Content -->
                        <div id="main-content">


                            <!-- Messages -->
                         
                            <h2>Edit User</h2>
                            
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
                                            <label for="adduser-username">Username <span>*</span></label>
                                            <input type="text" id="user_name" name="user_name"  value='<?=$data['userDetails']['user_name']?>' />
                                            <span class="msg-form-info">Alphanumeric characters only!</span>
                                        </li>
                                        <li>
                                            <label for="adduser-email">Email <span>*</span></label>
                                          <input type="text" id="user_email" name="user_email"  value='<?=$data['userDetails']['user_email']?>' />
                                        </li>
                                        <li>
                                            <label for="adduser-password">Password <span>*</span></label>
                                            <input type="password" id="user_password" name="user_password" />
                                            <span class="msg-form-info">At least 6 characters!</span>
                                        </li>
                                        <li>
                                            <label for="adduser-firstname">Name</label>
                                            <input type="text" id="name" name="name"  value='<?=$data['userDetails']['name']?>' />
                                        </li>
                                        <li>
                                            <label for="adduser-info">Phone</label>
                                             <input type="phone" id="user_phone" name="user_phone"  value='<?=$data['userDetails']['user_phone']?>' />
                                        </li>
                                        <li>
                                            <label for="adduser-birthdate">Role</label>
                                           <? getGroupCombo('user_group',$data['userDetails']['user_group']) ?>
                                        </li>
                                        <li>
                                            <label></label>
                                            <button value="Submit" class="green"  onclick="javascript:callPage('manage_users.php','edit_user_entry')">Update</button>

                                        </li>
                                    </ul>
                                    
                           
                                <!-- END Add user form -->
                                
                            </div>
                            
                        </div>
                        <!-- END Main Content -->
