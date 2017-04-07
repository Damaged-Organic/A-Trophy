var filters = (function(loader){

	var isAnim = false;

	function init(){

		var filters = $("#filters"),
			clearFilter = $("#clearFilter"),
			form = $("#filterForm"),
			grid = $("#goodsGrid"),
			navigation = $(".navigation"),
			breadcrumbs = $(".breadcrumbs"),
			notify = $("#notify"),
			shown = $("#shown"),
			perPage = $("#perPage"),
			perPageLabel = null;

		rangeSlider(function(){

			sender(form, grid, navigation, breadcrumbs, notify, shown, clearFilter);
		});
		form.on("click", ":radio, :checkbox", function(event){

			sender(form, grid, navigation, breadcrumbs, notify, shown, clearFilter);
		});
		filters.on("click", ".filterButton", function(event){
			event.preventDefault();
			
			sender($(this), grid, navigation, breadcrumbs, notify, shown, clearFilter);
		});

		perPage.on("click", ".label", function(event){
			event.preventDefault();

			perPageLabel = $(this);
			$(this).parent().toggleClass("isActive");
		});
		perPage.on("click", ".quantity", function(event){
			event.preventDefault();
			
			perPageLabel.text($(this).text());
			perPageLabel.parent().removeClass("isActive");

			sender($(this), grid, navigation, breadcrumbs, notify, shown, null);
		});
	}	
	function rangeSlider(callback){

		var range = $("#priceRange"),
			inputs = range.find(".hPriceLabel"),
			minLabel = $("#priceMin"),
			maxLabel = $("#priceMax"),

			min = parseInt(range.data("min")),
			max = parseInt(range.data("max")),
			currentMin = parseInt(range.data("current-min")),
			currentMax = parseInt(range.data("currentMax"));

		range.slider({
			range: true,
			min: min,
			max: max,
			values: [currentMin, currentMax],
			slide: function(event, ui){
				minLabel.html(ui.values[0]);
				maxLabel.html(ui.values[1]);
			},
			stop: function(event, ui){
				inputs[0].value = ui.values[0];
				inputs[1].value = ui.values[1];

				callback();
			}
		});
	}
	function sender(el, grid, navigation, breadcrumbs, notify, shown, clearFilter){
		
		var path, data, result;

		if(!isAnim){
			isAnim = true;

			path = el.data("path") || el.attr("action");
			data = el.data("info") || el.serializeArray();

			loader(notify);
			notify.addClass("isActive");			

			$.post(path, data, function(response, textStatus, xhr){
				result = JSON.parse(response);
	
				grid.html(result.grid).addClass("animate");
				navigation.html(result.navigation);	
				breadcrumbs.html(result.breadcrumbs);
				shown.html(result.shown);
				notify.removeClass("isActive");

				if(clearFilter){
					clearFilter.addClass("isActive");
				}
			})
			.fail(function(error){
				notify.html(error.responseText);

				setTimeout(function(){
					notify.removeClass("isActive");
				}, 3000);
			})
			.always(function(){
	
				setTimeout(function(){
					isAnim = false;
					grid.removeClass("animate");
				}, 500);
			});
		}	
	}
	return{
		init: init
	}
}(extensions.loader));