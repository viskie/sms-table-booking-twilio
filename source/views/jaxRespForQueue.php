<?
$actionArrayNew = array(
						"0"=>array("display"=>"Select", "value"=>"0"),
						"1"=>array("display"=>"Accept", "value"=>"accept"),
						"2"=>array("display"=>"Ignore", "value"=>"ignore"),
					);
?>
							<div align="center" id="mainQContainer">
                                 
                                  <div class='msg-info queue_row'>
                                        <div class="queue_cell" style="width:5%"><b>No</b></div>
                                        <div class="queue_cell" style="width:20%"><b>Customer Name</b></div>
                                        <div class="queue_cell" style="width:10%"><b>Phone Number</b></div>
                                        <div class="queue_cell" style="width:10%"><b>Arrival Time</b></div>
                                        <div class="queue_cell" style="width:20%"><b>Categorize</b></div>
                                        <div class="queue_cell" style="width:20%"><b>QueueManager</b></div>
                                        <div class="queue_cell" style="width:15%"><b>Action</b></div>
                                      
                                 </div>
                                 <div style="height:5px;">
                                 &nbsp;
                                 </div>
                                  <?	$count = 0;
									   foreach($data['queue'] as $value)
									   { $count++;
									   	 $class = 'msg-ok';
									   	 if($value['status'] == '2')
										 {
											$class = 'msg-alert';
										 }
									   
										   ?>
                                          	<div class='<?=$class?> queue_row'>
                                       			<div class="queue_cell" style="width:5%"><?=$count; ?></div>
                                                <div class="queue_cell" style="width:20%"><?=$value['store_customer_name']; ?></div>
                                                <div class="queue_cell" style="width:10%"><?=$value['phone_number']; ?></div>
                                                <div class="queue_cell" style="width:10%"><?=date(" g:i a",$value['arrival_timestamp']); ?></div>
                                                <div class="queue_cell" style="width:20%">
                                                <?
													if($value['status'] != '2')
													{	echo "TBA"; }
													else
													{ 	createComboBox($value['q_id'].'_category','list_id','list_name', $data['lists'], true, "","",'',"class=\"queue_select\""); }
												?>                                                
                                                </div>
                                                <div class="queue_cell" style="width:20%">
												<?
													if($value['queue_manager_id'] == '0')
													{	echo "TBA"; }
													else
													{ 	echo $queueObject->getUserNameUsingId($value['queue_manager_id']); }
												?>
                                                </div>
                                               
												  <? if($value['status'] != '2')
													{	
														echo "<div class='queue_cell' style='width:15%;vertical-align:top'>";
														createComboBox($value['q_id'].'_action','value','display', $actionArrayNew,false,"","",'', "class=\"queue_select\" onChange= \"processQueue('".$value['q_id']."','view_queue.php','process_queue')\"");
														echo "</div>";
													}
													else
													{ 	
														echo "<div class='queue_cell' style='width:15%; padding-top:0px;'>";
														echo "<input type='hidden' name='".$value['q_id']."_action'  id='".$value['q_id']."_action' value='dispatch' />";
														echo "<button class='green' onclick=\"return processQueue('".$value['q_id']."','view_queue.php','process_queue')\">Finished</button>";
														echo "</div>";
													}
												?>  
												
                                 			</div>	
                                           						   
										   <?
									   }
									  ?>
                                 
                             </div>