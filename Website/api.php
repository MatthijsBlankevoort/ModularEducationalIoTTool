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
			header("Location: Dashboard.html"); 
			setcookie('Device1', $_GET['Device1'], time()+60*60*24);
            setcookie('Device2', $_GET['Device2'], time()+60*60*24);
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
// Update config set at the website and send to database
if(isset($_GET['deviceId']) && isset($_GET['configuratie']))
{
	$DeviceID       = ($_GET['deviceId']);
	$ConfigID		= ($_GET['configuratie']);
	

	$stmt = $con_db->prepare("UPDATE Device SET Configuratie_ID = '$ConfigID' WHERE Device_ID = '$DeviceID';");
		if ($stmt->execute())
		{
			echo 'Done Update';
		}
		else
		{
			echo 'nope';
		}
}
//Get variables from sensor NodeMCU
//Todo make an if() for url of actuator which only sends ID, actuatorID, function
if(isset($_GET['deviceId']) && isset($_GET['deviceFunctie']) && isset($_GET['sensorId']) && isset($_GET['value']))
{
	$deviceID       = ($_GET['deviceId']);
	$deviceFunctie  = ($_GET['deviceFunctie']);//of het een sensor of actuator is. todo: geef elke cat. sensor een bepaalde ID
	$sensorId       = ($_GET['sensorId']);
	$value          = ($_GET['value']);
	
	//Todo: Controleer of deviceID bestaat in database zo ja dan... x
   
	$stmt = $con_db->prepare("Select Device_ID from Device where Device_ID = ?");
	if($stmt->execute([$_GET['deviceId']]))
	{
		
	
	$result = $stmt->fetch(PDO::FETCH_OBJ);
	// print_r ($result->Device_ID);
	
	
		if ($result->Device_ID == ($_GET['deviceId']))
		{
		// echo 'deviceID';
			if($deviceFunctie == "sensor") 
			{  
			//Todo: Haal threshold uit database op basis van ID, en functie ?
			$threshold = 11; 
			// echo $threshold;

			$stmt = $con_db->prepare("select Last_Sensor_Data,Sensor_Timestamp from Sensor_Log, Sensor where Sensor_Log.Sensor_ID = '$sensorId' 
									and Sensor.Sensor_ID = '$sensorId' and Device_Device_ID = '$deviceID' 
									order by Sensor_Timestamp ");
			if ($stmt->execute())
				// if there are more than 20 entrys update the oldest entry
				if($stmt->rowCount() > 20) {
					$stmt = $con_db->prepare("UPDATE Sensor_Log,Sensor SET Sensor_Timestamp = now(),Last_Sensor_Data = '$value'
											WHERE Sensor_Timestamp=(select min(Sensor_Timestamp) from (select * from Sensor_Log) 
											temp1 where temp1.Sensor_ID = '$sensorId') and Device_Device_ID = '$deviceID'"
											);
					if ($stmt->execute())
					{
						echo 'done update';
					}
					else
					{
						echo 'No Update is progrest. make sure all the things are in order';
						echo ($sensorId);
						echo ($deviceID);
					}
				}
				// else insert a new data entry
				else
				{
					$stmt = $con_db->prepare("insert into Sensor_Log (Sensor_ID,Sensor_Timestamp,Last_Sensor_Data) value ('$sensorId',now(),'$value')");
					if ($stmt->execute())
					{
						echo 'done insert';
					}
					else
					{
						echo 'nope';
					}
				}
			}	

		///////////////////////////////////////////////////////////////////////////////////////////////////////
			//if ($stmt->execute(['Sensor_Log', 'Sensor_ID', 'Sensor_Timestamp', 'Last_Sensor_Data', $sensorid2, 'now()', $value2]))
			// $stmt = $con_db->prepare("insert into Sensor_Log (Sensor_ID,Sensor_Timestamp,Last_Sensor_Data) value ('$sensorId',now(),'$value')");
		///////////////////////////////////////////////////////////////////////////////////////////////////////
			if($deviceFunctie == "actuator") 
			{

			//Todo: Haal configuratie uit database op basis van ID, en functie
			//select * from Sensor_Log where Sensor_ID = 001 ORDER BY Sensor_Timestamp DESC LIMIT 20;
			$stmt = $con_db->prepare("select Last_Sensor_Data from Sensor_Log, Sensor where Sensor_Log.Sensor_ID = '$sensorId' and Sensor.Sensor_ID = '$sensorId' and Device_Device_ID = '$deviceID' 
									  order by Sensor_Timestamp Limit 1");	
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
			$SensorValue = $result['0'];
			$stmt = $con_db->prepare("Select Configuratie_ID from Device where Device_ID = '$deviceID'; ");
			if ($stmt->execute())
			{
				$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
				$configuratie = ($result['0']);
			}
			else
			{
				echo 'No Configuratie_ID from database call';
			}
			
			$response = $configuratie . ',' . $SensorValue;
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
		echo ('Device ID not in database unable to insert data');
		}
	}
	else
	{
		echo('Unable to Contact database');
	}
}
	
if (isset($_POST['sensorpage']))
{
	

$stmt = $con_db->prepare("Select Sensor_type from Sensor where Sensor_active = '1';");
// Next fire the sql statmend at the db with the first device.
$stmt->execute();
//store the results in the form of an string in result and filter only the first colum out
$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

for($i = 0; $i < ($stmt->rowCount()); $i++)
{
	
	if (($_POST['sensor']) == ($result[$i]))
	{
		
		$configuratie = $i;
		$Sensor_Type = ($result[$i]);
		$Device = strtoupper ($_COOKIE['Device1']);
			
			$stmt = $con_db->prepare("Update Sensor SET Device_Device_ID = '$Device' where Sensor_Type = '$Sensor_Type';");
			if ($stmt->execute())
			{
				$stmt = $con_db->prepare("UPDATE Device SET Configuratie_ID = '$configuratie' WHERE Device_ID = '$Device';");
				if ($stmt->execute())
				{
					echo('done');
				}
			}
			else	
			{
				echo 'Database update Error ';
			}
	}
	
	

}
			
	// switch (($_GET['Message']))
		// {
			// case 'sensor0':
				// $configuratie = 0
			// break;
		// }
}
// echo($_COOKIE['Device1']);
// echo($_COOKIE['Device2']);	
?>