function createCookie(sessionID,un){
  document.cookie="name=SessionCookie;session="+sessionID;
  $.ajax({
    type: "POST",
    url: "php/session.php",
    method: "create",
    session: sessionID,
    user: un
  })
  .done(function(){
    //$('#logonForm').submit();
  });
}

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
