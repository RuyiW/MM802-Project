/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// This script is for passing k value to corresponding algorithm calculation files. 
// After user adjust slide bar, the page reads input value, calls the pass_k_value() and pass value to algorithm files.
// There are three sections taking different input: neighbourhood, date and distance.
// While user changing slide bar for one section, slide bars in other two sections will be reset to initial value 
// (The initial value is 1).
// The setTab() function is for switching result displaying areas for map tab and table tab. 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function pass_k_value(ele){
	var value;
	if(ele.id == "value_for_neighbour"){
		value = ele.value;
		$('#empty_div').load('ProjNNneighbour.php?k_value=' +value);
		//reset the values in other sections
		document.getElementById("value_for_days").value = 1;
		document.getElementById("value_for_day_neighbour").value = 1;
		document.getElementById("value_for_distance").value = 1;
		document.getElementById("days_output").value = 1;
		document.getElementById("day_neighbour_output").value = 1;
		document.getElementById("distance_output").value = 1;
	}
	else if(ele.id == "value_for_days"){
		value = ele.value;
		var nei_value = document.getElementById('value_for_day_neighbour').value;
		$('#empty_div').load('ProjNNdays.php?day_value=' +value+ '&k_value=' +nei_value);
		//reset the values in other sections
		document.getElementById("value_for_neighbour").value = 1;
		document.getElementById("value_for_distance").value = 1;
		document.getElementById("neighbour_output").value = 1;
		document.getElementById("distance_output").value = 1;
	}
	else if(ele.id == "value_for_day_neighbour"){
		value = ele.value;
		var day_value = document.getElementById('value_for_days').value;
		$('#empty_div').load('ProjNNdays.php?day_value=' +day_value+ '&k_value=' +value);
		//reset the values in other sections
		document.getElementById("value_for_neighbour").value = 1;
		document.getElementById("value_for_distance").value = 1;
		document.getElementById("neighbour_output").value = 1;
		document.getElementById("distance_output").value = 1;
	}
	else if(ele.id == "value_for_distance"){
		value = ele.value;
		$('#empty_div').load('ProjNNdistance.php?distance_value=' +value);
		//reset the values in other sections
		document.getElementById("value_for_neighbour").value = 1;
		document.getElementById("value_for_days").value = 1;
		document.getElementById("value_for_day_neighbour").value = 1;
		document.getElementById("neighbour_output").value = 1;
		document.getElementById("days_output").value = 1;
		document.getElementById("day_neighbour_output").value = 1;
	}


}

function setTab(m,n){
 	var n_t=document.getElementById("nav_tab"+m);
 	var tli=n_t.getElementsByTagName("li");
 	var r_s=document.getElementById("result_showing"+m);
 	var mli=r_s.getElementsByTagName("ul");
	for(i=0;i<tli.length;i++){  
	  	tli[i].className=i==n?"active":"";
	  	mli[i].style.display=i==n?"block":"none";
	}
}
