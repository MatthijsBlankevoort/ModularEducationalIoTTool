<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="LoginPage.css">
</head>
<body>
	<div class="container box">
	<i class="fa fa-link fa-20x" aria-hidden="true"></i>
	<div>
		<form method="get" action="api.php">
	
<?php
if (isset($_GET['Message'])) 
	{
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
				echo '<h2><font color=green><center>';
				echo 'when this baby hits 88 mph you are gonna see some serious shit';
				echo '</h2>';
			break;
			
			case '5':
				echo '<h2><font color=red><center>';
				echo 'call for help (meer dan 1 in reactie van database)';
				echo '</h2>';
			break;
			
			case '6':
				echo '<h2><font color=red><center>';
				echo 'unknown error';
				echo '</h2>';
			break;
							

		}
	}

?>	

			<div class="form-group form-center text-center">

			<label for="Device1">Sensor Device:</label>

				<div>
					<input type="text" name="Device1" placeholder="Sensor ID">
				</div>
			<div id="Device2">
				<label for="Device2">Actuator Device:</label>

				<div>
					<input type="text" name="Device2" placeholder="Actuator ID">
				</div>
			</div>
	
			</div>
			<button type="submit" class="btn btn-block btn-primary btn-lg">Connect</button>
		</form>
		
	</div>

	</div>


</body>
</html>