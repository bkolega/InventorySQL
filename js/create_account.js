/*
 *	Author: Tyler Steiner
 *	For: WISQL Project; EECS 647
 *	Date: 12/11/2015
 *	File: create_account.js
*/
// Function passes all the info gathered from the customer to ca.php for processing
function addUser(uname, upass, name_f, name_l, phoneNum, admin){
	$.post("php/ca.php",{
		user: uname,
		pass: upass,
		fname: name_f,
		lname: name_l,
		phone: phoneNum,
		isAdmin: admin
		
	},function(data, status){
		// If data.length > 5, there was an error that needs to be displayed in #test div
		if(data.length > 5){
			$('#test').html(data);
		}else{
			// If data.length == 3, create user was a success, redirect to login.html
			if(data.length == 3){
				window.location="login.html";
				return true;
			}else{
				// create user failed, inform user
				alert("Username already exists. Please try again");
				return false;
			}
		}

	});
}

$(document).ready(function(){
	/*
	*  After the Create Account Button is clicked, and through a long series of if/else/if statements,
	*  the following function validates input.
	*/
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
			
		}
	});
});