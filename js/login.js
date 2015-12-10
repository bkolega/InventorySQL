//Creates cookie for use with session.js once logged in
function createCookie(sessionID,un){
  if(document.cookie != "")
  {
    document.cookie = document.cookie + ";expires="+(new Date($.now()).toUTCString());
  }
  document.cookie="session="+sessionID;
  //Sends data to session php script to add record
  $.post("php/session.php",{
    method: "create",
    session: sessionID,
    user: un
  })
  .done(function(data){
     $('#loginForm').submit();
  });
}

//Passes username and password to login php to validate user.
function validateLogin(un,up,sess){
  $.post("php/login.php",{
    user: un,
    pass: up
  })
  .done(function(data){
    if(data == "YES")
    {
      createCookie(sess,un);
    }
    else
    {
      alert("Invalid Unsername or Password.");
    }
  });
}

$(document).ready(function(){
  //Checks whether or not login fields are filled
  //alerts user to fill fields if empty otherwise
  //creates session id and passes values to validateLogin()
  $('#submitLogon').click(function(e){
    e.preventDefault();
    if($('#UID').val() === ""){
      alert("Username field empty, please enter a username!");
    }
    else if($('#UPW').val() === ""){
      alert("Password field empty, please enter a password!");
    }
    else{
      var session = $.now();
      validateLogin($('#UID').val(),$('#UPW').val(),session);
    }
  });
});
