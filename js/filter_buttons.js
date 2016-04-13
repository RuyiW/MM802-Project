function clear_func(){
	var checkboxes = document.getElementsByTagName('input');
	//var checked_value = null;
	var checked_value = [];
    for (var i = 0; i < checkboxes.length; i++){
 		if(checkboxes[i].checked){
 			checkboxes[i].disabled = false;
 			checkboxes[i].checked = false;
 		}
 	}
 	$('#testing_div').load('dataset/clear_tables.php');
}


$(document).ready(function(){
	console.log('is here');
	$("#clear_button").click(function(){
		console.log('before');
		clear_func();
	});
});


function reload_page(){
	$('#testing_div').load('dataset/copyCheckedResults.php');
	//clear_func();
	location.reload();
}


