<?php
            if(isset($_COOKIE['Actuator_Type']))
			{
              	require_once('config.php');
              	require_once('database.php');

              	$device = ($_COOKIE['Device2']);
              	$stmt = $con_db->prepare("SELECT Actuator_Type FROM Actuator where Device_Device_ID = '$device';");
              	$stmt->execute();
              	$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
              	if (isset($result[0]))
              	{
              		$Actuator_Selected = ($result[0]);
              		setcookie('Actuator_Type', $Actuator_Selected, time()+60*60*24);
              		header("Location: ActuatorPageSelected.php");              	

              	}
              	else
              	{
              		header("Location: ActuatorPageSelected.php");  
              	}
            }
			else
			{
				header("Location: ActuatorPageSelected.php");  
			}
				
            ?>