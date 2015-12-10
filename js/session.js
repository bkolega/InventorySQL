//Passes session id from cookie to obtain user id from Session table
function getUserName(sess){
  $.post("php/session.php",{
    method: "retrieve",
    session: sess,
    user: null
  })
  .done(function(data){
	//Adds hidden field to current page to use for user id operations.
    var appendItem = '<input type="hidden" id="userID" value="'+data+'" />';
    $('body').append(appendItem);
	//Trigers call to get inventory id based upon user id from session table.
    $.post("php/access.php",{
      un: data
    })
    .done(function(data){
	  //Adds hidden field to current page use for inventory id operations.
      $('body').append('<input type="hidden" id="inventoryID" value="'+data+'" />');
    });
  });
}

//Removes session table entry upon clicking logout
function removeTableEntry(sess,uname){
  $.post("php/session.php",{
    method: "remove",
    session: sess,
    user: uname
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
    if($(this).text() === "Logout"){
      document.cookie = document.cookie + ";expires="+new Date($.now()).toUTCString();
      removeTableEntry(session,$('#userID').val());
    }
  });
});
