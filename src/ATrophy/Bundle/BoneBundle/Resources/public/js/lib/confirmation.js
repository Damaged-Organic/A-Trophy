var confirm = (function(){

	var defaults = {
		el: $(".confirm"),
		area: $(".confirmArea"),
		isConfirmed: false
	}

	function initialize(){

		defaults.el.on("click", toggleConfirmArea);
		defaults.area.on("click", ".choose", confirmChoice);
	}
	function toggleConfirmArea(e){
		e.preventDefault();

		defaults.current = $(this);
		defaults.area.toggleClass("isActive");
	}
	function confirmChoice(e){

		defaults.isConfirmed = $(e.target).data("choice");
		defaults.isConfirmed ? redirect() : closeConfirmArea();
	}
	function redirect(){
		window.location = defaults.current.attr("href");
	}
	function closeConfirmArea(){
		defaults.area.removeClass("isActive");
	}
	return{
		init: initialize
	}

}());