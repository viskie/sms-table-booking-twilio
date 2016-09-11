<?php 
require_once('library/pageObject.php');
$pageObject = new PageManager();
require_once('library/groupObject.php');
$groupObject= new GroupManager();		

switch($function){
			case "show_data":
				$data['allPages'] = $pageObject->getAllPages();
				
			break;
			
			case "show_add_page":
				$has_access = has_access($current_page_id,"add");
				if($has_access == true){
					$show_parent_page_div=false;
					$page = "add_new_page.php";
				}else
				{
					$no_access = true;	
				}	
			break;
			
			case "add_page":
				$has_access = has_access($current_page_id,"add");
				if($has_access == true){
					$pageVariables = $pageObject->getPageVariables();
					if(!$pageObject->isPageExist($pageVariables['page_name'],$pageVariables['level'])){
						$pageObject->insertPage($pageVariables);
						$notification = "Page Added Successfully!";
					}else{
						$data['pageDetails']=$pageObject->getPageVariables();
						$is_exist=true;
						$page="add_new_page.php";
					}
				}else
				{
					$no_access = true;	
				}						
			break;
			
			case "edit_page":
			case "copy_page":
				$_SESSION['page_id']=$_REQUEST['page_id'];
				$show_parent_page_div=false;
				$checked="checked=\"checked\"";
				if($function=="edit_page"){
					$is_edit=true;
				}
				if($is_exist){
					$pageDetails['page_id']=$_REQUEST['page_id'];
				}else{
					$pageId=$_SESSION['page_id'];
					$pageDetails=$pageObject->getPageDetails($pageId);
				}
				$data['pageDetails'] = $pageDetails;
				unset($_SESSION['page_id']);
				
				if($is_edit || $is_exist){
					if($pageDetails['level']==2 || $pageDetails['level']==3 || $pageDetails['level']==4){
						$show_parent_page_div=true;
						$data['show_parent_page_div'] = $show_parent_page_div;
						$data['allParentPages']=$pageObject->getAllPagesOfLevelBelow($pageDetails['level']-1);
					}
				}		
				$page="add_new_page.php";
			break;
			
			case "edit_page_entry":
				$has_access = has_access($current_page_id,"edit");
				if($has_access == true){
					$pageVariables = $pageObject->getPageVariables();
					$pageVariables['page_id']=$_REQUEST['page_id'];
					$pageObject->updateUsingId($pageVariables);
					$data['allPages']=$pageObject->getAllPages();
					$notification = "Page Updated Successfully!";
				}else
				{
					$no_access = true;	
				}
			break;
			
			case "delete_page":
				$has_access = has_access($current_page_id,"delete");
				if($has_access == true){
					$page_id=$_REQUEST['page_id'];
					$pageObject->deleteUsingId($page_id);
					$data['allPages']=$pageObject->getAllPages();
					$notification = "Page Deleted Successfully!";
				}else
				{
					$no_access = true;	
				}	
			break;
		}
		
?>