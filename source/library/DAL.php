<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

function Handle_Mysql_Error($sql,$err,$errno)
{
	echo($sql . "<br>" . $err . "       on   " . $errno);
	exit();
}

//function to retrive data from the database
		function getData($query) 
		{
			$query=trim($query); 
			$result = mysql_query($query) or Handle_Mysql_Error($query,mysql_error(),mysql_errno());

			$resArr = array();
			while($res = mysql_fetch_array($result,MYSQL_ASSOC)) 
			{
				if(is_array($res))
				{
					foreach($res as $key => $value)
					{
						$res[$key] = stripslashes(stripslashes($value));
					}
				}
				$resArr[] = $res;
			}
			return $resArr;
		}
		
		
//function to retrive 1 row from the database
		function getRow($query) 
		{
			$query=trim($query); 
			$result = mysql_query($query) or Handle_Mysql_Error($query,mysql_error(),mysql_errno());
			$resArr = array();
			while($res = mysql_fetch_array($result,MYSQL_ASSOC)) 
			{
				if(is_array($res))
				{
					foreach($res as $key => $value)
					{
						$res[$key] = stripslashes($value);
					}
				}
				$resArr[] = $res;
			}
			return $resArr[0];
		}
		
//function update database
		function updateData($query)
		{	$query=trim($query); 
			$result = mysql_query($query) or die(mysql_error());
		}
		
//Function to Get single value from the database
		function getOne($query)
		{	$query=trim($query); 
			$result = mysql_query($query) or Handle_Mysql_Error($query,mysql_error(),mysql_errno());
			$resArr = '';
			while($res = mysql_fetch_array($result)) 
			{
				$resArr = stripslashes($res[0]);
			}
			return $resArr;
		}
?>
