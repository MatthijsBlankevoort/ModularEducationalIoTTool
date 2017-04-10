<!doctype html>
<title>IoT Workshop</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="main.css">
<link href="https://fonts.googleapis.com/css?family=Maven+Pro" rel="stylesheet">
<div class="middle-container">
  <div>
    <h1 class="text-center">Welcome one and all!</h1>
	
<?php
  require_once('config.php');
  require_once('database.php');
  
if (isset($_GET['Start'])) 
{
	$stmt = $con_db->prepare("Select Sensor_type from Sensor where Sensor_active = '1';");
	// Next fire the sql statmend at the db with the first device.
	$stmt->execute();
	//store the results in the form of an string in result and filter only the first colum out
	$result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
	print_r($result);
	for($i = 0; $i < ($stmt->rowCount()); $i++) 
	{
		echo $result[$i];
		echo ('<br>');
		
	}
			
}
?>	
	
	
    <form method="get" action="api.php">
       <div class="text-center">
      </div>
    </form>
  </div>
</div>