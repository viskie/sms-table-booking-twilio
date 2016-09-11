<?
//Vishak  - 04/March/2013
//for group management
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

require_once('Config.php');

class LanguageManager extends commonObject
{
	
	function getModules()
	{
		$qry1 = "select page_id, title from pages where level=1 or level=2 and is_active=1";
		$modules = getData($qry1);
		$menuEntry['page_id'] = 1;
		$menuEntry['title'] = "Menu";
		$modules[] = $menuEntry;
		//echo "<pre>"; print_r($modules);exit;
		createComboBox("module_list", "page_id", "title", $modules, true, "","","","onChange = \"getModuleFields()\"");
	}
	
	function getModuleFields($moduleId)
	{
		$qry1 = "select * from language_details where module_id='".$moduleId."' order by position_id";
		$moduleFields = getData($qry1);
		$moduleFieldArray = array();
		foreach($moduleFields as $key=>$value)
		{
			$moduleFieldArray[$value['position_id']][$value['language_id']] = $value['value'];
		}
		
		return  $moduleFieldArray;
	}	
	
	function getTotalLanguages()
	{
		$query1 = "select * from language_master";
		$allLanguages = getData($query1);
		$languageArray = array();
		for($i=0;$i<sizeof($allLanguages);$i++)
		{
			$languageArray[$allLanguages[$i]['id']] =  $allLanguages[$i]['language_name'];
		}
		return $languageArray;
	}
	
	function updateLanguageString($moduleId, $positionId, $languageId, $value)
	{
		$chkQry = "select count(*) from language_details where module_id = '".$moduleId."' and language_id='".$languageId."' and position_id='".$positionId."'";
		$countOfRow = (int)getData($chkQry);
		$updateQry = "";
		if($countOfRow >= 1)
		{	$updateQry = "insert into language_details set value ='".$value."', module_id = '".$moduleId."', language_id='".$languageId."', position_id='".$positionId."'";
		}
		else
		{
			$updateQry = "update language_details set value ='".$value."' where module_id = '".$moduleId."' and language_id='".$languageId."' and position_id='".$positionId."'";
		}
		
		updateData($updateQry);
	}
}

?>