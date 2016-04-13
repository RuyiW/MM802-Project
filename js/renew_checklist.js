function store_ward(ward, ele) {
	//console.log(ward);
    //var res = ward.replace("+", "");
    ward = encodeURI(ward);
    //console.log(ward);
	if(ele.checked){
	    $('#testing_div').load('dataset/store_ward.php?ward=' + ward);
	    ele.disabled = true;
	    //console.log("inside function store_ward");
	}
	else{

		// $('#testing_div').load('dataset/store_ward.php?ward=' + ward + '&checked=0');
	}
}

function store_service_category(service_category, ele) {
    //console.log(service_category);
    service_category = service_category.replace(/&/g, 'AND');
    service_category = encodeURI(service_category);
    //console.log(service_category);
    if(ele.checked){
	    $('#testing_div').load('dataset/store_service_category.php?service_category=' + service_category);
	    //console.log("inside function store_service_category");
	    ele.disabled = true;
	}
	else{
		// $('#testing_div').load('dataset/store_service_category.php?service_category=' + service_category + '&checked=0');
	}
}

function store_311_neighbourhood(neighbourhood, ele) {
    //console.log(neighbourhood);
    //var res = service_category.replace("+", "");
    neighbourhood = encodeURI(neighbourhood);
    //console.log(neighbourhood);
    if(ele.checked){
	    $('#testing_div').load('dataset/store_311_neighbourhood.php?neighbourhood=' + neighbourhood);
	    //console.log("inside function store_311_neighbourhood");
	    ele.disabled = true;
	}
	else{
		// $('#testing_div').load('dataset/store_311_neighbourhood.php?neighbourhood=' + neighbourhood + '&checked=0');
	}
}

function store_311_request_status(request_status, ele) {
    //console.log(request_status);
    //var res = service_category.replace("+", "");
    request_status = encodeURI(request_status);
    //console.log(request_status);
    if(ele.checked){
	    $('#testing_div').load('dataset/store_311_request_status.php?request_status=' + request_status);
	    //console.log("inside function store_311_request_status");
	    ele.disabled = true;
	}
	else{
		// $('#testing_div').load('dataset/store_311_request_status.php?request_status=' + request_status + '&checked=0');
	}
}

function store_month(month, ele) {
    //console.log(month);
    //var res = service_category.replace("+", "");
    month = encodeURI(month);
    //console.log(month);
    if(ele.checked){
	    $('#testing_div').load('dataset/store_month.php?month=' + month);
	    //console.log("inside function store_month");
	    ele.disabled = true;
	}
	else{
		// $('#testing_div').load('dataset/store_311_request_status.php?request_status=' + request_status + '&checked=0');
	}
}

function store_bylaw_year(bylaw_year, ele) {
    //console.log(bylaw_year);
    //var res = service_category.replace("+", "");
    bylaw_year = encodeURI(bylaw_year);
    //console.log(bylaw_year);
    if(ele.checked){
	    $('#testing_div').load('dataset/store_bylaw_year.php?bylaw_year=' + bylaw_year);
	    //console.log("inside function store_bylaw_year");
	    ele.disabled = true;
	}
	else{
		// $('#testing_div').load('dataset/store_311_request_status.php?request_status=' + request_status + '&checked=0');
	}
}

function store_complaint(complaint, ele) {
    //console.log(complaint);
    //var res = service_category.replace("+", "");
    complaint = encodeURI(complaint);
    //console.log(complaint);
    if(ele.checked){
	    $('#testing_div').load('dataset/store_complaint.php?complaint=' + complaint);
	    //console.log("inside function store_complaint");
	    ele.disabled = true;
	}
	else{
		// $('#testing_div').load('dataset/store_311_request_status.php?request_status=' + request_status + '&checked=0');
	}
}

function store_bylaw_status(bylaw_status, ele) {
    //console.log(bylaw_status);
    //var res = service_category.replace("+", "");
    bylaw_status = encodeURI(bylaw_status);
    //console.log(bylaw_status);
    if(ele.checked){
	    $('#testing_div').load('dataset/store_bylaw_status.php?bylaw_status=' + bylaw_status);
	    //console.log("inside function store_bylaw_status");
	    ele.disabled = true;
	}
	else{
		// $('#testing_div').load('dataset/store_311_request_status.php?request_status=' + request_status + '&checked=0');
	}
}