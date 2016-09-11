<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//echo "<pre>"; print_r($data);
?>
<input type="hidden" name="edit_id" value="" id="edit_id" />

					<!-- Content -->
					<div id="content" class="clearfix">

                        <!-- Sidebar -->
                        <div id="side-content-left">   
                     <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>
                            <!-- Roles box -->
                            <table style="display:none">
                                <thead>
                                    <tr>
                                        <th colspan="2">Roles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?
                                   foreach($data['allGroups'] as $value)
                                   {
									   ?>
									   <tr>
                                        <td class="backcolor tleft"><?=$value['group_name']; ?></td>
                                        <td><a href="javascript: void(0)" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
                                        </td>
                                      </tr>									   
									   <?
								   }
                                   ?>	
                                </tbody>
                            </table>
                            <!-- END Roles box -->
                            
                            <!-- Add user Box -->
                            <h3>Add User</h3>
                            <div class="body-con">
                    
                                    <label for="sf-username">Username</label>
                                    <input type="text" id="user_name" name="user_name" />
                                    <label for="sf-email">Email</label>
                                    <input type="text" id="user_email" name="user_email" />
                                    <label for="sf-email">Name</label>
                                    <input type="text" id="name" name="name" />
                                    <label for="sf-password">Password</label>
                                    <input type="password" id="user_password" name="user_password" />
                                     <label for="sf-password">Confirm Password</label>
                                    <input type="password" id="cfm_password" name="user_password" />
                                     <label for="sf-password">Phone</label>
                                    <input type="text" id="user_phone" name="user_phone" />
                                    <label for="sf-role">Role</label>
                                   <? getGroupCombo('user_group') ?>
                                  <br />  <br />
                                       	  <input type="button" value="Insert" class="green"  onclick="javascript:addUser('manage_users.php','add_user')" >
                                    </p>
                            </div>
                            <!-- END Add user Box -->
                            
                       

                        </div>
                        <!-- END Sidebar -->

                        <!-- Main Content -->
                        <div id="main-content-right">

                            <!-- All Users -->
                            <h2>All Users (<?=sizeof($data['allUsers'])?>)</h2>
                            
                            
                                
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?
									   foreach($data['allUsers'] as $value)
									   {
										   ?>
										    <tr>
												<td class="tbold backcolor"><?=$value['user_name']; ?></td>
												<td><?=$value['user_email']; ?></td>
												<td><?=$value['user_name']; ?></td>
												<td><?=$value['user_phone']; ?></td>
												<td><a href="javascript:openEditUser('<?=$value['user_id']?>','manage_users.php','edit_user')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
														  	&nbsp;&nbsp;&nbsp;<a href="javascript:deleteUser('<?=$value['user_id']?>','<?=$value['user_name']?>','manage_users.php','delete_user')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
												</td>
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
