var faq = (function(){

	function init(){

		var roll = $("#roll"),
			blocks = roll.find(".item"),
			questions = roll.find(".question"),
			current;

		questions.on("click", function(event){
			event.preventDefault();
			event.stopPropagation();

			current = $(this).parent().index();
			blocks.not(":eq("+ current +")").removeClass("active").end().eq(current).addClass("active");
		});
	}
	return{
		init: init	
	}	
}());