<?php 
	require_once('config.php');
	require_once('database.php');
	$sensor_id = $_COOKIE['Sensor_ID'];
	$stmt = $con_db->prepare("select * from Sensor_Log where Sensor_ID = $sensor_id ORDER BY Sensor_Timestamp DESC limit 1;");
	$stmt->execute();
	$sensorValue = (int)$stmt->fetch(PDO::FETCH_COLUMN, 0);
	echo json_encode($sensorValue);
 ?>