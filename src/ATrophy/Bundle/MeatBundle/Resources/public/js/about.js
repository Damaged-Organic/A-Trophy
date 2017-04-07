var about = (function(){

	function init(){

		var sections = $(".row").not(".first"),
			sectionsY = [],
			wyCoord = 0; 

		sectionsY = getOffset(sections);

		$(window).scroll(function(event){

			wyCoord = $(this).scrollTop();

			if(wyCoord > sectionsY[0] / 4){
				sections.eq(0).addClass("scrolled");
			}
			if(wyCoord > sectionsY[1] / 2.75){
				sections.eq(1).addClass("scrolled");
			}
			if(wyCoord > sectionsY[2] / 1.5){
				sections.eq(2).addClass("scrolled");
			}
		});
	}
	function getOffset(el){

		var tmp = [];

		el.each(function(index, el){

			tmp[index] = $(this).offset().top;
		});
		return tmp;
	}
	return{
		init: init	
	}	
}());