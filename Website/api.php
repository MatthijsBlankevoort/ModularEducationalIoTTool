<?php
/////////////////////////////////////////////////////
//Get the php files loaded before doing snizzel
  require_once('config.php');
  require_once('Database.php');
/////////////////////////////////////////////////////

  
//Make sure the Devices are in the Database
if(isset($_GET['Device1']) && isset($_GET['Device2']))
{
	$Device1 = strtoupper ($_GET['Device1']);
	$Device2 = strtoupper ($_GET['Device2']);
	// Go through all options for the selection of devices:
	// Ask the Database if the device is in there by preparing the statment first
	$stmt = $con_db->prepare("Select Device_id from Device where Device_ID = ?");
	// Next fire the sql statmend at the db with the first device.
	$stmt->execute([$_GET['Device1']]);
	//store the results in the form of an object in result1
	$result1 = $stmt->fetch(PDO::FETCH_OBJ);
	//fire the stmt again but with device 2 and store in the same way as device 1 but in result2
	$stmt->execute([$_GET['Device2']]);
	$result2 = $stmt->fetch(PDO::FETCH_OBJ);
	//create a switch in if else staments that will handele all resonsen of the Database
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
// Update config set at the website and send to Database
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
	
	//Todo: Controleer of deviceID bestaat in Database zo ja dan... x
   
	$stmt = $con_db->prepare("Select Device_ID from Device where Device_ID = '$deviceID'");
	if($stmt->execute())
	{
		
	
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
	// print_r ($result->Device_ID);
	
	
		if ($result[0] == ($deviceID))
			
		{
			
		// echo 'deviceID';
			

	
			if($deviceFunctie == "sensor") 
			{ 
				$stmt = $con_db->prepare("select Sensor_ID,Device_Device_ID from Sensor where Device_Device_ID = '$deviceID'and Sensor_ID = '$sensorId'");
				if($stmt->execute())
				{
					if ($stmt->rowCount() > 0)
					{				


					$stmt = $con_db->prepare("select Last_Sensor_Data,Sensor_Timestamp from Sensor_Log, Sensor where Sensor_Log.Sensor_ID = '$sensorId' 
											and Sensor.Sensor_ID = '$sensorId' and Device_Device_ID = '$deviceID' 
											order by Sensor_Timestamp ");
						if ($stmt->execute())
						{
							// if there are more than 20 entrys update the oldest entry
							if($stmt->rowCount() > 20) {
								$stmt = $con_db->prepare("UPDATE Sensor_Log,Sensor SET Sensor_Timestamp = now(),Last_Sensor_Data = '$value'
														WHERE Sensor_Timestamp=(select min(Sensor_Timestamp) from (select * from Sensor_Log) 
														temp1 where temp1.Sensor_ID = '$sensorId') and Device_Device_ID = '$deviceID'"
														);
								if ($stmt->execute())
								{
									echo 'Updated Sensor Record in Database';
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

					}
					else
					{
						echo('No results Fount that match sensor and Device in Database');
					}	
						
						
				}	
				else
				{
					echo('Unable to Execute search for matching device and sensor');
				}
			}
			///////////////////////////////////////////////////////////////////////////////////////////////////////
			elseif($deviceFunctie == "actuator") 
			{

			//Todo: Haal configuratie uit Database op basis van ID, en functie
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
					echo 'No Configuratie_ID from Database call';
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
			else
			{
				echo('Unknown Function');
			}

					



		}
		else
		{
			echo('Device ID not in Database unable to insert data');
		}

	}
	else
	{
		echo('Unable to Contact Database');
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
					echo('Done Update');
					header("Location: SensorPage.php"); 
					setcookie('Sensor_Type', $Sensor_Type, time()+60*60*24);
				}
			}
			else	
			{
				echo 'Database update Error ';
			}
	}
	
	

}
}

if (isset($_POST['actuatorpage']))
{

$stmt = $con_db->prepare("select Actuator_Type from Actuator where Actuator_active = '1';");
// Next fire the sql statmend at the db with the first device.
$stmt->execute();
//store the results in the form of an string in result and filter only the first colum out
$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

for($i = 0; $i < ($stmt->rowCount()); $i++)
{
	
	if (($_POST['actuator']) == ($result[$i]))
	{
		
		$configuratie = $i;
		$Actuator_Type = ($result[$i]);
		$Device = strtoupper ($_COOKIE['Device2']);
			
			$stmt = $con_db->prepare("Update Actuator SET Device_Device_ID = '$Device' where Actuator_Type = '$Actuator_Type';");
			if ($stmt->execute())
			{
				$stmt = $con_db->prepare("UPDATE Device SET Configuratie_ID = '$configuratie' WHERE Device_ID = '$Device';");
				if ($stmt->execute())
				{
					echo('Done Update');
					header("Location: ActuatorPage.php"); 
					setcookie('Actuator_Type', $Actuator_Type, time()+60*60*24);
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