function result_func(ele){
	if (ele.id == 'knn_neighbour'){
		$('#result').load('dataset/ProjNNneighbour.php');
	}
 	else if(ele.id == 'knn_day'){
 		$('#result').load('dataset/ProjNNdays.php');
 	}
 	else if(ele.id == 'knn_distance'){
 		$('#result').load('dataset/ProjNNdistance.php');
 	}
}


$(document).ready(function(){
	
	$("#knn_neighbour").click(function(){
		console.log('before');
		result_func(this);
	});
});

$(document).ready(function(){
	
	$("#knn_day").click(function(){
		console.log('before');
		result_func(this);
	});
});

$(document).ready(function(){
	
	$("#knn_distance").click(function(){
		console.log('before');
		result_func(this);
	});
});
