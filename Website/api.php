<?php
/////////////////////////////////////////////////////
//Get the php files loaded before doing snizzel
  require_once('config.php');
  require_once('database.php');
/////////////////////////////////////////////////////

  
//Make sure the Devices are in the database
if(isset($_GET['Device1']) && isset($_GET['Device2']))
{
	$Device1 = ($_GET['Device1']);
	$Device2 = ($_GET['Device2']);
	// Go through all options for the selection of devices:
	// Ask the database if the device is in there:
	$stmt = $con_db->prepare("Select Device_id from Device where Device_ID = ?");
	$stmt->execute([$_GET['Device1']]);
	$result1 = $stmt->fetch(PDO::FETCH_OBJ);
	$stmt->execute([$_GET['Device2']]);
	$result2 = $stmt->fetch(PDO::FETCH_OBJ);	
	if ($result1 == NULL)
		{
			header("Location: index.php?Message=1");
		}
	elseif ($result2 == NULL)
		{
			header("Location: index.php?Message=2");
		}
	elseif ((($result1->Device_id) == ($_GET['Device1'])) && (($result2->Device_id) == ($_GET['Device2'])))
		{
			header("Location: index.php?Message=3"); // TODO pas aan naar hooftpagina
		}
	elseif ((($result1->Device_id) != ($_GET['Device1'])) || (($result2->Device_id) != ($_GET['Device2'])))
		{
			header("Location: index.php?Message=4");
		}
	else 
		{
			header("Location: index.php?Message=5");
		}
	

	// /* Redirect browser */
		// header("Location: index.php");
	 
		// /* Make sure that code below does not get executed when we redirect. */
		// exit;	
}
	
?>