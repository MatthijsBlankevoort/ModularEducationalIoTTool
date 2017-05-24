<!DOCTYPE html>
<html>
<head>
    <title>Actuator Page</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
        <link rel='stylesheet prefetch' href='http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'>
         <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
</head>
<body>
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
	   <div class="container">
        <div class="row">

          <label class="title" for="Device1">Actuator Device:</label>

            <?php
                if(isset($_COOKIE['Actuator_Type']))
                {
                	$Actuator_Selected = ($_COOKIE['Actuator_Type']);
                	$device = ($_COOKIE['Device2']);
                	echo("<h1><center>Currently selected for device $device: $Actuator_Selected</h1>");
                }
            ?>
        		<form method="GET" action="api.php" onsubmit="actuator()">
        		<div class="form-group form-center text-center">

            <div class="sensorButtons">

                <?php
                            require_once('config.php');
                            require_once('database.php');


                            $stmt = $con_db->prepare("select Actuator_Type from Actuator where Actuator_active = '0';");
                            // Next fire the sql statmend at the db with the first device.
                            $stmt->execute();
                            //store the results in the form of an string in result and filter only the first colum out
                            $result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);


                            for($i = 0; $i < ($stmt->rowCount()); $i++)
                            {
                				echo('<div>');
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

		          <input class="hiddenInput" type="text" name="actuatorpage" value="1" style="visibility:hidden;" />
		          <button type="submit" value="Submit" class="btn btn-block btn-primary btn-lg narrowBTN">Submit</button>
            </div>
          </form>
          </div>
    </div>
</body>
</html>
