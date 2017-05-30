<!DOCTYPE html>
<html>
<head>
    <title>Sensor Page</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet prefetch' href='http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'>

    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
         <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

</head>
<body>
<script>
function sensor(){
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
                    <li class="active"><a href="SensorPage.php">Sensors</a></li>
                    <li><a href="ActuatorPage.php">Actuators</a></li>
                    <li><a href="VisualizationPage.php">Visualizations</a></li>
                    <li><a href="ConfigurationPage.php">Configurations</a></li>
                    <li><a href="api.php?logout=1">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    
<div class="container1">
    <div class="row1">
          <label class="title" for="Device1">Sensor Device:</label>
            
            <?php
                if(isset($_COOKIE['Sensor_Type']))
                {
                    $Sensor_Selected = ($_COOKIE['Sensor_Type']);
                    $device = ($_COOKIE['Device1']);
                    echo("<h1><center>Currently selected for device $device: <br><br> $Sensor_Selected</h1>");
                }
            ?>

            <form method="GET" action="api.php" onsubmit="sensor()">
                <div class="form-group form-center text-center">
                    <div class="sensorButtons">
                          <?php
                                require_once('config.php');
                                require_once('database.php');

                                $stmt = $con_db->prepare("Select Sensor_type from Sensor where Sensor_active = '0';");
                                // Next fire the sql statmend at the db with the first device.
                                $stmt->execute();
                                //store the results in the form of an string in result and filter only the first colum out
                                $result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

                                    for($i = 0; $i < ($stmt->rowCount()); $i++)
                                    {
                                        echo('<div class="sensorSuperButton">');
                                            echo('<input type="radio" ');
                                            echo('id="');
                                            echo($result[$i]);
                                            echo('"');
                                            echo(' name=sensor');
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
                    </div>
                </div>
            </form>
                
		<input type="text" name="sensorpage" value="1" style="visibility:hidden;"/>
		<button type="submit" value="Submit" class="btn btn-block btn-primary btn-lg narrowBTN">Submit</button>
		</div>
    </div>
    
</body>
</html>
