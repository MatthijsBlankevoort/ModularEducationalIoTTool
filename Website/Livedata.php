<!DOCTYPE html>
<html>
<head>
	<title>Live Data</title>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.css">  
<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.js"></script>
</head>
<body>

	<div id="chart"></div>
	<!-- <script type="text/javascript" src="livedata.js"></script> -->

<?php 

	require_once('config.php');
	require_once('database.php');
  
	$stmt = $con_db->prepare("select * from Sensor_Log where Sensor_ID = '001' ORDER BY Sensor_Timestamp DESC limit 4;");
	// Next fire the sql statmend at the db with the first device.
	$stmt->execute();
	//store the sensorValues in the form of an string in sensorValue and filter only the first colum out
	$startSensorValue = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        $stmt = $con_db->prepare("select * from Sensor_Log where Sensor_ID = '001' ORDER BY Sensor_Timestamp DESC limit 4;");
    // Next fire the sql statmend at the db with the first device.
    $stmt->execute();
    $startTimestamp = $stmt->fetchAll(PDO::FETCH_COLUMN, 1);

	$stmt = $con_db->prepare("select * from Sensor_Log where Sensor_ID = '001' ORDER BY Sensor_Timestamp DESC limit 1;");
	$stmt->execute();
	$sensorValue = $stmt->fetch(PDO::FETCH_COLUMN, 0);

        $stmt = $con_db->prepare("select Sensor_Timestamp from Sensor_Log where Sensor_ID = '001' ORDER BY Sensor_Timestamp DESC limit 1;");
    $stmt->execute();
    $timestamp = $stmt->fetch(PDO::FETCH_COLUMN, 0);



?>
<!-- 
<script type="text/javascript">

	console.log(testarray);
</script> -->

<script type="text/javascript">

	
    console.log(<?php echo json_encode($startTimestamp);?>);
	var chart = c3.generate({
    data: {
        x: 'x',
        xFormat: '%Y-%m-%d %H:%M:%S', 
        columns: [
            ['x', <?php echo json_encode($startTimestamp); ?>[3], <?php echo json_encode($startTimestamp); ?>[2], <?php echo json_encode($startTimestamp); ?>[1], <?php echo json_encode($startTimestamp); ?>[0]],
            ['test', <?php echo json_encode($startSensorValue); ?>[0], <?php echo json_encode($startSensorValue); ?>[1], <?php echo json_encode($startSensorValue); ?>[2], <?php echo json_encode($startSensorValue); ?>[3]],
        ]
    },
    axis: {
        x: {
            type: 'category',
            tick: {
                format: '%Y-%m-%d %H:%M:%S',
            }
        }
    },


})
;


// console.log(<?php echo json_encode($timestamp)?>);
setInterval(function () {
var timestamp = <?php echo json_encode($timestamp)?>;

    chart.flow({
        columns: [
            ['x', timestamp],
            ['test', <?php echo json_encode($sensorValue); ?>],
        ],
        duration: 1000,
    });
     timestamp = timestamp + 1000;
}, 2000);

</script>

</body>
</html>