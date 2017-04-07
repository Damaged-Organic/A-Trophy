var editor = (function(){

	function init(areas){

		var editor,
			tools,
			container,
			textarea;

		areas.each(function(){
			
			tools = $(this).find(".toolbar").get(0);
			container = $(this).find(".container").get(0);
			textarea = $(this).find("textarea");

			editor = new Quill(container, {
				modules: {
					"toolbar": {
						"container": tools
					},
					"link-tooltip": true,
					"image-tooltip": true,
				},
				theme: "snow"
			});
			editor.on("text-change", function(delta, source){

				textarea.html(editor.getHTML());
			});
		});
	}
	return{
		init: init
	}

}());