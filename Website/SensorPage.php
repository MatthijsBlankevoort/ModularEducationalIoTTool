<!DOCTYPE html>
<html>
<head>
    <title>Sensor Page</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</head>
<body>
        <div class="container-fluid">
            <div class="navbar-header">
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
                    <li class="active"><a href="SensorPage.php">Sensors</a></li>
                    <li><a href="ActuatorPage.php">Actuators</a></li>
                    <li><a href="VisualizationPage.html">Visualizations</a></li>
                    <li><a href="ConfigurationPage.html">Configurations</a></li>
                </ul>
            </div>
        </div>
    </nav>
	   <div class="container">
        <div class="row">
		<form method="post" action="api.php">
		<div class="form-group form-center text-center">
		<br><br><br><br><br><br><br><br>
		<label for="Device1">Sensor Device:</label>
		<p>
		
		
		<?php
          require_once('config.php');
          require_once('database.php');


            $stmt = $con_db->prepare("Select Sensor_type from Sensor where Sensor_active = '1';");
            // Next fire the sql statmend at the db with the first device.
            $stmt->execute();
            //store the results in the form of an string in result and filter only the first colum out
            $result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            
		
		
            for($i = 0; $i < ($stmt->rowCount()); $i++)
            {
				
				echo('<input type="radio" name=sensor');
				
				echo(" value=");
				
				echo($result[$i]);
				echo('>');
				echo($result[$i]);
				echo('<p>');
				

            }
			

        ?>
		<input type="text" name="sensorpage" value="1" style="visibility:hidden;" />
		<button type="submit" value="Submit" class="btn btn-block btn-primary btn-lg">Submit</button>
		</form>
		</div>
    </div>
</body>
</html>