<?
//echo "<pre>"; print_r($data);
?>
<? if($function == 'edit_plan') { ?>
<input type="hidden" name="edit_id" id="edit_id" value="<?=$data['planDetils']['plan_id']?>" />
<? } ?>
                        <!-- Main Content -->
                        <div id="main-content">
                            
                            <!-- Messages -->
                         
                            <h2><? if($_REQUEST['function']=='edit_plan') { echo "Edit Plan"; } else { echo "Add New Plan";} ?></h2>
                            <div class="body-con">

                                    <ul class="align-list">
                                        <li>
											<label>Plan Name <span>*</span></label>
                                            <input type="text" id="plan_name" name="plan_name"  value='' />
										</li>
                                        <li>
											<label for="adduser-username">Phone Numbers <span>*</span></label>
                                            <input type="text" id="phone_numbers" name="phone_numbers"  value='' />
										</li>
                                        <li>
											<label for="adduser-username">Credits <span>*</span></label>
                                            <input type="text" id="credits" name="credits"  value='' />
										</li>
                                        
                                        <li>
											<label for="adduser-username">Type <span></span></label>
                                             <select id="type" name="type"  >
                                            <option value="main">Main</option>
                                            <option value="addon">Add On</option>
                                            </select>
										</li>
										<li>
											<li>
											<label for="adduser-username">Cost <span></span></label>
                                            <input type="text" id="cost" name="cost"  value='' />
										</li>
										<li>
											<label for="adduser-username">Is Active <span></span></label>
                                            <select id="is_active" name="is_active"  >
                                            <option value="1">Active</option>
                                            <option value="0">In-Active</option>
                                            </select>
										</li>
                                        
                                        <li>
                                            <label></label>
                                            <?  if($_REQUEST['function'] == 'edit_plan') {    ?>     
                                             <input type="button" value="Update" class="green"  onclick="return updatePlans('<?=$data['planDetils']['plan_id']?>','manage_plans.php','edit_plan_entry')" >
                                            <? } else { ?>
                                           <input type="button" value="Insert" class="green"  onclick="return addPlan('manage_plans.php','add_plan_entry')" >
                                           <? } ?>
                                        </li>
										
									</ul>
							</div>
                            
                            
                           
                           
                                <!-- END Add user form -->
                                
                           
                            
                        </div>
                        <!-- END Main Content -->
                   <?
                   if($_REQUEST['function'] == 'edit_plan') {    ?>     
                   <script type="text/javascript">
						$(document).ready( function () {
								<? foreach($data['planDetils'] as $key=>$value ) { ?>
										$('#<?=$key;?>').val('<?=$value;?>');
										
								<? } ?>	
								var one = $('#type')
								var two = $('#is_active')
	
								$.uniform.update(one);
								$.uniform.update(two);				
						});
                   </script>
                   
                   <? } ?>
                   
                   
