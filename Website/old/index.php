<!doctype html>
<title>IoT Workshop</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="main.css">
<link href="https://fonts.googleapis.com/css?family=Maven+Pro" rel="stylesheet">
<div class="middle-container">
  <div>
    <!-- <p class="error text-center">"83FE" doesn't exist</p> -->
    <h1 class="text-center">Welcome one and all!</h1>
	
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
				echo '<h2><font color=green><center>';
				echo 'when this baby hits 88 mph you are gonna see some serious shit';
				echo '</h2>';
			break;
			
			case '4':
				echo '<h2><font color=red><center>';
				echo 'call for help (meer dan 1 in reactie van database)';
				echo '</h2>';
			break;
			
			case '5':
				echo '<h2><font color=red><center>';
				echo 'unknown error';
				echo '</h2>';
			break;
		}
	}

?>	
	
	
    <form method="get" action="api.php">
      <div class="text-center vertical-gap-50">
        <input type="text" name="Device1" placeholder="Enter ID of Board 1">
      </div>
	  <div class="text-center vertical-gap-50">
        <input type="text" name="Device2" placeholder="Enter ID of Board 2">
      </div>
      <div class="text-center">
        <button type="submit" class="std-button">Go</button>
      </div>
    </form>
  </div>
</div>
