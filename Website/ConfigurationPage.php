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
                </ul>
            </div>
        </div>
    </nav>
            <div class="container">   
            <div>
                
            </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12 btn-align-center">
                        <a href="SensorPage.php">
                            <button class="btn btn-primary mybtn-lg button1" type="button" id="test">
                            <i class="fa fa-info-circle fa-10x" aria-hidden="true"></i><span class="invisible">Sensor <p>Information</p></span><hr><span class="test"><?php echo json_encode($_COOKIE['Sensor_Type']);?></span></button>
                        </a>
                    </div>
                    <div class="row" id="sensordata">
                        <script type="text/javascript">
                            function getSensorData()
                            {
                                $.ajax({
                                       type: "GET",
                                       url: "Sensordata.php",
                                       data: "{}",
                                       success: function(data){
                                            
                                            var sensorData = data;
                                            document.getElementById("sensordata").innerHTML = data;
                                 }
                               });
                            }

                        
                        setInterval(getSensorData, 500);
                        </script>

                    </div>

                    <div class="col-md-6 col-xs-12 btn-align-center">
                        <a href="ActuatorPage.php">
                            <button class="btn btn-primary mybtn-lg button1" type="button" id="test">
                            <i class="fa fa-info-circle fa-10x" aria-hidden="true"></i><span class="invisible">Actuator <p>Information</p></span><hr><span class="test"><?php echo json_encode($_COOKIE['Actuator_Type']);?></span></button>
                        </a>   


                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xs-12 btn-align-center col-md-offset-6">
                            <form action="/api.php" method="GET">
                                <input type="number" name="Threshold" placeholder="threshold" class="threshold">
                            </form>           
                        </div>                
                    </div>


                </div>
            </div>




</body>
</html>