function createReport(p1, p2, p3, p4, p5, p6){
	$.post("php/update_report.php",{
		col1: p1,
		col2: p2,
		col3: p3,
		cond1: p4,
		cond2: p5,
		fname: p6
		
	},function(data, status){
		if(data.length != 3){
			alert("Update failed!");
		}else{
			if(data.length == 3){
				alert("Update successful!");
				return true;
			}else{
				alert("Update failed!");
				return false;
			}
		}

	});
}

$(document).ready(function(){
	$('#submitReport').click(function(e){
		var col1 = $('#c1').val();
		var col2 = $('#c2').val();
		var col3 = $('#c3').val();
		var cond1 = $('#cond1').val();
		var cond2 = $('#cond2').val();
		var fname = $('#filename').val();
		
		

		createReport(col1,col2,col3,cond1,cond2,fname);
	});
});
