(function($, window){

	var defaults = {
		slideTime: .8,
		slideEffect: "cubic-bezier(0.47, 0, 0.745, 0.715)",
		arrows: true,
		navigation: true,
		autoplay: true,
		autoplayTime: 5000,
		command: "photo"
	}
	function attachOptions(obj, options){
		$(obj).data("options", $.extend({}, defaults, options));
	}
	$.fn.flexy = function(options){

		attachOptions(this, options);
		
		var flexy = $(this),
			options = flexy.data("options"),
			holder = flexy.find(".flexyHolder"),
			slides = flexy.find(".flexySlide"),
			slideCount = slides.length,
			slideDim = {w: slides.innerWidth(), h: slides.innerHeight()},
			arrows = [], navigation = [], points = [],
			current = 0, position = 0, timerID = 0;

		setStyles(holder, slides, slideCount, slideDim, options.command);

		if(options.command === "goods"){
			flexy.addClass("goods");

			slideDim = {
				w: slides.outerWidth(true),
				h: slides.height()
			}
			slideCount = slideCount - Math.round(flexy.width() / slideDim.w);
		}

		if(options.navigation){
			navigation = buildNav(flexy, slideCount);

			points = navigation.find(".point");

			points.eq(current).addClass("active");

			navigation.on("click", ".point", function(event){
				current = $(this).index();
				changeSlide(holder, options, slideDim.w, current, points);
			});
		}
		if(options.arrows){
			arrows = buildArrows(flexy);

			arrows.on("click", ".arrow", function(event){

				($(this).data("direction") === "left") ? current-- : current++;
				
				current = getCurrent(current, slideCount);
				changeSlide(holder, options, slideDim.w, current, points);
			});
		}
		if(options.autoplay){
			timerID = setInterval(function(){
				current++;
				current = getCurrent(current, slideCount);
				changeSlide(holder, options, slideDim.w, current, points);
			}, options.autoplayTime);

			flexy.mouseover(function(){
				clearInterval(timerID);
			});
			flexy.mouseleave(function(){
				timerID = setInterval(function(){
					current++;
					current = getCurrent(current, slideCount);
					changeSlide(holder, options, slideDim.w, current, points);
				}, options.autoplayTime);
			});
		}	
		return this;
	};
	function changeSlide(holder, options, width, current, points){
		var transition = getPrefixed("transition"),
			transform = getPrefixed("transform"),
			position = (width * current) * -1;

		holder.css({
			transform: "translateX("+ position +"px)",
			transition: "all" + " " + options.slideTime + "s" + " " + options.slideEffect
		});
		if(options.navigation){
			points.removeClass("active").eq(current).addClass("active");
		}
	}
	function getCurrent(current, count){
		if(current < 0 || current >= count){
			current = 0;
		}
		return current;
	}
	function buildArrows(el){
		return $("<span class='flexyArrows'>").append("<span class='arrow left' data-direction='left'></span><span class='arrow right' data-direction='right'></span>").appendTo(el);
	}
	function buildNav(el, count){
		var navigation = $("<span class='flexyNavigation'/>"), points = [], i;

		for (i = 0; i < count; i++){
			points.push("<span class='point'></span>");
		}
		return navigation.append(points).appendTo(el);
	}
	function setStyles(holder, slides, count, dimension, command){
		holder.css({
			width: dimension.w * count + "px",
			height: dimension.h + "px"
		});
		slides.css({
			width: dimension.w + "px",
			height: dimension.h + "px"
		});
	}
	function getPrefixed(prop){
		var style = document.createElement("div").style,
			vendors = ['ms', 'O', 'Moz', 'Webkit'], i;

		if(style[prop] == "") return prop;

		prop = prop.charAt(0).toUpperCase() + prop.slice(1);

		for (i = 0; i < vendors.length; i++){
			if(style[vendors[i] + prop] == "") return vendors[i] + prop;
		};
	}

})(jQuery, window);