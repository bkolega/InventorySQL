function updateAcc(uname, fn, ln, phoneNum, old, new1){
	$.post("php/update_account.php",{
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
		} if(first == "" || last == "" || oldpw == "" || new1 == "" || new2 =="") {
			e.preventDefault();
			alert("Empty fields detected!");
		}
		/*if($('#addFname').val() == ""){
			e.preventDefault();
			alert("Missing Data: First Name. Please fill out.");
		}else if($('#addLname').val() == ""){
			e.preventDefault();
			alert("Missing Data: Last Name. Please fill out.");
		}else if($('#addPhone').val() == ""){
			e.preventDefault();
			alert("Missing Data: Phone Number. Please fill out.");
		}else if($('#addUsername').val() == ""){
			e.preventDefault();
			alert("Missing Data: Username. Please fill out.");
		}else if($('#addPassword').val() == ""){
			e.preventDefault();
			alert("Missing Data: Password. Please fill out.");
		}else if($('#addFname').val().indexOf(';') !== -1 || $('#addFname').val().indexOf(',') !== -1 || $('#addFname').val().indexOf('=') !== -1 || $('#addFname').val().indexOf('*') !== -1){
			e.preventDefault();
			alert("Invalid Character Detected");
		}else if($('#addLname').val().indexOf(';') !== -1 || $('#addLname').val().indexOf(',') !== -1 || $('#addLname').val().indexOf('=') !== -1 || $('#addLname').val().indexOf('*') !== -1){
			e.preventDefault();
			alert("Invalid Character Detected");
		}else if($('#addPhone').val().indexOf(';') !== -1 || $('#addPhone').val().indexOf(',') !== -1 || $('#addPhone').val().indexOf('=') !== -1 || $('#addPhone').val().indexOf('*') !== -1){
			e.preventDefault();
			alert("Invalid Character Detected");
		}else if($('#addUsername').val().indexOf(';') !== -1 || $('#addUsername').val().indexOf(',') !== -1 || $('#addUsername').val().indexOf('=') !== -1 || $('#addUsername').val().indexOf('*') !== -1){
			e.preventDefault();
			alert("Invalid Character Detected");
		}else if($('#addPassword').val().indexOf(';') !== -1 || $('#addPassword').val().indexOf(',') !== -1 || $('#addPassword').val().indexOf('=') !== -1 || $('#addPassword').val().indexOf('*') !== -1){
			e.preventDefault();
			alert("Invalid Character Detected");
		}else if($('#addPhone').val().indexOf(')') !== -1 || $('#addPhone').val().indexOf('(') !== -1 || $('#addPhone').val().indexOf('-') !== -1 || $('#addPhone').val().indexOf(' ') !== -1 || isNaN($('#addPhone').val())){
			e.preventDefault();
			alert("Please Enter Only Digits for phone number");
		}else{
			addUser($('#addUsername').val(),$('#addPassword').val(),$('#addFname').val(),$('#addLname').val(),$('#addPhone').val(),$('#admintag').val());
			e.preventDefault();
			
		}*/

		updateAcc($('#userID').val(),$('#fn').val(),$('#ln').val(),$('#pn').val(),$('#opw').val(),$('#npw1').val());
	});
});
