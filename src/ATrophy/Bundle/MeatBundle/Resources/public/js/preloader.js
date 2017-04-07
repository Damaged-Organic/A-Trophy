var preloader = (function(window){

	function init(){
		
		$(window).load(function(){
			var preloader = $("#preloader"),
				path = preloader.find("path"),
                isLoader = $.cookie("loader") || false;

            if(!isLoader){
                preloader.addClass("animation");

                setTimeout(function(){
                    preloader.removeClass("animation").addClass("fill");
                    setTimeout(function(){
                        preloader.addClass("complete");
                        finish(800);
                    }, 500);
                }, 2500);

            } else {
                finish(0);
            }

			function finish(time){
				setTimeout(function(){
					preloader.remove();
                    $.cookie("loader", 'done');
				}, time)
			}
		});
	}
	return{
		init: init
	}

}(window));