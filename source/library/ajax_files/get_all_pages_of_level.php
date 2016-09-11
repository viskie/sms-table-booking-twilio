<?
	session_start();
	$level=$_REQUEST['level'];
	require_once("../pageObject.php");
	header('Content-type: application/json');
	$pageObject=new PageManager();
	$allPages=$pageObject->getAllPagesOfLevelBelow($level);
	$allPagesNames=array();
	$i=0;
	foreach($allPages as $Page)
	{
		$allPagesNames[$i]["page_id"]=$Page['page_id'];
		$allPagesNames[$i]["title"]=$Page['title'];
		$i++;	
	}
	echo "{\"pages\":".json_encode($allPagesNames)."}"

?>
