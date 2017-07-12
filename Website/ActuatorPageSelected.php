<!DOCTYPE html>
<html>
<head>
<!-- Links for CSS, JS, fonts and bootstrap. -->
    <title>Actuator Page</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet prefetch' href='http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

</head>
<body>
<!-- JavaScript for debug purposes. -->
    <script>
    function actuator(){
    if($('#radio_button_id')[0].checked) {
       alert('Nothing is checked!');
    }
    else {
       alert('One of the radio buttons is checked!');
    }
    }
    </script>
    <!-- Bootstrap navbar. -->
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
                    <li class="active"><a href="ActuatorPage.php">Actuators</a></li>
                    <li><a href="VisualizationPage.php">Visualizations</a></li>
                    <li><a href="ConfigurationPage.php">Configurations</a></li>
                    <li><a href="api.php?logout=1">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>


<!-- Bootstrap container for responsive website. -->
<div class="container">
<!-- Header showing the selected Actuator. -->
  <h1 class="sensorTitle">Actuator Device:</h1>
          <div class="row">
          <!-- PHP that echoes the selected actuator that's saved in the Cookies. -->
            <?php
			if(isset($_COOKIE['Actuator_Type']) and ($_COOKIE['Device2']))
			{
				$Actuator_Type = ($_COOKIE['Actuator_Type']);
				$device = ($_COOKIE['Device2']);
				if(isset($_COOKIE['Actuator_Type']))
				{	  
					
					echo("<h2><center>Currently selected for device $device: $Actuator_Type</h2>");
              	}
              	else
              	{
              		echo("<h1><center>No Sensor device selected for device $device</h1>");
              	}
			}
            ?>
            <!-- GET request that select the selected sensor module.  -->
		<form method="GET" action="api.php" onsubmit="actuator()">
		    <div class="form-group form-center text-center loginForm">
              <section class="sensorButtons">

                  <?php
                              require_once('config.php');
                              require_once('database.php');


                              $stmt = $con_db->prepare("select Actuator_Type from Actuator where Actuator_active = '0';");
                              // Next fire the sql statmend at the db with the first device.
                              $stmt->execute();
                              //store the results in the form of an string in result and filter only the first colum out
                              $result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

                              // PHP script that echoes radiobuttons with all of the non active sensors of the database.
                              for($i = 0; $i < ($stmt->rowCount()); $i++)
                              {
                  				echo('<div class="radioSensor">');
                  				echo('<input type="radio"');
                  				echo('id="');
                                  echo($result[$i]);
                                  echo('"');
                                  echo('name=actuator');
                  				echo(" value=");

                  				echo($result[$i]);
                  				echo('>');
                                  echo('<label class="sensorButton" for="');
                  				echo($result[$i]);
                                  echo('">');
                                  echo($result[$i]);
                  				echo('</div>');

                              }
                  ?>

                </section>
		                <input type="text" name="actuatorpage" value="1" style="visibility:hidden;" />
		                <button type="submit" value="Submit" class="btn btn-block btn-primary btn-lg">Submit</button>
              </div>
        </form>
    </div>
  </div>
</body>
</html>
