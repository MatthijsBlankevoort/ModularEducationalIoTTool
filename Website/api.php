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
	// Ask the database if the device is in there by preparing the statment first
	$stmt = $con_db->prepare("Select Device_id from Device where Device_ID = ?");
	// Next fire the sql statmend at the db with the first device.
	$stmt->execute([$_GET['Device1']]);
	//store the results in the form of an object in result1
	$result1 = $stmt->fetch(PDO::FETCH_OBJ);
	//fire the stmt again but with device 2 and store in the same way as device 1 but in result2
	$stmt->execute([$_GET['Device2']]);
	$result2 = $stmt->fetch(PDO::FETCH_OBJ);
	//create a switch in if else staments that will handele all resonsen of the database
	if ($result1 == NULL)
		{
			header("Location: LoginPage.php?Message=1");
			exit;
		}
	elseif ($result2 == NULL)
		{
			header("Location: LoginPage.php?Message=2");
			exit;
		}
	elseif ((($result1->Device_id) == ($_GET['Device1'])) && (($result2->Device_id) == ($_GET['Device2'])))
		{
			header("Location: LoginPage.php?Message=3"); // TODO pas aan naar dashboard
			exit;
		}
	elseif ((($result1->Device_id) != ($_GET['Device1'])) || (($result2->Device_id) != ($_GET['Device2'])))
		{
			header("Location: LoginPage.php?Message=4");
			exit;
		}
	else 
		{
			header("Location: LoginPage.php?Message=5");
			exit;
		}
	

	// /* Redirect browser */
		// header("Location: index.php");
	 
		// /* Make sure that code below does not get executed when we redirect. */
		// exit;	
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	
?>