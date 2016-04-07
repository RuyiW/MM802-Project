function filter_function(){
	var checkboxes = document.getElementsByTagName('input');
	//var checked_value = null;
	var checked_value = [];
    for (var i = 0; i < checkboxes.length; i++){
 		if(checkboxes[i].checked){
 			checked_value.push(checkboxes[i].value);
 		}
	}
	show_results(checked_value);
}

function show_results(checked_value){
	for (var i = 0; i < checked_value.length; i++){
 		console.log(checked_value[i]);
	}
}


