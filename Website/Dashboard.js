// JQuery document.ready runs the code as soon as the page is loaded.
$(document).ready(function(){
	// Fancybutton is a custom button that changes on mousehover.
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
