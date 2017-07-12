<!DOCTYPE html>
<html>
<head>
    <!-- Links for fonts, bootstrap, CSS, JS -->
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
    <!-- Bootstrap responsive navbar. -->
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
            <!-- Bootstrap responsive container -->
            <div class="container">   
                <div class="row">
                    <div class="col-md-6 col-xs-12 btn-align-center">
                    <div>
                        <!-- Sensor information button that displays the selected sensor module that is saved in the Cookie. -->
                        <a id="sensorbutton" href="" target="_blank">
                            <button class="btn btn-primary mybtn-lg button1 fancybutton" type="button" id="test">
                            <i class="fa fa-info-circle fa-10x" aria-hidden="true"></i><span class="invisible">Sensor <p>Information</p></span><hr><span class="test"><?php echo json_encode($_COOKIE['Sensor_Type']);?></span></button>
                        </a>
                        <!-- Paragraph for displaying the sensor data real time -->
                        <p id="sensordata" class="align-label darkblueborder" >
                            
                        </p>    
                    </div>
                    </div>      



                    <!-- Div for the actuator information button -->
                    <div class="col-md-6 col-xs-12 btn-align-center">
                        <div class="align-label">
                        <!-- Actuator information button that displays the selected actuator that is saved in the Cookie. -->
                        <a id="actuatorbutton" href="" target="_blank">
                            <button class="btn btn-primary mybtn-lg button1 fancybutton" type="button">
                            <i class="fa fa-info-circle fa-10x" aria-hidden="true"></i><span class="invisible">Actuator <p>Information</p></span><hr><span class="test"><?php echo json_encode($_COOKIE['Actuator_Type']);?></span></button>
                        </a>  
                        <div>
                        <!-- Form for threshold. -->
                         <form action="/api.php" method="GET" id="thresholdform">
<?php
                        // PHP that echoes the threshold as placeholder.
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
                        <!-- Button for sending the threshold to the database. -->
                            <button form="thresholdform" class="btn btn-primary"><i class="fa fa-paper-plane-o fa-3x thresholdsubmit" aria-hidden="true"></i><span class="thresholdsubmit">Submit</span></button>
                        </form> 
                        </div> 

                        </div>

                    </div>
                </div>
            </div>
            
                            <script type="text/javascript">
                            // Function that syncs the data realtime and puts it in the sensordata paragraph every 0.5 second using AJAX.
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
                            // Switch that determines what wiki page to load based on the sensor or actuator selected.
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