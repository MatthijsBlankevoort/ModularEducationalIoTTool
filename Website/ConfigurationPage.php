<!DOCTYPE html>
<html>
<head>
    <title>Configuration Page</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Oleo+Script" rel="stylesheet">


    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="style.css"/>
    <script type="text/javascript" src="Dashboard.js"></script>
    <script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>

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
                    <li><a href="VisualizationPage.php">Visualizations</a></li>
                    <li class="active"><a href="ConfigurationPage.php">Configurations</a></li>
                    <li><a href="api.php?logout=1">Logout</li>

                </ul>
            </div>
        </div>
    </nav>
            <div class="container">   
                <div class="row">
                    <div class="col-md-6 col-xs-12 btn-align-center">
                    <div>
                        <a id="sensorbutton" href="" target="_blank">
                            <button class="btn btn-primary mybtn-lg button1 fancybutton" type="button" id="test">
                            <i class="fa fa-info-circle fa-10x" aria-hidden="true"></i><span class="invisible">Sensor <p>Information</p></span><hr><span class="test"><?php echo json_encode($_COOKIE['Sensor_Type']);?></span></button>
                        </a>
                        <p id="sensordata" class="align-label darkblueborder" >
                            
                        </p>    
                    </div>
                    </div>      




                    <div class="col-md-6 col-xs-12 btn-align-center">
                        <div class="align-label">
                        <a id="actuatorbutton" href="" target="_blank">
                            <button class="btn btn-primary mybtn-lg button1 fancybutton" type="button">
                            <i class="fa fa-info-circle fa-10x" aria-hidden="true"></i><span class="invisible">Actuator <p>Information</p></span><hr><span class="test"><?php echo json_encode($_COOKIE['Actuator_Type']);?></span></button>
                        </a>  
                        <div>
                         <form action="/api.php" method="GET" id="thresholdform">
<?php
						if (isset($_COOKIE['Threshold']))
						{
							$Threshold = ($_COOKIE['Threshold']);
							echo('<input type="number" name="Threshold" placeholder="'.$Threshold.'" value="'.$Threshold.'">');
						}
						else
						{
							echo('<input type="number" name="Threshold" placeholder="threshold">');
						}
?>
                            <button form="thresholdform" class="btn btn-primary"><i class="fa fa-paper-plane-o fa-3x thresholdsubmit" aria-hidden="true"></i><span class="thresholdsubmit">Submit</span></button>
                        </form> 
                        </div> 

                        </div>

                    </div>
                </div>
            </div>
            
                            <script type="text/javascript">
                                function getSensorData()
                                {
                                    $.ajax({
                                           type: "GET",
                                           url: "Sensordata.php",
                                           data: "{}",
                                           success: function(data){
                                                
                                                var sensorData = data;
                                                document.getElementById("sensordata").innerHTML = "Sensor Value: "+data;
                                     }
                                   });
                                }

                            getSensorData();
                            setInterval(getSensorData, 500);

                            switch(<?php echo json_encode($_COOKIE['Sensor_Type'])?>){
                                case "Track sensor": $("#sensorbutton").attr("href", "https://www.dfrobot.com/wiki/index.php/Line_Tracking_Sensor_for_Arduino_(SKU:SEN0017)")
                                break;
                                case "Temperature sensor": $("#sensorbutton").attr("href", "https://wiki.eprolabs.com/index.php?title=Humidity_Sensor_DHT11")
                                break;
                                case "PIR motion sensor": $("#sensorbutton").attr("href", "https://wiki.eprolabs.com/index.php?title=PIR_Sensor")
                                break;
                                case "Heartbeat sensor": $("#sensorbutton").attr("href", "https://wiki.eprolabs.com/index.php?title=Pulse_rate_Sensor")
                                break;
                                case "Sound sensor": $("#sensorbutton").attr("href", "https://wiki.eprolabs.com/index.php?title=Sound_Detector")
                                break;
                                case "Ultrasonic sensor": $("#sensorbutton").attr("href", "https://nl.wikipedia.org/wiki/Ultrasoon_sensor")
                                break;
                                case "Potentiometer": $("#sensorbutton").attr("href", "https://en.wikipedia.org/wiki/Potentiometer")
                                break;
                                case "Light sensor": $("#sensorbutton").attr("href", "https://en.wikipedia.org/wiki/Photoresistor")
                                break;
                                default: $("#sensorbutton").attr("href", "SensorPage.php");
                            }

                            switch(<?php echo json_encode($_COOKIE['Actuator_Type'])?>){
                                case "LED": $("#actuatorbutton").attr("href", "https://nl.wikipedia.org/wiki/Led")
                                break;
                                case "Servomotor": $("#actuatorbutton").attr("href", "https://en.wikipedia.org/wiki/Servomotor")
                                break;
                                case "Buzzer": $("#actuatorbutton").attr("href", "https://en.wikipedia.org/wiki/Buzzer")
                                break;
                                default: $("#actuatorbutton").attr("href", "ActuatorPage.php");
                            }
                            </script>



</body>
</html>