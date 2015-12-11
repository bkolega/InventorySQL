/*
 *	Author: Tyler Steiner
 *	For: WISQL Project; EECS 647
 *	Date: 12/11/2015
 *	File: my_inventory.js
*/
/*
 * The following function takes in the session ID.  It sends that to session.php in order to get back
 * a userID for the session.  session.js would usually take care of this and add a hidden field but
 * it doesn't complete in time.  This function then takes the userID that was retrieved and launches the
 * quickstats and landing functions.
 */
function getUserName2(sess){
  $.post("php/session.php",{
    method: "retrieve",
    session: sess,
    user: null
  })
  .done(function(data){
	  // On completeion, kicks off php to get quickstats and inventory overview of userID
	  quickstats(data);
	  landing(data);
	  return data;
  });
}

/*
 *  The following function sends the userID to my_inv.php which echos back the html code to 
 *  write an overview of the userID's inventory (max of 20 items).  When done, the function
 *  appends the data to the my_inv_expanding div.
 */
function landing(userID){
	$.post("php/my_inv.php",{
		user: userID
	},function(data, status){
		$('div.my_inv_expanding').append(data);
	});
}

/*
 *  The following function sends the userID to the quickstats.php script which echos back the 
 *  html code to write the Quick Statistics section for the user.  It then appends the data to
 *  the quickstats div.
 */
function quickstats(userID){
	$.post("php/quickstats.php",{
		user: userID
	},function(data, status){
		$('.quickstats').last().append(data);
	});
}

/*
 *  The following function takes in the userID and the name of an item and sends it to the 
 *  my_inv_basic.php script which echos back the html code to write the items that the search
 *  returned.  That html code is appended to the my_inv_expanding div.
 */
function basicSearch(userID, name){
	$.post("php/my_inv_basic.php",{
		user: userID,
		name: name
	},function(data, status){
		$('.my_inv_expanding').append(data);
	});
}

/*
 *  The following function takes in the userID, item name, item price, and item category supplied
 *  in the advanced search section.  The my_inv_advanced.php script echos back the html code to write
 *  the items that the search returned.  That html code is then appended to the my_inv_expanding div.
 */
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
	// The following gets (and splits) the sessionID from the cookie place in the browser on login.
	var cookie = document.cookie.split("=");
	var session = cookie[1].split(";");
	session = session[0];
	var u = getUserName2(session);

	/*
	 *  The following runs when the basic search "go" button is pressed. It validates the input and if it's good input,
	 *  clears the my_inv_expanding div and runs the basicSearch function.
	 */
	$('#basic_go').click(function(e){
		if($('#basic_name').val().indexOf(';') !== -1 || $('#basic_name').val().indexOf(',') !== -1 || $('#basic_name').val().indexOf('=') !== -1 || $('#basic_name').val().indexOf('*') !== -1){
			e.preventDefault();
			alert("Invalid Character Detected");
		}else{
			$(".my_inv_expanding").html("");
			basicSearch($('#userID').val(),$('#basic_name').val())
		}
	});
	
	/*
	 *  The following runs when advanced search's "go" button is pressed.  It validates the input and if it's good input,
	 *  clears the my_inv_expanding div and runs the advSearch function.
	 */
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
			advSearch($('#userID').val(),$('#adv_name').val(),$('#adv_price').val(),$('#adv_cat').val());
		}
	});
	
});