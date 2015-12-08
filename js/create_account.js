function addUser(uname, upass, name_f, name_l, phoneNum){
	$.ajax({
		type: "POST",
		url: "php/create_account.php",
		user: uname,
		pass: upass,
		fname: name_f,
		lname: name_l,
		phone: phoneNum
		
	})
	.done(function(data){
		if(data == "YES"){
			return true;
		}else{
			return false;
		}
	});
}

$(document).ready(function(){
	$('#CreateAccountButton').click(function(e){
		if($('#addFname').val() == ""){
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
		}else{
			if(!(addUser($('#addUsername').val(),$('#addPassword').val(),$('#addFname').val(),$('#addLname').val(),$('#addPhone').val()))){
				e.preventDefault();
				alert("Username already exists. Please try again");
			}
		}
	});
});