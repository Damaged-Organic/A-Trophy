var search = (function(loader){

	function init(){
		
		var searchWidget = $(".search"),
			popUp = $("#searchPopUp"),
            form = popUp.find("#searchForm");

		searchWidget.on("click", function(event){
			event.preventDefault();
			
			$(this).toggleClass("isActive");
			popUp.toggleClass("isActive");
		});
        popUp.on("click", ".close", function(event){

            searchWidget.removeClass("isActive");
            popUp.removeClass("isActive");
        });
        form.validate({
            errorPlacement: function(error, element){
                return false;
            },
            submitHandler: function(form){

                $(form).submit();
            }
        });

	}
	return{
		init: init
	}
}(extensions.loader));
