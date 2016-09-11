<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}
//echo "<pre>"; print_r($data);
?>
<input type="hidden" name="edit_id"  id="edit_id" />

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
                            <h2>All Customers (<?=sizeof($data['allCustomers'])?>)</h2>
                            
                            
                                
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Business<br />Name</th>
                                        <th>Customer <br />Admin User</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Avaialable <br />Credits</th>
                                        <th>City</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?
									   foreach($data['allCustomers'] as $value)
									   {
										   ?>
										    <tr>
												<td class="tbold backcolor"><?=$value['customer_biz_name']; ?></td>
												<td><?=$userObject->getUserNameUsingId($value['customer_admin_user_id']); ?></td>
												<td><?=$value['customer_email']; ?></td>
												<td><?=$value['customer_phone']; ?></td>
												<td><?=$value['customer_twlio_credits']; ?></td>
												<td><?=$value['city']; ?></td>
												<td><?=$value['status']; ?></td>
												<td nowrap="nowrap"><a href="javascript:openEditCustomer('<?=$value['customer_id']?>','manage_customers.php','edit_customer')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
                                                <a href="javascript:openEditCustomerDetails('<?=$value['customer_id']?>','manage_customers.php','view_customer_details')" class="tiptip-top" title="View Details"><img src="img/icon_view.png" alt="View Details" /></a>
														  
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
