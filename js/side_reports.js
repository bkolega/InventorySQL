function side_reports(userID, rname){
	$.post("php/side_reports.php",{
		user: userID,
		rname: rname
	},function(data, status){
		$('#myreports').append(data);
	});
}

function getUserName(sess){
  $.post("php/session.php",{
    method: "retrieve",
    session: sess,
    user: null
  })
  .done(function(data){
	  // On completeion, kicks off php to get quickstats and inventory overview of userID
	  loadReports(data);
	  return data;
  });
}

function loadReports(userID) {
	$.post("php/side_reports.php",{
		user: userID
	},function(data, status){
		$('#myreports').append(data);
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
    if($(this).id() !== "Logout"){
		side_reports(userID, $(this).text());
    }
  });
});
