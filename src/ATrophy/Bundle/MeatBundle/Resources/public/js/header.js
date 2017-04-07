var header = (function(){

	function init(){

		var header = $("header"),
			yCoord = $(window).scrollTop();

		if(yCoord > 70){
			header.addClass("scrolled");
		}

		$(window).scroll(function(event){
			
			yCoord = $(this).scrollTop();

			if(yCoord > 70){
				header.addClass("scrolled");
			} else if(yCoord < 70){
				header.removeClass("scrolled");
			}

		});
	}
	return{
		init: init	
	}	
}());