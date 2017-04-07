var addToCart = (function(loader){

	function init(){

		var form = $("#addToCart"),
			checkboxs = form.find("input[type=checkbox]"),
			button = $("button[form=addToCart]"),
			checked;

        checkboxs.change(function(event){

            checked = getChecked(form);
            setPrice(checked);

            if(checked.length > 0){
                button.prop("disabled", false);
            } else{
                button.prop("disabled", true);
            }
        });
	}
	function getChecked(el){

		return el.find("input[type=checkbox]:checked");
	}
	function setPrice(el){

		var unitCost = $("#unitCost"),
			price = getPrice(el);

        if(parseFloat(price) > 0){
            unitCost.html("Цена: <span class='stableSize orange'>"+ price +" UAH</span>");
        } else{

            unitCost.html("От: <span class='stableSize orange'>"+ unitCost.data("default-price") +"</span>");
        }
	}
	function getPrice(el){

		var price = 0;

		el.each(function(){		
			price += parseFloat($(this).val()).toFixed(2) * 100;
		});
		return parseFloat(price / 100).toFixed(2);
	}
	return{
		init: init
	}
}(extensions.loader));
