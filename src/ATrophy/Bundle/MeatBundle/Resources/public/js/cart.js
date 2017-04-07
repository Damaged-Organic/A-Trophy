var cart = (function(loader){

	function init(){

		var list = $(".listOfGoods"),
			popUps = $(".cartPopUp"),
			form = $("#cartForm"),	
			region = $("#userRegion"),
			userPhone = $("#userPhone"),
            basketCount = $(".basket .count");

		list.on("click", ".toCartAddon", function(event){
			event.preventDefault();
			
			openPopUp(popUps);
			selecedAddOnList($(this));
		});
		list.on("click", ".actionButton", function(event){
			event.preventDefault();

            handleAction($(this), list, basketCount);
		});
        //pludge area start - do not touch this shit
        list.on("keyup", "#quantity", function(event){

            var qLabel = $(this).parent(),
                info = qLabel.data("info");

            info.quantity = parseInt($(this).val());
            qLabel.attr("data-info", JSON.stringify(info));

            handleAction(qLabel, list, basketCount);
        });
        //pludge area end - do not touch this shit
		popUps.eq(0).on("click", function(){
			closePopUp(popUps);
		});


		form.on("focus", "#userRegion", function(event){
			openPopUp(popUps);
		});
		form.on("click", "input[name=regionSelect]", function(event){

			region.val($(this).next("label").data("region"));
			closePopUp(popUps);
		});
		form.on("click", ".close, #regionOverlay", function(event){	
			closePopUp(popUps);
		});

		userPhone.mask("+380 (99) 999-99-99");
		formValidation(form);
	}
	function handleAction(el, list, basketCount){

		var path = el.data("path"),
			info = el.data("info"),
			totalPrice = $("#totalPrice > span");

		sender(path, info, function(response){

            if(!response.cartEmpty){

                if(info.action !== "remove"){

                    el.closest("tr").find("#quantity").val(response.quantity);
                    el.closest("tr").find(".summ").html(response.subtotalPrice);
                } else{

                    el.closest("tr").remove();
                }

                totalPrice.html(response.totalPrice);
            } else{

                el.closest(".inner").html(response.cartEmpty);
            }

            basketCount.html(response.totalQuantity);
		});
	}
	function selecedAddOnList(el){

		var list = $("#"+ el.data("list"));
	
		list.addClass("isActive").siblings().removeClass("isActive").end().jScrollPane();
	}
	function formValidation(form){

		var shopDelivery = form.find("#shopDelivery"),
			firm = form.find("input[name=deliveryFirm]"),
			officeNumber = form.find("#officeNumber");

		form.validate({
			errorElement: "p",
			rules: {
                'order[deliveryRegion]': {
					required: {
						depends: function(element){		
							return shopDelivery.is(":checked"); 
						}
					}	
				},
                'order[deliveryCity]': {
					required: {
						depends: function(element){		
							return shopDelivery.is(":checked"); 
						}
					}	
				},
                'order[deliveryAddress]': {
					required: {
						depends: function(element){		
							return shopDelivery.is(":checked"); 
						}
					}	
				},
				'order[deliveryService]': {
					required: {
						depends: function(element){		
							return shopDelivery.is(":checked"); 
						}
					} 
				},
				'order[serviceOffice]': {
					required: {
						depends: function(element){		
							return shopDelivery.is(":checked");
						}
					} 
				}
			}
		});
	}
	function sender(path, info, callback){

		var notify = $("#notify");

		loader(notify);
		notify.addClass("isActive");

		$.post(path, info, function(response, textStatus, xhr){			
			
			notify.removeClass("isActive");
			callback($.parseJSON(response))
		})
		.fail(function(error){

			notify.html(error.responseText);
			setTimeout(function(){
				notify.removeClass("isActive");
			}, 3000);
		});
	}
	function openPopUp(el){
		
		var body = $("body");

		el.addClass("isActive");
		el.on("transitionend oTransitionEnd webkitTransitionEnd", function(){
			body.css({"overflow": "hidden"});
		});
	}
	function closePopUp(el){

		var body = $("body");

		if($(this).closest("#regionPopUp").length > 0) return;

		el.removeClass("isActive");
		el.on("transitionend oTransitionEnd webkitTransitionEnd", function(){
			body.css({"overflow": "visible"});
		});
	}
	return{
		init: init
	}
}(extensions.loader));
