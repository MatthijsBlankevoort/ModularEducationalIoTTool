<?php
/////////////////////////////////////////////////////
//Get the php files loaded before doing snizzel
  require_once('config.php');
  require_once('database.php');
/////////////////////////////////////////////////////

  
//Make sure the Devices are in the database
if(isset($_GET['Device1']) && isset($_GET['Device2']))
{
	$Device1 = strtoupper ($_GET['Device1']);
	$Device2 = strtoupper ($_GET['Device2']);
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
	elseif (($_GET['Device1']) == ($_GET['Device2']))
		{
			header("Location: LoginPage.php?Message=3");
			exit;
		}
	elseif (($result1->Device_id) != $Device1 || (($result2->Device_id) != $Device2))
		{
			header("Location: LoginPage.php?Message=4");
			exit;
		}
	elseif ((($result1->Device_id) == ($Device1)) && (($result2->Device_id) == ($Device2)))
		{
			header("Location: Dashboard.html"); // TODO pas aan naar dashboard
			exit;
		}
	 else
		{
			header("Location: LoginPage.php?Message=6");
			exit;
			// print_r ($result1->Device_id);
			// print ($Device1);
			// ECHO '<BR>';
			// print_r ($result2->Device_id);
			// print ($Device2);
		}
        
	

	// /* Redirect browser */
		// header("Location: index.php");
	 
		// /* Make sure that code below does not get executed when we redirect. */
		// exit;	
}

//Get variables from sensor NodeMCU
//Todo make an if() for url of actuator which only sends ID, actuatorID, function
	if(isset($_GET['deviceId']) && isset($_GET['deviceFunctie']) && isset($_GET['sensorId']) && isset($_GET['value']))
    {
        $deviceID       = ($_GET['deviceId']);
        $deviceFunctie  = ($_GET['deviceFunctie']);//of het een sensor of actuator is. todo: geef elke cat. sensor een bepaalde ID
        $sensorId       = ($_GET['sensorId']);
        $value          = ($_GET['value']);
		
    //Todo: Controleer of deviceID bestaat in database zo ja dan...
	   
	    $stmt = $con_db->prepare("Select Device_ID from Device where Device_ID = ?");
		$stmt->execute([$_GET['deviceId']]);
		$result = $stmt->fetch(PDO::FETCH_OBJ);
		// print_r ($result->Device_ID);
		
		
		if ($result->Device_ID == ($_GET['deviceId']))
		{
		// echo 'deviceID';
			if($deviceFunctie == "sensor") 
			{  
				//Todo: Haal threshold uit database op basis van ID, en functie 
				$threshold = 11; 
				// echo $threshold;

			// Todo: stuur variabelen naar de database!!!
			
			
			
			// $stmt = $con_db->prepare("INSERT INTO ? (?,?,?) VALUE (?,?,?);");
			$stmt = $con_db->prepare("insert into Sensor_Log (Sensor_ID,Sensor_Timestamp,Last_Sensor_Data) value ('$sensorId',now(),'$value')");
			if ($stmt->execute())
			// if ($stmt->execute(['Sensor_Log', 'Sensor_ID', 'Sensor_Timestamp', 'Last_Sensor_Data', $sensorid2, 'now()', $value2]))
			{
				$response1 = 1;
				echo 'done';
			}
			else
			{
				$response1 = 0;
				echo 'nope';
			}
			}
			if($deviceFunctie == "actuator") 
			{

				//Todo: Haal configuratie uit database op basis van ID, en functie
			$stmt = $con_db->prepare('select * from Sensor_Log ORDER BY Sensor_Timestamp DESC LIMIT 1');	
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
			
				// Todo: Haal laatste sensor waarde op en stuur door !!!
				$configuratie = 20;
			$response = $configuratie . ',' . $result['0'];
			echo $response;
			// echo $configuratie
			// echo $result['0'];
				// $value = 60;
				// $response = $configuratie . ',' . $dc['value'];
				// echo ($configuratie);
				// echo (",");
				// echo ($value);
				
			}


		}
		else
		{
			

		}
		
		
        
	///////////////////////////////////////////////////////
	
	
      
        
        
        
        
    }
?>