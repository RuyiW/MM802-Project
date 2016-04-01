function check_all(elemSublist) {
    var aa = document.querySelectorAll($(elemSublist);
    for (var i = 0; i < aa.length; i++){
        aa[i].checked = true;
    }
};

$("#filter1").click(function(){
	check_all()
});