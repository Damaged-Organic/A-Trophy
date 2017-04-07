var extensions = (function(){

	return{
		loader: function(el){

			var loader = "<div class='loader'>\
				<span class='fa fa-spinner'></span>\
			</div>";

			el.html(loader);
		},
		tabs: function(callback){

			var el = $(".tabs");

			el.each(function(index, el){

				var labels = $(this).find(".label"),
					conents = $(this).find("li"),
					current = 0;

				labels.eq(current).addClass("active");
				conents.eq(current).addClass("active");

				labels.click(function(event){
					event.preventDefault();

					current = $(this).index();

					labels.removeClass("active").eq(current).addClass("active");
					conents.removeClass("active").eq(current).addClass("active");

					if(typeof(callback) === "function"){
						callback($(this).parent(".tabs"), current);
					}
				});
			});
		},
		sender: function(url, data){
			return $.ajax({
				url: url,
				type: "POST",
				data: data,
				contentType: false,
				processData: false
			});
		},
		progress: function(callback){
			var orgXHR = $.ajaxSettings.xhr;

			$.ajaxSettings.xhr = function(){
				var xhr = orgXHR(), percents = 0;

				if(xhr.upload){
					xhr.upload.addEventListener("progress", function(event){
						if(event.lengthComputable){
							percents = (event.loaded / event.total) * 100;
							callback(percents);
						}
					}, false);
				}
				return xhr;
			}
		},
		mergeData: function(formData, fileList){
			$.each(fileList, function(index, val){
				formData.append("files["+index+"]", val);
			});
			return formData;
		}
	}	
}());