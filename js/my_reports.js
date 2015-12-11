function createReport(us,p1, p2, p3, p4, p5, p6){
	$.post("php/update_report.php",{
		user: us,
		col1: p1,
		col2: p2,
		col3: p3,
		cond1: p4,
		cond2: p5,
		fname: p6
		
	},function(data, status){
		$('#ReportTable').html("");
		$('#ReportTable').append(data);
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
		
		

		createReport($('#userID').val(),col1,col2,col3,cond1,cond2,fname);
	});
});
