function getUserName2(sess){
  $.post("php/session.php",{
    method: "retrieve",
    session: sess,
    user: null
  })
  .done(function(data){
	  quickstats(data);
	  landing(data);
	  return data;
  });
}

function landing(userID){
	$.post("php/my_inv.php",{
		user: userID
	},function(data, status){
		$('div.my_inv_expanding').append(data);
	});
}

function quickstats(userID){
	$.post("php/quickstats.php",{
		user: userID
	},function(data, status){
		$('.quickstats').last().append(data);
	});
}

function basicSearch(userID, name){
	$.post("php/my_inv_basic.php",{
		user: userID,
		name: name
	},function(data, status){
		$('.my_inv_expanding').append(data);
	});
}

function advSearch(userID, name, price, cat){
	$.post("php/my_inv_advanced.php",{
		user: userID,
		name: name,
		price: price,
		cat: cat
	},function(data, status){
		$('.my_inv_expanding').append(data);
	});
}

$(document).ready(function(){
	var cookie = document.cookie.split("=");
	var session = cookie[1].split(";");
	session = session[0];
	var u = getUserName2(session);
	//alert(u);
	
	// alert($('#userID').val())
	//var go = setTimeout(quickstats($('#userID').val()), 3000);
	//wait($('#userID').val());
	//clearTimeout(go);
	$('#basic_go').click(function(e){
		if($('#basic_name').val().indexOf(';') !== -1 || $('#basic_name').val().indexOf(',') !== -1 || $('#basic_name').val().indexOf('=') !== -1 || $('#basic_name').val().indexOf('*') !== -1){
			e.preventDefault();
			alert("Invalid Character Detected");
		}else{
			$(".my_inv_expanding").html("");
			basicSearch($('#userID').val(),$('#basic_name').val())
		}
	});
	
	$('#adv_go').click(function(e){
		if($('#adv_name').val().indexOf(';') !== -1 || $('#adv_name').val().indexOf(',') !== -1 || $('#adv_name').val().indexOf('=') !== -1 || $('#adv_name').val().indexOf('*') !== -1){
			e.preventDefault();
			alert("Invalid Character Detected");
		}else if($('#adv_price').val().indexOf(';') !== -1 || $('#adv_price').val().indexOf(',') !== -1 || $('#adv_price').val().indexOf('=') !== -1 || $('#adv_price').val().indexOf('*') !== -1){
			e.preventDefault();
			alert("Invalid Character Detected");
		}else if($('#adv_cat').val().indexOf(';') !== -1 || $('#adv_cat').val().indexOf(',') !== -1 || $('#adv_cat').val().indexOf('=') !== -1 || $('#adv_cat').val().indexOf('*') !== -1){
			e.preventDefault();
			alert("Invalid Character Detected");
		}else{
			$(".my_inv_expanding").html("");
			// alert($('#adv_price').val());
			advSearch($('#userID').val(),$('#adv_name').val(),$('#adv_price').val(),$('#adv_cat').val());
		}
	});
	
});