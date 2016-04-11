function pass_k_value(ele){
	var value;
	if(ele.id == "value_for_neighbour"){
		value = ele.value;
		$('#empty_div').load('ProjNNneighbour.php?k_value=' +value);
		//document.getElementById("day_value").innerHTML = value;
		console.log("value_for_neighbour");
		console.log(value);
	}
	else if(ele.id == "value_for_days"){
		value = ele.value;
		$('#empty_div').load('ProjNNdays.php?day_value=' +value);
		//document.getElementById("day_value").innerHTML = value;
		console.log("value of days");
		console.log(value);
	}
	else if(ele.id == "value_for_day_neighbour"){
		value = ele.value;
		$('#empty_div').load('ProjNNdays.php?k_value=' +value);
		//document.getElementById("day_value").innerHTML = value;
		console.log("value_for_day_neighbour");
		console.log(value);
	}
	else if(ele.id == "value_for_distance"){
		value = ele.value;
		$('#empty_div').load('ProjNNdistance.php?distance_value=' +value);
		//document.getElementById("distance_value").innerHTML = value;
		console.log("value of distance");
		console.log(value);
	}
}