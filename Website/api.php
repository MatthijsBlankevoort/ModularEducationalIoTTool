<?php
// O hi there I did not see you there.
// if you are reading this it means you have successfully opened the Api file.
// Well prepare for a beautiful trip through the wonders of the “Brain” behind the webpage.
// So, take a seed, buckle your seedbed and prepare for a trip through the works of the Api file.
// O and one more thing: this file is made by team IOT Workshop Healthcare mid 2017


/////////////////////////////////////////////////////
//Get the php files loaded before doing snizzel
  require_once('config.php');
  require_once('database.php');
/////////////////////////////////////////////////////

  
//Make sure the Devices are in the Database
if(isset($_GET['Device1']) && isset($_GET['Device2']))
{
	$Device1 = strtoupper ($_GET['Device1']);
	$Device2 = strtoupper ($_GET['Device2']);
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
	// if there is no device1
	if ($result1 == NULL)
		{
			header("Location: LoginPage.php?Message=1");
			exit;
		}
	// if there is no device2
	elseif ($result2 == NULL)
		{
			header("Location: LoginPage.php?Message=2");
			exit;
		}
	//if input device1 = device2
	elseif (($_GET['Device1']) == ($_GET['Device2']))
		{
			header("Location: LoginPage.php?Message=3");
			exit;
		}
	// if device1 != device1 from database or device2 != device2 
	elseif (($result1->Device_id) != $Device1 || (($result2->Device_id) != $Device2))
		{
			header("Location: LoginPage.php?Message=4");
			exit;
		}
	// if device 1 matches device 1 from database and same for device2
	elseif ((($result1->Device_id) == ($Device1)) && (($result2->Device_id) == ($Device2)))
		{
			// Now we will build up a connection betwean 2 devices in order to later know what sensor is connected to a partner device
			// todo clean sql querys and handeling of errors
			// see if device 1 is in the devicelink database
			$stmt = $con_db->prepare("select Device1 from DeviceLink where device1 = '$Device1';");
			$stmt->execute();
			$result1 = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
			
			// see if device 2 is in the devicelink database
			$stmt = $con_db->prepare("select Device2 from DeviceLink where device2 = '$Device2';");
			$stmt->execute();
			$result2 = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
			
			// see if device 1 is in the devicelink database and if its not already linked to aunother device
			$stmt = $con_db->prepare("select Device1 from DeviceLink where device1 = '$Device2';");
			$stmt->execute();
			$result3 = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

			// see if device 2 is in the devicelink database and if its not already linked to aunother device
			$stmt = $con_db->prepare("select Device2 from DeviceLink where device2 = '$Device1';");
			$stmt->execute();
			$result4 = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
			
			// for debug
			// {
			// print_r($result1);
			// print_r($result2);
			// print_r($result3);
			// print_r($result4);
			// }
			
			// if device 1 and device 2 have a result in them it means there is a entry of that device in the database
			if ((isset($result1[0])) && (isset($result2[0])))
			{
				// if device 1 matches device 1 from database and same for device2
				if ($result1[0] == $Device1 && $result2[0] == $Device2)
				{
				// set a cookie for device1 and device2 for easy access
				setcookie('Device1', $Device1, time()+60*60*24);
				setcookie('Device2', $Device2, time()+60*60*24);
				// also check to see if Sensor_Type and Actuator_Type cookies are set. if so continue else pull them from the database and store them in a cookie
				// make sure that if there is a entry in the database for the device it means that the devices are already set and we need that data
				// if its not set in the database well than dont do anything
				if ((!isset($_COOKIE['Sensor_Type'])) || (!isset($_COOKIE['Actuator_Type'])))
				{
					// select in the databse the sensor id and sensor type and sore them
					$stmt = $con_db->prepare("select Sensor_Type,Sensor_ID from Sensor where Device_Device_ID = '$Device1'");
					$stmt->execute();
					$result1 = $stmt->fetchAll();
					if($stmt->rowCount() > 0) 
					{
						$Sensor_Type = ($result1[0][0]);
						$Sensor_ID = ($result1[0][1]);
						setcookie('Sensor_Type', $Sensor_Type, time()+60*60*24);
						setcookie('Sensor_ID', $Sensor_ID, time()+60*60*24);
					}
					// select in the database the actuator type,actuator id and threshold and sore them in cookies
					$stmt = $con_db->prepare("select Actuator_Type,Actuator_ID,Threshold from Actuator where Device_Device_ID = '$Device2'");
					$stmt->execute();
					$result2 = $stmt->fetchAll();
					if($stmt->rowCount() > 0) 
					{
						$Actuator_Type = ($result2[0][0]);
						$Actuator_ID = ($result2[0][1]);
						$Threshold = ($result2[0][2]);

						setcookie('Actuator_Type', $Actuator_Type, time()+60*60*24);
						setcookie('Actuator_ID', $Actuator_ID, time()+60*60*24);
						setcookie('Threshold', $Threshold, time()+60*60*24);
					}
					// done ? oke then go ahead to the dashboard
					header("Location: Dashboard.html");
				}
				// all cookies set? oke go the dashboard
				header("Location: Dashboard.html");
				exit;
				}
				// make sure that if there is an entry it is the correct device and same for device2
				elseif ($result1[0] == $Device2)
				{
					echo("Device 1 Already set in Database");
					header("Location: LoginPage.php?Message=6");
				}
				elseif ($result2[0] == $Device1)
				{
					echo("Device 2 Already set in Databse");
					header("Location: LoginPage.php?Message=7");
				}
				
			}
			// handel all the diverent results if entrys are not empty but 1 is filled
			elseif (!empty($result1))
			{
				echo("Device 1 Already set in Database");
			}
			elseif (!empty($result2))
			{
				echo("Device 2 Already set in Databse");
			}
			elseif (!empty($result3))
			{
				echo("Device 2 Already set in Database");
			}
			elseif (!empty($result4))
			{
				echo("Device 1 Already set in Databse");
			}
			// but if there are no entrys in in both the results it means it not yet in the database and we can insert it
			elseif ((!isset($result1[0])) && (!isset($result2[0])))
			{
				$stmt = $con_db->prepare("Insert into DeviceLink (Device1,Device2) Value ('$Device1','$Device2');");
				if($stmt->execute())
				{
					// o and since we creat a new link in the databse we don't have a actuator or a sensor conencted to either one of the devices so no need to search for them
					setcookie('Device1', $Device1, time()+60*60*24);
					setcookie('Device2', $Device2, time()+60*60*24);
					header("Location: Dashboard.html");
					exit;
					
				}
				else
				{
				echo("Unable to insert into database");
				}
				echo("else");
			}

		}
	 else
		{
			header("Location: LoginPage.php?Message=8");
			exit;
		}
        
	

}
// are you going already? well then if you realy want to we need to make sure you never where here in the first place
if(isset($_GET['logout']))
{
	// disconnect the sensor from the device
	if (isset($_COOKIE['Sensor_ID']))
	{
		$Sensor_IDtoupdate = ($_COOKIE['Sensor_ID']);
		$stmt = $con_db->prepare("Update Sensor SET Sensor_active = '0', Device_Device_ID = 'Standby' where Sensor_ID = '$Sensor_IDtoupdate';");
		$stmt->execute();
	}
	// disconnect the actuator from the device
	if (isset($_COOKIE['Actuator_ID']))
	{
		$Actuator_IDtoupdate = ($_COOKIE['Actuator_ID']);
		$stmt = $con_db->prepare("Update Actuator SET Actuator_active = '0', Device_Device_ID = 'Standby' where Actuator_ID = '$Actuator_IDtoupdate';");
		$stmt->execute();
	}
	// delete the link of the devices from the databse to make them avalible for connection again
	if ((isset($_COOKIE['Device1'])) && (isset($_COOKIE['Device2'])))
	{
		$Device1 = ($_COOKIE['Device1']);
		$Device2 = ($_COOKIE['Device2']);
		$stmt = $con_db->prepare("Delete Device1,Device2 from DeviceLink where Device1 = '$Device1' and Device2 = '$Device2';");
		$stmt->execute();
	}
//	 cookies? O are you still here? just delete all the cookies we have stored or give them to the cookie monster i dont care.
//                _  _
//              _/0\/ \_
//     .-.   .-` \_/\0/ '-.
//    /:::\ / ,_________,  \
//   /\:::/ \  '. (:::/  `'-;
//   \ `-'`\ '._ `"'"'\__    \
//    `'-.  \   `)-=-=(  `,   |
//        \  `-"`      `"-`   /

	$past = time() - 3600;
	foreach ( $_COOKIE as $key => $value )
	{
		setcookie( $key, $value, $past, '/' );
	}
	
	header("location: LoginPage.php");
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
if (isset($_GET['deviceId']) && isset($_GET['deviceFunctie']))
{
	$Device = ($_GET['deviceId']);
	$DeviceFunction = ($_GET['deviceFunctie']);
	if($DeviceFunction == 'sensor')
	{
		$stmt = $con_db->prepare("select Sensor_ID from Sensor where Device_Device_ID = '$Device'");
		if ($stmt->execute())
		{
			$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
			if($stmt->rowCount() > 0) 
			{
				echo($result[0]);
			}
			else
			{
				echo('0');
			}
		}
	}
	elseif($DeviceFunction == 'actuator')
	{
		$stmt = $con_db->prepare("select Actuator_ID from Actuator where Device_Device_ID = '$Device'");
		if ($stmt->execute())
		{
			$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
			if($stmt->rowCount() > 0) 
			{
				echo($result[0]);
			}
			else
			{
				echo('0');
			}
		}
	}
	else
	{
		echo('Unknown Function');
	}
}
//127.0.0.1/api.php?deviceId=TEST2&deviceFunctie=actuator&sensorId=001&value=1
// deviceId=TEST2
// deviceFunctie=actuator
// sensorId=001
// value=1 if deviceFuntion is sensor de value is a must but if its an actuator it will not be used
if(isset($_GET['deviceId']) && isset($_GET['deviceFunctie']) && isset($_GET['sensorId']) && isset($_GET['value']))
{
	$deviceID       = ($_GET['deviceId']);
	$deviceFunctie  = ($_GET['deviceFunctie']);//of het een sensor of actuator is. todo: geef elke cat. sensor een bepaalde ID
	$sensorId       = ($_GET['sensorId']);
	$value          = ($_GET['value']);
	
    // make sure that de device is in the database
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
						echo('No results Found that match sensor and Device in Database');
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

			$stmt = $con_db->prepare("SELECT Sensor_ID from Sensor where sensor_ID = '$sensorId'");
				if($stmt->execute())
					
				{
					if ($stmt->rowCount() > 0)
					{
					//Todo: Haal configuratie uit Database op basis van ID, en functie
					//select * from Sensor_Log where Sensor_ID = 001 ORDER BY Sensor_Timestamp DESC LIMIT 20;
					$stmt = $con_db->prepare("select Last_Sensor_Data,Sensor_Timestamp from Sensor_Log, Sensor where Sensor_Log.Sensor_ID = '$sensorId' 
											and Sensor.Sensor_ID = '$sensorId' 
											order by Sensor_Timestamp DESC Limit 1");	
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
						$stmt = $con_db->prepare("select Threshold from Actuator where Device_Device_ID = '$deviceID'");
							if ($stmt->execute())
							{
								if ($stmt->rowCount() < 1)
								{
									echo('No Device that matches actuator. Unable to get Threshold');
								}
								else
								{
									$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
									$Threshold = ($result['0']);
								}
							}
							else
							{
								echo 'No Threshold value from Database call';
							}
						
						$response = $configuratie . ',' . $SensorValue . ',' .$Threshold;
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
						echo('No results Found that match Actuator and Device in Database');
					}	
						
						
				}	
				else
				{
					echo('Unable to Execute search for matching device and actuator');
				}
				
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
if (isset($_GET['sensorpage']))
{
	

$stmt = $con_db->prepare("Select Sensor_type, Sensor_ID from Sensor where Sensor_active = '0';");
// Next fire the sql statmend at the db with the first device.
$stmt->execute();
//store the results in the form of an string in result and filter only the first colum out
$result0 = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
// Next fire the sql statmend at the db with the first device.
$stmt->execute();
$result1 = $stmt->fetchAll(PDO::FETCH_COLUMN, 1);
// echo('hoi');
// print_r($result0);
// print_r($result1);
for($i = 0; $i < ($stmt->rowCount()); $i++)
{
	
	// echo($result0[$i]);
	// echo($_GET['sensor']);
	if (($_GET['sensor']) == ($result0[$i]))
	{
		
		$Sensor_Type = ($result0[$i]);
		$Sensor_ID = ($result1[$i]);
		$Device = strtoupper ($_COOKIE['Device1']);
		$stmt = $con_db->prepare("select DISTINCT Sensor_Type from Sensor");
		$stmt->execute();
		$DISTINCT = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
		// print_r($DISTINCT);
		for($i = 0; $i < ($stmt->rowCount()); $i++)
		{
			// echo('test');
			// echo($i);
			if ($DISTINCT[$i] == $Sensor_Type)
			{
				$configuratie = $i + 1;
				switch(isset($Sensor_Type))
				{
					case $Sensor_Type == "Track sensor":
					$configuratie = 1;
					break;
					
					case $Sensor_Type == "Temperature sensor":
					$configuratie = 2;
					break;

					case $Sensor_Type == "PIR motion sensor":
					$configuratie = 3;
					break;
					
					case $Sensor_Type == "Heartbeat sensor":
					$configuratie = 4;
					break;
					
					case $Sensor_Type == "Sound sensor":
					$configuratie = 5;
					break;
					
					case $Sensor_Type == "Ultrasonic sensor":
					$configuratie = 6;
					break;
					
					case $Sensor_Type == "Potentiometer":
					$configuratie = 7;
					break;
					
					case $Sensor_Type == "Track sensor":
					$configuratie = 8;
					break;
					
				}
			}
		}
		// echo($configuratie);
		// echo($Sensor_Type);
		// echo($Sensor_ID);
		// echo($Device);
		if ((isset($_COOKIE['Sensor_Type'])) && ($_COOKIE['Sensor_Type'] == $Sensor_Type))
		{
				header("Location: SensorPage.php"); 
		}
		else
		{
			
			$stmt = $con_db->prepare("Update Sensor SET Device_Device_ID = '$Device', Sensor_active = '1' where Sensor_Type = '$Sensor_Type' and Sensor_ID = $Sensor_ID");
			if ($stmt->execute())
			{
				
				$stmt = $con_db->prepare("UPDATE Device SET Configuratie_ID = '$configuratie' WHERE Device_ID = '$Device';");
				if ($stmt->execute())
				{
					if (isset($_COOKIE['Sensor_ID']))
					{
						$Sensor_IDtoupdate = ($_COOKIE['Sensor_ID']);
						$stmt = $con_db->prepare("Update Sensor SET Sensor_active = '0', Device_Device_ID = 'Standby' where Sensor_ID = '$Sensor_IDtoupdate';");
						if($stmt->execute())
						{
							header("Location: SensorPage.php"); 
							setcookie('Sensor_Type', $Sensor_Type, time()+60*60*24);
							setcookie('Sensor_ID', $Sensor_ID, time()+60*60*24);
						}
					}
					else
					{
						header("Location: SensorPage.php");
						setcookie('Sensor_Type', $Sensor_Type, time()+60*60*24);
						setcookie('Sensor_ID', $Sensor_ID, time()+60*60*24);
					}
				}
			}
			else	
			{
				echo 'Database update Error ';
			}
		}
	}
	
	

}
}

if (isset($_GET['actuatorpage']))
{

$stmt = $con_db->prepare("select Actuator_Type, Actuator_ID from Actuator where Actuator_active = '0';");
// Next fire the sql statmend at the db with the first device.
$stmt->execute();
//store the results in the form of an string in result and filter only the first colum out
$result0 = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
$stmt->execute();
$result1 = $stmt->fetchAll(PDO::FETCH_COLUMN, 1);
for($i = 0; $i < ($stmt->rowCount()); $i++)
{
	// echo("actuator");
	if (($_GET['actuator']) == ($result0[$i]))
	{
		$Actuator_Type = ($result0[$i]);
		$Actuator_ID = ($result1[$i]);
		$Device = strtoupper ($_COOKIE['Device2']);
		$stmt = $con_db->prepare("select DISTINCT Actuator_Type from Actuator");
		$stmt->execute();
		$DISTINCT = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
		// print_r($DISTINCT);
		for($i = 0; $i < ($stmt->rowCount()); $i++)
		{
			// echo('test');
			// echo($i);
			if ($DISTINCT[$i] == $Actuator_Type)
			{
				$configuratie = $i + 1;
			}
		}
		if ((isset($_COOKIE['Actuator_Type'])) && ($_COOKIE['Actuator_Type'] == $Actuator_Type))
		{
				header("Location: ActuatorPage.php"); 
		}
		else
		{
			
			$stmt = $con_db->prepare("Update Actuator SET Device_Device_ID = '$Device', Actuator_active = '1' where Actuator_Type = '$Actuator_Type' and Actuator_ID = '$Actuator_ID';");
			if ($stmt->execute())
			{
				
				$stmt = $con_db->prepare("UPDATE Device SET Configuratie_ID = '$configuratie' WHERE Device_ID = '$Device';");
				if ($stmt->execute())
				{
					if (isset($_COOKIE['Actuator_ID']))
					{
						$Actuator_IDtoupdate = ($_COOKIE['Actuator_ID']);
						$stmt = $con_db->prepare("Update Actuator SET Actuator_active = '0', Device_Device_ID = 'Standby' where Actuator_ID = '$Actuator_IDtoupdate';");
						if($stmt->execute())
						{
							header("Location: ActuatorPage.php"); 
							setcookie('Actuator_Type', $Actuator_Type, time()+60*60*24);
							setcookie('Actuator_ID', $Actuator_ID, time()+60*60*24);
						}
					}
					else
					{
						header("Location: ActuatorPage.php");
						setcookie('Actuator_Type', $Actuator_Type, time()+60*60*24);
						setcookie('Actuator_ID', $Actuator_ID, time()+60*60*24);
					}
				}
			}
			else	
			{
				echo 'Database update Error ';
			}
		}
	}
	
	

}
}
if (isset($_GET['Threshold']))
{
	if (!isset($_COOKIE['Actuator_ID']))
	{
		header("Location: ConfigurationPage.php?Message=1"); // Give error No actuator set
	}
	else
	{
		$Actuator_ID = ($_COOKIE['Actuator_ID']);
		$Threshold = ($_GET['Threshold']);
		$stmt = $con_db-> prepare("update Actuator set Threshold = '$Threshold' where Actuator_ID = '$Actuator_ID';");
		if ($stmt->execute())
		{
				header("Location: ConfigurationPage.php");
				setcookie('Threshold', $Threshold, time()+60*60*24);
		}
		else
		{
			echo('Unable to Connect to the Database');
		}
	}
}
?>