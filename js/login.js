function createCookie(sessionID,un){
  document.cookie="name=SessionCookie;session="+sessionID;
  $.ajax({
    type: "POST",
    url: "php/session.php"
    method: "create",
    session: sessionID,
    user: user
  });
}

function validateLogin(un,up,sess){
  $.ajax({
    type: "POST",
    url: "php/login.php",
    user: un,
    pass: up
  })
  .done(function(data){
    if(data == "YES")
    {
      return true;
    }
    else
    {
      return false;
    }
  });
}

$(document).ready(function(){
  $('#submitLogon').click(function(e){
    if($('#UID').val() === ""){
      e.preventDefault();
      alert("Username field empty, please enter a username!");
    }
    else if($('#UPW').val() === ""){
      e.preventDefault()
      alert("Password field empty, please enter a password!");
    }
    else{
      var session = $.now();
      if(!(validateLogon($('#UID').val(),$('#UPW').val(),session))){
        e.preventDefault();
        alert("Username and/or Password is invalid");
      }
      else{
        createCooke(session,$('#UID').val());
      }
    }
  });
});
