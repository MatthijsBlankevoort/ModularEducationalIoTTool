<!DOCTYPE html>
<html>
<head>
    <title>Actuator Page</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="Dashboard.html">IoT Workshop</a>
            </div>
            <button type="button" class="navbar-toggle collapse" data-toggle="collapse"
                    data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="Dashboard.html">Dashboard</a></li>
                    <li><a href="SensorPage.php">Sensors</a></li>
                    <li class="active"><a href="ActuatorPage.php">Actuators</a></li>
                    <li><a href="VisualizationPage.html">Visualizations</a></li>
                    <li><a href="ConfigurationPage.html">Configurations</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <?php
            require_once('config.php');
            require_once('database.php');


            $stmt = $con_db->prepare("select Actuator_Type from Actuator where Actuator_active = '1';");
            // Next fire the sql statmend at the db with the first device.
            $stmt->execute();
            //store the results in the form of an string in result and filter only the first colum out
            $result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            echo('<br><br><br><br><br><br><br><br>');
            for ($i = 0; $i < ($stmt->rowCount()); $i++) {
                echo $result[$i];
                echo('<br>');

            }
            ?>
        </div>
    </div>
</body>
</html>