$(document).ready(function(){
	hljs.initHighlightingOnLoad();

	$.fn.scroll2inner = function(elem, speed) { 
	    $(this).animate({
	        scrollTop:  ($(this).scrollTop() - $(this).offset().top + $(elem).offset().top - 50)
	    }, speed == undefined ? 1000 : speed); 
	    return this; 
	};

	$("ul#left-menu-nav").scroll2inner($("ul#left-menu-nav").find('li.active'), 0);
});