function createCookie(sessionID){
  document.cookie="name=SessionCookie;session="+sessionID;
}

function validateLogin(un,up,sess){
  $.ajax({
    type: "POST",
    url: "php/login.php",
    user: un,
    pass: up
  })
  .done(function(data){
  
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
      var accept = validateLogon($('#UID').val(),$('#UPW').val(),session);
      if(!accept){
        e.preventDefault();
        alert("Username and/or Password is invalid");
      }
      else{
        createCooke(session);
      }
    }
  });
});
