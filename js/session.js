function getUserName(sess){
  $.ajax({
    type: "POST",
    url: "php/session.php",
    method: "retrieve",
    session: sess,
    user: null
  })
  .done(function(data){
    console.log(data);
    var appendItem = '<div id="userID" style="display:none;" val="'+data+'">';
    $('body').append(appendItem);
  });
}

function removeTableEntry(sess,uname){
  $.ajax({
    type: "POST",
    url: "php/session.php",
    method: "remove",
    session: sess,
    user: uname
  });
}

$(document).ready(function(){
  //0 = Cookie Name
  //1 = Session ID
  var cookieItems = document.cookie.split(";");
  var session = cookieItems[1].split("=");
  session = session[1];
  getUserName(session);
  
  $('a').click(function(){
    if($(this).text() === "Logout"){
      document.cookie = document.cookie + ";expires="+$.now()+1000;
      removeTableEntry(session,$('#userID').val());
    }
  });
});
