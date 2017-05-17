
$(document).ready(function(){
	$("button").mouseover(function(){
		$(this.getElementsByTagName("i")).toggleClass("invisible");
		$(this.getElementsByTagName("span")).toggleClass("invisible");
		$(this.getElementsByTagName("hr")).toggleClass("invisible");
	});
	$("button").mouseout(function(){
		$(this.getElementsByTagName("i")).toggleClass("invisible");
		$(this.getElementsByTagName("span")).toggleClass("invisible");
		$(this.getElementsByTagName("hr")).toggleClass("invisible");
	});
});
