
$(document).ready(function(){
	$(".fancybutton").mouseover(function(){
		$(this.getElementsByTagName("i")).toggleClass("invisible");
		$(this.getElementsByTagName("span")).toggleClass("invisible");
		$(this.getElementsByTagName("hr")).toggleClass("invisible");
	});
	$(".fancybutton").mouseout(function(){
		$(this.getElementsByTagName("i")).toggleClass("invisible");
		$(this.getElementsByTagName("span")).toggleClass("invisible");
		$(this.getElementsByTagName("hr")).toggleClass("invisible");
	});
});
