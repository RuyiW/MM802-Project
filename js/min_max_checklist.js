
/*
$(document).ready(function(){
	$("#min_max").click(function(){
		if($(this).html() == "-"){
			$(this).html("+");
		}
		else{
			$(this).html("-");
		}
		$("#checklist_content").slideToggle();
	});
});
*/

function activateMaxMin(elemButton,elemMax,elemBox)
{

  var isclass = elemButton.attr('class');
    if (isclass == "max") 

    {
        elemMax.attr("src","./img/plus-78.png");
        elemButton.removeClass('max');
		elemBox.hide("slow");
    }
    else{
        elemButton.addClass('max');
        elemMax.attr("src","./img/minus-78.png");
        elemBox.show("slow");
    }
    //elemBox.slideToggle();

}
$(document).ready(function(){
	$("#checklist_content").hide();
	$("#button").click(function(){
		activateMaxMin($(this),$("#max"),$("#checklist_content"));

	});
});

$(document).ready(function(){
	$("#service_category").hide();
	$("#f1_button").click(function(){
		activateMaxMin($(this),$("#max_f1"),$("#service_category"));

	});
});

$(document).ready(function(){
	$("#ward").hide();
	$("#f2_button").click(function(){
		activateMaxMin($(this),$("#max_f2"),$("#ward"));

	});
});

$(document).ready(function(){
	$("#neighbourhood").hide();
	$("#f3_button").click(function(){
		activateMaxMin($(this),$("#max_f3"),$("#neighbourhood"));

	});
});

$(document).ready(function(){
	$("#request_status").hide();
	$("#f4_button").click(function(){
		activateMaxMin($(this),$("#max_f4"),$("#request_status"));

	});
});

$(document).ready(function(){
	$("#month").hide();
	$("#f5_button").click(function(){
		activateMaxMin($(this),$("#max_f5"),$("#month"));

	});
});

$(document).ready(function(){
	$("#bylaw_year").hide();
	$("#f6_button").click(function(){
		activateMaxMin($(this),$("#max_f6"),$("#bylaw_year"));

	});
});

$(document).ready(function(){
	$("#complaint").hide();
	$("#f7_button").click(function(){
		activateMaxMin($(this),$("#max_f7"),$("#complaint"));

	});
});

$(document).ready(function(){
	$("#bylaw_status").hide();
	$("#f8_button").click(function(){
		activateMaxMin($(this),$("#max_f8"),$("#bylaw_status"));

	});
});