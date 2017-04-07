(function($, window){

	var PluginName = "LightBox",
		defaults = {
			slideTime: 400,
			isArrows: true
		};

	function Plugin(el, options){

		this.$el = $(el);

		this.options = $.extend({}, defaults, options);

		this._name = PluginName;
		this._defaults = defaults;

		this.initialize();
	}
	Plugin.prototype = {

		initialize: function(){

            if(this.$el.hasClass("noImage")) return;

			this.$ul = this.$el.find("ul");
			this.$li = this.$el.find("li");
			this.slideWidth = this.$li.outerWidth();
			this.slideHeight = this.$li.outerHeight();
			this.count = this.$li.length;
			this.current = 1;
			this.cycle = false;

			this.$gallery = $("#lightbox");
			this.$viewZone = this.$gallery.find(".viewZone");

			this.events();

			this.setDefaultCSS();

            if(this.count === 1) return;
			this.makeClones();
			this.showArrows();
		},
		events: function(){

			this.$el.on("click", ".arrow", $.proxy(this.slidePosition, this))
					.on("click", "li", $.proxy(this.viewGallery, this));

			this.$gallery.on("click", "li", $.proxy(this.switchPicture, this))
						.on("click", ".close", $.proxy(this.closeBox, this))
						.on("click", $.proxy(this.closeBox, this));
		},
		makeClones: function(){

			this.$li.first().before(this.$li.last().clone(false, false).addClass("cloned"));
			this.$li.last().after(this.$li.first().clone(false, false).addClass("cloned"));		
		},
		setDefaultCSS: function(){
			
			this.$li.css({
				width: this.slideWidth + "px",
				height: this.slideHeight + "px"
			});
			this.$ul.css("left", "-" + this.slideWidth * this.current + "px");
		},
		showArrows: function(){

			if(this.options.isArrows){

				this.$el.append("\
					<span class='arrow left fa fa-chevron-left'></span>\
					<span class='arrow right fa fa-chevron-right'></span>\
				");
			}
		},
		slidePosition: function(e){

			$(e.target).hasClass("left") ? this.current-- : this.current++;

			var position = this.getPosition();

			this.slide(position);
		},
		getPosition: function(){
			return this.current * this.slideWidth * -1;
		},
		slide: function(position){

			if(this.$ul.is(":animated")) return;

			this.$ul.stop(true, false).animate({"left": position + "px"}, this.options.slideTime, $.proxy(this.checkCycle, this));	
		},
		checkCycle: function(){

            this.cycle = !!(this.current < 1 || this.current > this.count);

			if(this.cycle){
				this.resetCycle();
			}	
		},
		resetCycle: function(){

            this.current = (this.current <= 0) ? this.count : 1;
			this.$ul.css({"left": this.getPosition() + "px"});
		},
		viewGallery: function(e){

			var path = $(e.currentTarget).data("path"),
				index = this.current - 1;

			this.loadImage(path, $.proxy(function(img){

				this.placePicture(img);
				this.switchActive($("li:eq("+index+")", this.$gallery));
				this.openBox();
			}, this));				
		},
		switchPicture: function(e){

			var target = $(e.currentTarget),
				path = target.data("path");

			this.loadImage(path, $.proxy(function(img){

				this.placePicture(img);
				this.switchActive(target);
			}, this));
		},
		switchActive: function(el){
			el.addClass("isActive").siblings().removeClass("isActive");
		},
		loadImage: function(path, callback){

			var image = new Image();

			image.src = path;
			$(image).load($.proxy(function(){

				callback(image);
			}, this));
		},
		placePicture: function(img){
			this.$viewZone.html(img);
			$(img).fadeIn(600);
		},
		openBox: function(){
			this.$gallery.addClass("isActive");
		},
		closeBox: function(e){

			if($(e.target).closest(".viewZone").length || $(e.target).closest(".previewZone").length) return;

			this.$gallery.removeClass("isActive");

			e.stopPropagation();
		}
	}

	$.fn[PluginName] = function(options){

		return this.each(function(){
			
			if(!$.data(this, "plugin_" + PluginName)){

				$.data(this, "plugin_" + PluginName, new Plugin(this, options));
			}
		});	
	};

})(jQuery, window);
