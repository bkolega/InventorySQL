function createReport(us,p1, p2, p3, p4, p5, p6, p7){
	$.post("php/update_report.php",{
		user: us,
		col1: p1,
		col2: p2,
		col3: p3,
		cond1: p4,
		cond2: p5,
		cond3: p6,
		fname: p7
		
	},function(data, status){
		$('#ReportTable').html("");
		$('#ReportTable').append(data);
	});
}

function loadReports(userID) {
	$.post("php/side_reports.php",{
		user: userID
	},function(data, status){
		$('#reportlist').html("");
		$('#reportlist').append(data);
	});
}

function getUserName5(sess){
  $.post("php/session.php",{
    method: "retrieve",
    session: sess,
    user: null
  })
  .done(function(data){
	  // On completeion, kicks off php to get quickstats and inventory overview of userID
	  //loadReports(data);
	var col1 = $('#c1').val();
	var col2 = $('#c2').val();
	var col3 = $('#c3').val();
	var cond1 = $('#cond1').val();
	var cond2 = $('#cond2').val();
	var fname = $('#filename').val();
	var cond3 = $('#conditionval').val();
	  createReport(data,col1,col2,col3,cond1,cond2,cond3,fname);
	loadReports(data);
	  return data;
  });
}

$(document).ready(function(){
	$('#submitReport').click(function(e){
	        var cookie = document.cookie.split("=");
	        var session = cookie[1].split(";");
	        session = session[0];
	        getUserName5(session);

		/*var username = "tuser";
		var col1 = $('#c1').val();
		var col2 = $('#c2').val();
		var col3 = $('#c3').val();
		var cond1 = $('#cond1').val();
		var cond2 = $('#cond2').val();
		var fname = $('#filename').val();
		var cond3 = $('#conditionval').val();
		createReport(username,col1,col2,col3,cond1,cond2,cond3,fname);
		loadReports(username);*/
	});
});
