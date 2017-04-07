var contacts = (function(loader){

	function init(){

		var form = $("#feedback"),
			notify = $("#notify");
		
		drawMap();
		phoneMask();

        form.validate({
            errorElement: "p",
            errorLabelContainer: notify.find(".errorBox"),
            submitHandler: function(form){

                sender($(form), notify);
            }
        });
	}
	function drawMap(){

		var canvas = $("#map"),
			coords = new google.maps.LatLng(50.3961425, 30.5015626),
			map, mapOptions, marker, markerOptions;
		
		options = {
			zoom: 16,
            minZoom: 8,
			center: coords,
			mapTypeControl: false,
			streetViewControl: false,
			zoomControl: false,
			panControl: false
		}
		map = new google.maps.Map(canvas[0], options);

		marker = new google.maps.Marker({
			position: coords,
			map: map,
			title: "Интернет-магазин «A-Trophy»"
		});
	}
	function phoneMask(){

		var phone = $("#phone");
		phone.mask("+380 (99) 999-99-99");
	}
	function sender(form, notify){

		var scsBox = notify.find(".successBox"),
			path, formData;

		notify.addClass("isActive");

        path = form.attr("action");
        formData = form.serializeArray();

        loader(scsBox);

        $.post(path, formData, function(data, textStatus, xhr){

            scsBox.html(data);
            form[0].reset();

            setTimeout(function(){
                notify.removeClass("isActive");
                scsBox.empty();
            }, 5000);
        });
	}
	return{
		init: init	
	}	
}(extensions.loader));