<?
session_start();
require_once("../languageObject.php");
$languageObject = new LanguageManager();

$moduleId = $_REQUEST['moduleId'];
$positionId = $_REQUEST['positionId'];
$numLang = (int)$_REQUEST['numLang'];
$languageVal = array();

for($i=1;$i<=$numLang;$i++)
{
	$languageVal[$i]['id'] = $_REQUEST['langId_'.$i];
	$languageVal[$i]['value'] = $_REQUEST['langId_'.$i.'_val'];
	$languageObject->updateLanguageString($moduleId, $positionId,$languageVal[$i]['id'], $languageVal[$i]['value']);
}
?>