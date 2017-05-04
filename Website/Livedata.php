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
  
	$stmt = $con_db->prepare("select * from Sensor_Log where Sensor_ID = '001' ORDER BY Sensor_Timestamp limit 4;");
	// Next fire the sql statmend at the db with the first device.
	$stmt->execute();
	//store the results in the form of an string in result and filter only the first colum out
	$startresult = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

	$stmt = $con_db->prepare("select * from Sensor_Log where Sensor_ID = '001' ORDER BY Sensor_Timestamp limit 1;");
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_COLUMN, 0);
?>
<!-- 
<script type="text/javascript">

	console.log(testarray);
</script> -->

<script type="text/javascript">

	console.log(<?php echo json_encode($startresult); ?>);
	var chart = c3.generate({
    data: {
        x: 'x',
        columns: [
            ['x', '2012-12-28', '2012-12-29', '2012-12-30', '2012-12-31'],
            ['test', <?php echo json_encode($startresult); ?>[0], <?php echo json_encode($startresult); ?>[1], <?php echo json_encode($startresult); ?>[2], <?php echo json_encode($startresult); ?>[3]],
        ]
    },
    axis: {
        x: {
            type: 'timeseries',
            tick: {
                format: '%m/%d',
            }
        }
    },


});

var date = new Date ("2013-01-01");
setInterval(function () {

    chart.flow({
        columns: [
            ['x', new Date (date)],
            ['test', <?php echo json_encode($result); ?>],
        ],
        duration: 750,
    });
    date.setDate(date.getDate() + 1);
}, 2000);

</script>

</body>
</html>