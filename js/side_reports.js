function getUserName(sess){
  $.post("php/session.php",{
    method: "retrieve",
    session: sess,
    user: null
  })
  .done(function(data){
	  // On completeion, kicks off php to get quickstats and inventory overview of userID
	$('#username').html("");
	$("#username").append(data);
	  loadReports(data);
	  
	  return data;
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

/*function presentReport(userID)
{

	$.post("php/update_report.php",{
		user: userID
	},function(data, status){
		$('#reportlist').html("");
		$('#reportlist').append(data);
	});
}*/

function clickReport(reportname) {
	$.post("php/load_report.php",{
		rn: reportname
	},function(data, status){
		$('#ReportTable').html("");
		$('#ReportTable').append(data);
	});
}

$(document).ready(function(){
   

  
  //Gets session information from the cookie
  var cookie = document.cookie.split("=");
  var session = cookie[1].split(";");
  session = session[0];
  getUserName(session);
  
  //Logout link is a anchor link so it checks if the link text is logout
  //Makes call to clear the session id, user id record from the table.

  $('a').click(function(){
//jQuery('a').on('click', function () {
    if($(this).id() !== "Logout" && $(this).id() !== "My Inventory" && $(this).id() !== "My Account"){
		//presentReport(userID, $(this).text());
		clickReport($(this).id());
    }
  }); 
});
