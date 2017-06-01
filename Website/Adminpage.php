<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
          
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  <script type="text/javascript" src="Dashboard.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Oleo+Script" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <title>Home Page</title>
</head>
<body>
    <nav class="navbar navbar-inverse">
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
                    <li class="active"><a href="Dashboard.html">Dashboard</a></li>
                    <li><a href="SensorPage.php">Sensors</a></li>
                    <li><a href="ActuatorPage.php">Actuators</a></li>
                    <li><a href="VisualizationPage.php">Visualizations</a></li>
                    <li><a href="ConfigurationPage.html">Configurations</a></li>
					<li><a href="api.php?logout=1">Logout</li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
                <div class="col-xs-12 col-md-6 btn-align-center mouseovertest" >
                        <a>
                            <button class="btn btn-danger mybtn-lg button1" type="button" id="stopsensor">
                            <i class="fa fa-ban fa-10x" aria-hidden="true"></i><span class="invisible sensortext">Stop sensors</span><hr><span class="test sensortext">Stop sensors</span></button>
                        </a>
                    </div>   
                    <div class="col-xs-12 col-md-6 btn-align-center mouseovertest" >
                        <a>
                            <button class="btn mybtn-lg btn-danger button2" type="button" id="stopactuator"><i class="fa fa-ban fa-10x" aria-hidden="true"></i><span class="invisible actuatortext">Stop actuators</span><hr><span class=" actuatortext test">Stop actuators</span></button>
                        </a>
                    </div>
            </div> 
    </div>
</body>
</html>