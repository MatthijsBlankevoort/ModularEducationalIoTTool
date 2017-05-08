<?php 
	require_once('config.php');
	require_once('database.php');

	$stmt = $con_db->prepare("select * from Sensor_Log where Sensor_ID = '001' ORDER BY Sensor_Timestamp DESC limit 1;");
	$stmt->execute();
	$sensorValue = (int)$stmt->fetch(PDO::FETCH_COLUMN, 0);
	echo json_encode($sensorValue);

    $stmt = $con_db->prepare("select Sensor_Timestamp from Sensor_Log where Sensor_ID = '001' ORDER BY Sensor_Timestamp DESC limit 1;");
    $stmt->execute();
    $timestamp = $stmt->fetch(PDO::FETCH_COLUMN, 0);
    // echo json_encode($timestamp);
 ?>