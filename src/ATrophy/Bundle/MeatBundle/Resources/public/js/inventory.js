var inventory = (function(ext){

	var inventory, cell, inventoryButton, addonsCost, popUp, notify, body;

	function init(){

		inventory = $("#inventory");
		inventoryButton = $("#toggleInventory");
		addOnsCost = $("#addonsCost");
		popUp = $("[id^=addOnPop]");
		notify = $("#notify");
		body = $("body");

		inventoryButton.on("click", toggleInventory);

		inventory.on("click", ".cell", getAddOn)
				.on("click", ".sendAddOn", sendAddOn)
                .on("change", "input[type=radio]", sendAddOn)
				.on("click", ".deleteAddOn", deleteAddOn)
				.on("change", "#addOnFile", showFile)
				.on("click", "#addOnPopUpOverlay, .close", closePopUp);
	}
    function toggleInventory(e){
        e.preventDefault();

        var el = $(e.target), text;

        if(inventory.hasClass("isActive")){

            text = el.data("open");
            el.text(text);
            inventory.removeClass("isActive");
        } else{

            text = el.data("close");
            el.text(text);
            inventory.addClass("isActive");
        }
    }
	function getAddOn(e){

		if(!$(e.target).hasClass("deleteAddOn")){

			cell = $(this);

			var path = $(this).data("path"),
				info = $(this).data("info");

			ext.loader(notify);
			notify.addClass("isActive");

			$.post(path, info, function(response, textStatus, xhr){
				response = $.parseJSON(response);
				
				popUp.filter("#addOnPopUp").html(response.tabs);
				
				ext.tabs();
				popUp.find(".addOnContent").jScrollPane();
				openPopUp();
			})
			.fail(function(error){

				openPopUp();
				popUp.filter("#addOnPopUp").html(error.responseText);

                counter = popUp.find(".counter");

                timerRun(function(time){

                    counter.html(time);
                    if(time === 0){
                        closePopUp();
                    }
                });
			})
			.always(function(){
				notify.removeClass("isActive");
			});
		}
		return false;
	}
	function sendAddOn(e){

		var form = inventory.find("#addOnForm"),
			path = form.attr("action"),
			formData = new FormData(form[0]),
			progressBar = $("#progressBar"),
			progress = $("#progress"),
            counter, file = '';

		ext.loader(notify);
		notify.addClass("isActive");

		if($(this).hasClass("sendAddOn")){
			e.preventDefault();	

			ext.mergeData(formData, $(this));

            file = form.find("input[type=file]");

            if(file.length > 0 && file.val() !== '') {
                progressBar.addClass("isActive");
                ext.progress(function (percent) {
                    progress.css({"width": percent + "%"});
                });
            }
		}

		ext.sender(path, formData).done(function(response){
			response = $.parseJSON(response);

			cell.html(response.cellView);
			addOnsCost.html(response.addOnsCost);

			disableRelatedAddOn();

			closePopUp();
		})
		.fail(function(error){

			openPopUp();
			popUp.filter("#addOnPopUp").html(error.responseText);

            counter = popUp.find(".counter");

            timerRun(function(time){

                counter.html(time);
                if(time === 0){
                    closePopUp();
                }
            });
		})
		.always(function(){
			notify.removeClass("isActive");
		});
	}
	function deleteAddOn(e){

		if($(e.target).hasClass("deleteAddOn")){

			var el = $(e.target),
				path = el.data("path"),
				info = el.data("info");

            cell = el.closest(".cell");

			ext.loader(notify);
			notify.addClass("isActive");

			$.post(path, info, function(response, textStatus, xhr){
				response = $.parseJSON(response);

                if(cell.hasClass("topToken") || cell.hasClass("statuette")){
                    activateRelatedAddOn();
                }

				cell.html(response.cellView);

				typeof(response.addOnsCost) === "string" ? addOnsCost.html(response.addOnsCost) : addOnsCost.empty();
			})
			.fail(function(error){

				openPopUp();
				popUp.filter("#addOnPopUp").html(error.responseText);
			})
			.always(function(){
				notify.removeClass("isActive");
			});
		}
	}
	function disableRelatedAddOn(){

		cell.hasClass("statuette") ? cell.siblings(".topToken").addClass("disable") : cell.siblings(".statuette").addClass("disable");
	}
	function activateRelatedAddOn(){

		inventory.find(".cell.disable").removeClass("disable");
	}
	function openPopUp(){
		
		popUp.addClass("isActive");
		popUp.on("transitionend oTransitionEnd webkitTransitionEnd", function(){
			body.css({"overflow": "hidden"});
		});
	}
	function closePopUp(){
		if($(this).closest("#addOnPopUp").length > 0) return;

		popUp.removeClass("isActive");
		popUp.on("transitionend oTransitionEnd webkitTransitionEnd", function(){
			body.css({"overflow": "visible"});
		});
	}
	function showFile(){
		$(this).addClass("isActive");
		$(this).parent().find("label[for=addOnFile]").html("Выбран: " + $(this).val());
	}
    function timerRun(callback){

        var timer, counter = 5;

        timer = setInterval(function(){

            (counter > 0) ? counter-- : clearInterval(timer);
            callback(counter);

        }, 1000);
    }
	return{
		init: init
	}
}(extensions));
