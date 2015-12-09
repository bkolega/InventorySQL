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
    data = $.parseJSON(data);
    var appendItem = '<div id="userID" style="display:none;" val="'+data.userId+'">';
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
  var cookie = document.cookie.split("=");
  var session = cookie[1]
  getUserName(session);
  
  $('a').click(function(){
    if($(this).text() === "Logout"){
      document.cookie = document.cookie + ";expires="+$.now()+1000;
      removeTableEntry(session,$('#userID').val());
    }
  });
});
