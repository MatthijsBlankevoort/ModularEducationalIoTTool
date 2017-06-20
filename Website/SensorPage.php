<?php
              require_once('config.php');
              require_once('database.php');

              if(isset($_COOKIE['Sensor_Type']))
              {
              	$device = ($_COOKIE['Device1']);
              	$stmt = $con_db->prepare("SELECT Sensor_Type FROM Sensor where Device_Device_ID = '$device';");
              	$stmt->execute();
              	$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
              	if (isset($result[0]))
              	{
              		$Sensor_Selected = ($result[0]);
              		setcookie('Sensor_Type', $Sensor_Selected, time()+60*60*24);
					header("Location: SensorPageSelected.php");              	
				}
              	else
              	{
              		header("Location: SensorPageSelected.php"); 
              	}
              }
			  else
			  {
				  header("Location: SensorPageSelected.php"); 
			  }
?>