function store_ward(ward, ele) {
	//console.log(ward);
    //var res = ward.replace("+", "");
    ward = encodeURI(ward);
    //console.log(ward);
	if(ele.checked){
	    $('#testing_div').load('dataset/store_ward.php?ward=' + ward + '&checked=1');
	    //console.log("inside function store_ward");
	}
	else{
		$('#testing_div').load('dataset/store_ward.php?ward=' + ward + '&checked=0');
	}
}

function store_service_category(service_category, ele) {
    console.log(service_category);
    service_category = service_category.replace(/&/g, 'AND');
    service_category = encodeURI(service_category);
    console.log(service_category);
    if(ele.checked){
	    $('#testing_div').load('dataset/store_service_category.php?service_category=' + service_category + '&checked=1');
	    console.log("inside function store_service_category");
	}
	else{
		$('#testing_div').load('dataset/store_service_category.php?service_category=' + service_category + '&checked=0');
	}
}

function store_311_neighbourhood(neighbourhood, ele) {
    console.log(neighbourhood);
    //var res = service_category.replace("+", "");
    neighbourhood = encodeURI(neighbourhood);
    console.log(neighbourhood);
    if(ele.checked){
	    $('#testing_div').load('dataset/store_311_neighbourhood.php?neighbourhood=' + neighbourhood + '&checked=1');
	    console.log("inside function store_311_neighbourhood");
	}
	else{
		$('#testing_div').load('dataset/store_311_neighbourhood.php?neighbourhood=' + neighbourhood + '&checked=0');
	}
}