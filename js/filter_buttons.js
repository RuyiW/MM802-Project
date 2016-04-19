/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// This script is for filter buttons. 
// After user clicking "clear selection" button, the page calls clear_func() to reset the checkboxes and calls
// clear_tables.php file in dataset folder. 
// After user clicking "submit selection" button, the page calls reload_page() to call copyCheckedResults.php to 
// make a copy of the result table for map to display results. Then clear the tables, reset the checkboxes and 
// refresh the page for displaying.
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function clear_func(){
	var checkboxes = document.getElementsByTagName('input');
	var checked_value = [];
    for (var i = 0; i < checkboxes.length; i++){//for each checkbox
 		if(checkboxes[i].checked){//if it is checked
 			checkboxes[i].disabled = false; //enable it 
 			checkboxes[i].checked = false;// and uncheck it
 		}
 	}
 	$('#testing_div').load('dataset/clear_tables.php');
}


$(document).ready(function(){
	$("#clear_button").click(function(){
		clear_func();
	});
});


function reload_page(){
	$('#testing_div').load('dataset/copyCheckedResults.php');
	clear_func();
	location.reload();
}


