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

                     <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                      <? }  else  if($notificationArray['type'] == "Failed") { ?>
                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                      <?   } } ?>

                        <!-- Main Content -->
                        <div id="main-content">

                            <!-- All Users -->
                            <h2>All Phone Numbers (<?=sizeof($data['allNumbers'])?> / {Plan Total})</h2>
                            
                            
                                
                            <!-- Users table --> 
                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Phone Number</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?  $count = 0;
									   foreach($data['allNumbers'] as $value)
									   { $count++;
										   ?>
										    <tr>
												<td class="tbold backcolor"><?=$count; ?></td>
												<td><?=$value['phone_number']; ?></td>
												<td>Active</td>
												<td nowrap="nowrap"><a href="javascript:deleteNumber('<?=$value['ph_id']?>','<?=$value['phone_number']?>','view_phone_numbers.php','delete_number')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a></a>
														  
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
