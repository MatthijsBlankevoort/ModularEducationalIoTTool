<!DOCTYPE html>
<html>
<head>
    <title>Configuration Page</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">


    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="style.css"/>
    <script type="text/javascript" src="Dashboard.js"></script>

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
                    <li><a href="api.php?logout=1">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
            <div class="container">   
                <div class="row">
                    <div class="col-md-6 col-xs-12 btn-align-center">
                        <a href="SensorPage.php">
                            <button class="btn btn-primary mybtn-lg button1" type="button" id="test">
                            <i class="fa fa-info-circle fa-10x" aria-hidden="true"></i><span class="invisible"></span><hr><span class="test"><?php echo json_encode($_COOKIE['Sensor_Type']);?></span></button>
                        </a>
                    </div>

                    <div class="col-md-6 col-xs-12 btn-align-center">
                        <a href="ActuatorPage.php">
                            <button class="btn btn-primary mybtn-lg button1" type="button" id="test">
                            <i class="fa fa-info-circle fa-10x" aria-hidden="true"></i><span class="invisible"></span><hr><span class="test"><?php echo json_encode($_COOKIE['Actuator_Type']);?></span></button>
                        </a>   
                    </div>

                </div>
            </div>




</body>
</html>