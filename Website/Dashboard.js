
$(document).ready(function(){
	$(".button1").mouseover(function(){
		$(".button1 i").toggleClass("invisible");
		$(".button1 span").toggleClass("invisible");
		$(".button1 hr").toggleClass("invisible");
	});
	$(".button1").mouseout(function(){
		$(".button1 i").toggleClass("invisible");
		$(".button1 span").toggleClass("invisible");
		$(".button1 hr").toggleClass("invisible");
	});
	$(".button2").mouseover(function(){
		$(".button2 i").toggleClass("invisible");
		$(".button2 span").toggleClass("invisible");
		$(".button2 hr").toggleClass("invisible");
	});
	$(".button2").mouseout(function(){
		$(".button2 i").toggleClass("invisible");
		$(".button2 span").toggleClass("invisible");
		$(".button2 hr").toggleClass("invisible");
	});
	$(".button3").mouseover(function(){
		$(".button3 i").toggleClass("invisible");
		$(".button3 span").toggleClass("invisible");
		$(".button3 hr").toggleClass("invisible");
	});
	$(".button3").mouseout(function(){
		$(".button3 i").toggleClass("invisible");
		$(".button3 span").toggleClass("invisible");
		$(".button3 hr").toggleClass("invisible");
	});
	$(".button4").mouseover(function(){
		$(".button4 i").toggleClass("invisible");
		$(".button4 span").toggleClass("invisible");
		$(".button4 hr").toggleClass("invisible");
	});
	$(".button4").mouseout(function(){
		$(".button4 i").toggleClass("invisible");
		$(".button4 span").toggleClass("invisible");
		$(".button4 hr").toggleClass("invisible");
	});
	$("#stopsensor").click(function(){
		$("#stopsensor").toggleClass("btn-success");
		$("#stopsensor").toggleClass("btn-danger");
		$("#stopsensor i").toggleClass("fa-play");
		$("#stopsensor i").toggleClass("fa-ban");
			$("#stopsensor .sensortext").text(function(i, v){
				return v === 'Start sensors' ? 'Stop sensors' : 'Start sensors';
			});
		});
	$("#stopactuator").click(function(){
		$("#stopactuator").toggleClass("btn-success");
		$("#stopactuator").toggleClass("btn-danger");
		$("#stopactuator i").toggleClass("fa-play");
		$("#stopactuator i").toggleClass("fa-ban");
		// $("#stopactuator .actuatortext").toggle();
		$("#stopactuator .actuatortext").text(function(i, v){
			return v === 'Start actuators' ? 'Stop actuators' : 'Start actuators';
		});
	});
});
