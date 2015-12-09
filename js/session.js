function getUserName(sess){
  $.post("php/session.php",{
    method: "retrieve",
    session: sess,
    user: null
  })
  .done(function(data){
    var appendItem = '<input type="hidden" id="userID" value="'+data+'" />';
    $('body').append(appendItem);
  });
}

function removeTableEntry(sess,uname){
  $.post("php/session.php",{
    method: "remove",
    session: sess,
    user: uname
  });
}

$(document).ready(function(){
  var cookie = document.cookie.split("=");
  var session = cookie[1].split(";");
  session = session[0];
  getUserName(session);
  
  $('a').click(function(){
    if($(this).text() === "Logout"){
      document.cookie = document.cookie + ";expires="+new Date($.now()).toUTCString();
      removeTableEntry(session,$('#userID').val());
    }
  });
});
