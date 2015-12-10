function updateAcc(uname, fn, ln, phoneNum, old, new1){
	$.post("php/update_report.php",{
		user: uname,
		fname: fn,
		lname: ln,
		phone: phoneNum,
		oldpw: old,
		newpass1: new1
		
	},function(data, status){
		if(data.length != 3){
			alert("Update failed!");
		}else{
			if(data.length == 3){
				alert("Update successful!");
				return true;
			}else{
				alert("Update failed!");
				return false;
			}
		}

	});
}

$(document).ready(function(){
	$('#submitUpdate').click(function(e){
		var username = ($('#userID').val());
		var oldpw = $('#opw').val();
		var new1 = $('#npw1').val();
		var new2 = $('#npw2').val();
		var first = $('#fn').val();
		var last = $('#ln').val();

		if(new1 != new2)
		{
			e.preventDefault();
			alert("New passwords do not match!");
			return;
		} if(first == "" || last == "" || oldpw == "" || new1 == "" || new2 =="") {
			e.preventDefault();
			alert("Empty fields detected!");
			return;
		}

		updateAcc($('#userID').val(),$('#fn').val(),$('#ln').val(),$('#pn').val(),$('#opw').val(),$('#npw1').val());
	});
});
