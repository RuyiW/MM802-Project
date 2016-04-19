/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// This script is for storing the checklist selection.
// After user clicked on any checkbox, the page calls coresponding store function.
// Each function passes checked value to store file.
// Then disable the checkbox. 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function store_ward(ward, ele) {
    ward = encodeURI(ward);
	if(ele.checked){
	    $('#testing_div').load('dataset/store_ward.php?ward=' + ward);
	    ele.disabled = true;
	}
}

function store_service_category(service_category, ele) {
    service_category = service_category.replace(/&/g, 'AND');
    service_category = encodeURI(service_category);
    if(ele.checked){
	    $('#testing_div').load('dataset/store_service_category.php?service_category=' + service_category);
	    ele.disabled = true;
	}
}

function store_311_neighbourhood(neighbourhood, ele) {
    neighbourhood = encodeURI(neighbourhood);
    if(ele.checked){
	    $('#testing_div').load('dataset/store_311_neighbourhood.php?neighbourhood=' + neighbourhood);
	    ele.disabled = true;
	}
}

function store_311_request_status(request_status, ele) {
    request_status = encodeURI(request_status);
    if(ele.checked){
	    $('#testing_div').load('dataset/store_311_request_status.php?request_status=' + request_status);
	    ele.disabled = true;
	}
}

function store_month(month, ele) {
    month = encodeURI(month);
    if(ele.checked){
	    $('#testing_div').load('dataset/store_month.php?month=' + month);
	    ele.disabled = true;
	}
}

function store_bylaw_year(bylaw_year, ele) {
    bylaw_year = encodeURI(bylaw_year);
    if(ele.checked){
	    $('#testing_div').load('dataset/store_bylaw_year.php?bylaw_year=' + bylaw_year);
	    ele.disabled = true;
	}
}

function store_complaint(complaint, ele) {
    complaint = encodeURI(complaint);
    if(ele.checked){
	    $('#testing_div').load('dataset/store_complaint.php?complaint=' + complaint);
	    ele.disabled = true;
	}
}

function store_bylaw_status(bylaw_status, ele) {
    bylaw_status = encodeURI(bylaw_status);
    if(ele.checked){
	    $('#testing_div').load('dataset/store_bylaw_status.php?bylaw_status=' + bylaw_status);
	    ele.disabled = true;
	}
}