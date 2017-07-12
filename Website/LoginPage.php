<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<!-- Links for CSS, font-awesome(icons), bootstrap and fonts -->
    <link rel="stylesheet" type="text/css" href="style.css"/>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
 	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

</head>
<body>
	<!-- Container div for responsive website -->
	<div class="container box">
	<i class="fa fa-link fa-20x" aria-hidden="true"></i>
	<div>
	<!-- Form where user fills in his Device IDs, this form sends a GET request to the api. -->
		<form method="get" action="api.php" class="loginForm">

			<?php
			// Check if the variable Message is set in the api.
				if (isset($_GET['Message']))
				{
					// Switch that echo's the error message that the API returns.
					switch (($_GET['Message']))
					{
						case '1':
							echo '<h2><font color=red><center>';
							echo 'Device 1 not found';
							echo '</h2>';
						break;

						case '2':
							echo '<h2><font color=red><center>';
							echo 'Device 2 not found';
							echo '</h2>';
						break;

						case '3':
							echo '<h2><font color=red><center>';
							echo 'Sensor Device and Actuator can not be the same';
							echo '</h2>';
						break;

						case '4':
							echo '<h2><font color=red><center>';
							echo 'Call for help (r1 != d1 or r2 != d2)';
							echo '</h2>';
						break;

						case '5':
							echo '<h2><font color=green><center>';
							echo 'when this baby hits 88 mph you are gonna see some serious shit';
							echo '</h2>';
						break;

						case '6':
							echo '<h2><font color=red><center>';
							echo 'Device 1 Already set in Database';
							echo '</h2>';
						break;

						case '7':
							echo '<h2><font color=red><center>';
							echo 'Device 2 Already set in Databse';
							echo '</h2>';
						break;

						case '8':
							echo '<h2><font color=red><center>';
							echo 'unknown error';
							echo '</h2>';
						break;

					}
				}
			?>
			<!-- Inputs for the device IDs. -->
			<div class="form-group form-center text-center loginNext">
				<div class="loginDiv">
					<h1 class="sensorTitle">Sensor Device:</h1>
					<input type="text" name="Device1" placeholder="Sensor ID">
				</div>

				<div class="loginDiv">
				<h1 class="sensorTitle">Actuator Device:</h1>
					<input type="text" name="Device2" placeholder="Actuator ID">
				</div>
			</div>
			<button type="submit" class="btn btn-block btn-primary btn-lg">Connect</button>

		</form>

	<br>
		<div>Méh. Wij gebruiken cookies. Logisch want anders doet de site het niet. Deze melding moet van de overheid. Dat zijn die lui die je nooit netjes bedanken voor die 21% btw </div>
	</div>

	</div>


</body>
</html>
