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
                        <a href="SensorPage.php">
                            <button class="btn btn-primary mybtn-lg button1" type="button" id="test">
                            <i class="fa fa-bullseye fa-10x" aria-hidden="true"></i><span class="invisible">Sensor</span><hr><span class="test">Sensor</span></button>
                        </a>
                    </div>   
                    <div class="col-xs-12 col-md-6 btn-align-center mouseovertest">
                        <a href="ActuatorPage.php">
                            <button class="btn mybtn-lg btn-primary button2" type="button"><i class="fa fa-lightbulb-o fa-10x" aria-hidden="true"></i><span class="invisible">Actuator</span><hr><span class="test">Actuator</span></button>
                        </a>
                    </div>
                    
                    <div class="col-xs-12 col-md-6 btn-align-center mouseovertest">
                        <a href="VisualizationPage.html">
                            <button class="btn mybtn-lg btn-primary button3" type="button"><i class="fa fa-line-chart fa-10x" aria-hidden="true"></i><span class="invisible">Visualization</span><hr><span  class="test">Visualization</span></button>
                        </a>
                    </div>
                    <div class="col-xs-12 col-md-6 btn-align-center mouseovertest">
                        <a href="ConfigurationPage.html">
                            <button class="btn mybtn-lg btn-primary button4" type="button"><i class="fa fa-cogs fa-10x" aria-hidden="true"></i><span class="invisible">Configuration</span><hr><span class="test">Configuration</span></button>
                        </a>
                    </div>
            </div> 
    </div>
</body>
</html>