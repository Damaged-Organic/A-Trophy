var rating = (function(loader){

	function init(){

		var rating = $(".rating"),
			path = rating.data("path"),
			data;

		rating.on("click", ".star", function(event){
			event.preventDefault();
			
			data = $(this).data("info");
			sendRating(rating, path, data);
		});
	}
	function sendRating(rating, path, data){

		var notify = $("#notify");

		loader(notify);
		notify.addClass("isActive");

		$.post(path, data, function(response, textStatus, xhr){
			response = JSON.parse(response);

			rating.html(response.rating);
			notify.html(response.message);
		})
		.fail(function(error){
			notify.html(error.responseText);
		})
		.always(function(){
			setTimeout(function(){
				notify.removeClass("isActive");
			}, 4000);
		});
	}
	return{
		init: init
	}

}(extensions.loader));