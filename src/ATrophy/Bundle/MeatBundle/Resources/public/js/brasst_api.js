;(function(root, factory){

	root.Brasst = factory(root, {});

})(this, function(root, Brasst){

	Brasst.version = "1.0.0";

	var defaultApi = "http://cheers-development.in.ua/api/ua",
		cssID = "BrasstCSS";

	function Brasst(options){

		this.container = document.getElementById("brasst_widget");

		this.api = options && options.url ? options.url : defaultApi;
		this.method = "GET";

		window.onload = this.initialize.apply(this, arguments);

		//this.initialize.apply(this, arguments);
	}
	Brasst.prototype = {
		initialize: function(){
			if(!this.container || this.checkCookie("brasstWidget")){
				this.close();
			} else{
				this.appendCSS();
				this.execute();
			}
		},
		appendCSS: function(){
			if(!document.getElementById(cssID)){
				var head = document.getElementsByTagName("head")[0],
					link = document.createElement("link");

				link.id = cssID;
				link.rel = "stylesheet";
				link.type = "text/css";
				link.href = "http://brasst.com/web/bundles/app/Meat/css/widget.css";
				link.media = "all";

				head.appendChild(link);
			}
		},
		close: function(){
			this.container.parentNode.removeChild(this.container);
		},
		setCookie: function(){
			var expires, date = new Date();

			date.setTime(date.getTime() + (7 * 24 * 60 * 60 * 1000));
			expires = "; expires=" + date.toGMTString();

			document.cookie = "brasstWidget" + "=" + "disabled" + expires + "; path=/";
			this.close();
		},
		checkCookie: function(name){
			if(document.cookie.length > 0){
				return document.cookie.match(/brasstWidget/) ? true : false;
			}
			return false;
		},
		setup: function(){
			var xhr = new XMLHttpRequest();

			if("withCredentials" in xhr){
				xhr.open(this.method, this.api + "?type=html", true);
			}
			else if(typeof XDomainRequest != "undefined"){
				xhr = new XDomainRequest();
				xhr.open(this.method, this.api + "?type=html");
			} else{
				throw new Error("CORS doesn't supported in your browser");
			}
			return xhr;
		},
		execute: function(){
			if(!this.method || !this.api) return;
			var self = this,
				xhr = this.setup();

			if(xhr){
				xhr.onload = function(e){
					if(e.target.readyState !== 4) return;
					if(e.target.status >= 200 && e.target.status < 400){
						if(!e.target.responseText) throw new Error("There is no delivered data");
						self.render(e.target.responseText);
						self.bindEvents();
					}
				}
			}
			xhr.send();
		},
		render: function(html){
			if(html){
				this.container.innerHTML = html;
			}
		},
		bindEvents: function(){
			var self = this,
				cookieButton = document.getElementById("setCookie"),
				closeButton = document.getElementById("close");

			closeButton.addEventListener("click", function(e){
				self.close();
			}, false);
			cookieButton.addEventListener("click", function(e){
				self.setCookie();
			}, false);
		}
	}
	return Brasst;
});