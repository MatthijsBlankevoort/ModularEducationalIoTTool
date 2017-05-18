<!DOCTYPE html>
<html>
<head>
    <title>Visualization Page</title>
    <link rel="stylesheet" type="text/css"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="style.css"/> 
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.css">  
    <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css"/>
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

</head>

<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="Dashboard.html">IoT Workshop</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="Dashboard.html">Dashboard</a></li>
                    <li><a href="SensorPage.php">Sensors</a></li>
                    <li><a href="ActuatorPage.php">Actuators</a></li>
                    <li class="active"><a href="VisualizationPage.php">Visualizations</a></li>
                    <li><a href="ConfigurationPage.php">Configurations</a></li>
                    <li><a href="api.php?logout=1">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>


    <div id="chart"></div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<?php 
    require_once('config.php');
    require_once('database.php');

    $sensor_id = $_COOKIE['Sensor_ID'];

    $stmt = $con_db->prepare("select * from Sensor_Log where Sensor_ID = '$sensor_id' ORDER BY Sensor_Timestamp DESC limit 4;");
    // Next fire the sql statmend at the db with the first device.
    $stmt->execute();
    //store the sensorValues in the form of an string in sensorValue and filter only the first colum out
    $startSensorValue = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        $stmt = $con_db->prepare("select * from Sensor_Log where Sensor_ID = '$sensor_id' ORDER BY Sensor_Timestamp DESC limit 4;");
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