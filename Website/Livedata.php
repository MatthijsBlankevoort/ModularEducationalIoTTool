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
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
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
?>

<script type="text/javascript">
   
        function getSensorData()
        {
            $.ajax({
                   type: "GET",
                   url: "Sensordata.php",
                   data: "{}",
                   success: function(data){
                        
                        var sensorData = data;
                            chart.flow({
                                columns: [  
                                    ['Sensor Value', sensorData],
                                ],
                                duration: 2000,
                            });
                            
             }
           });
        }

    
    setInterval(getSensorData, 2500); 


	var chart = c3.generate({
    data: {
        x: 'x',
        xFormat: '%Y-%m-%d %H:%M:%S', 
        columns: [
            ['x', <?php echo json_encode($startTimestamp); ?>[3], <?php echo json_encode($startTimestamp); ?>[2], <?php echo json_encode($startTimestamp); ?>[1], <?php echo json_encode($startTimestamp); ?>[0]],
            ['Sensor Value', <?php echo json_encode($startSensorValue); ?>[3], <?php echo json_encode($startSensorValue); ?>[2], <?php echo json_encode($startSensorValue); ?>[1], <?php echo json_encode($startSensorValue); ?>[0]],
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


});


</script>

</body>
</html>