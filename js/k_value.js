function pass_k_value(ele){
	var value;
	if(ele.id == "value_for_neighbour"){
		value = ele.value;
		$('#empty_div').load('ProjNNneighbour.php?k_value=' +value);
		document.getElementById("value_for_days").value = 0;
		document.getElementById("value_for_day_neighbour").value = 0;
		document.getElementById("value_for_distance").value = 0;
		document.getElementById("days_output").value = 0;
		document.getElementById("day_neighbour_output").value = 0;
		document.getElementById("distance_output").value = 0;
		console.log("value_for_neighbour");
		console.log(value);
		//location.reload();
	}
	else if(ele.id == "value_for_days"){
		value = ele.value;
		var nei_value = document.getElementById('value_for_day_neighbour').value;
		$('#empty_div').load('ProjNNdays.php?day_value=' +value+ '&k_value=' +nei_value);
		document.getElementById("value_for_neighbour").value = 0;
		document.getElementById("value_for_distance").value = 0;
		document.getElementById("neighbour_output").value = 0;
		document.getElementById("distance_output").value = 0;
		console.log("value of days");
		console.log(value);
	}
	else if(ele.id == "value_for_day_neighbour"){
		value = ele.value;
		var day_value = document.getElementById('value_for_days').value;
		$('#empty_div').load('ProjNNdays.php?day_value=' +day_value+ '&k_value=' +value);
		document.getElementById("value_for_neighbour").value = 0;
		document.getElementById("value_for_distance").value = 0;
		document.getElementById("neighbour_output").value = 0;
		document.getElementById("distance_output").value = 0;
		console.log("value_for_day_neighbour");
		console.log(value);
	}
	else if(ele.id == "value_for_distance"){
		value = ele.value;
		$('#empty_div').load('ProjNNdistance.php?distance_value=' +value);
		document.getElementById("value_for_neighbour").value = 0;
		document.getElementById("value_for_days").value = 0;
		document.getElementById("value_for_day_neighbour").value = 0;
		document.getElementById("neighbour_output").value = 0;
		document.getElementById("days_output").value = 0;
		document.getElementById("day_neighbour_output").value = 0;
		console.log("value of distance");
		console.log(value);
	}


}

function setTab(m,n){
	//console.log("in the setTab function");
 	var n_t=document.getElementById("nav_tab"+m);
 	var tli=n_t.getElementsByTagName("li");
 	//console.log(tli);
 	var r_s=document.getElementById("result_showing"+m);
 	var mli=r_s.getElementsByTagName("ul");
 	//console.log(tli.length);
	for(i=0;i<tli.length;i++){  
		//console.log("in the for loop");
	  	tli[i].className=i==n?"active":"";
	  	mli[i].style.display=i==n?"block":"none";
	}
}
