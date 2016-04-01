function check_all() {
    var aa = document.querySelectorAll("input[type=checkbox]");
    for (var i = 0; i < aa.length; i++){
        aa[i].checked = true;
    }
};

$("#filter1").click(function())