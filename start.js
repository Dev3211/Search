$(document).ready(function () {
	$("#submit").click(function () {
		let submitt = $("#search").val();

		if (submitt == '') {
		 swal({title: "Please fill the field"});
		 return
		} else {
			$.post("search.php", {
				search: submitt
			}, function (data) {
			document.getElementById("result").innerHTML = data;
			$("#search").val('');
			});
		}
	});
	$("#submit1").click(function () {
		let linkz = $("#crawl").val();
        
		if (linkz == '') {
		 swal({title: "Please fill the field"});
		 return
		} else {
			$.post("search.php", {
				crawl: linkz
			}, function (data) {
		    if(data == 'done'){
			 swal({title: "Website has been crawled!"});
			 $("#crawl").val('http://');
			}else{
			 swal({title: data});
			}
		  });
		}
	});
});