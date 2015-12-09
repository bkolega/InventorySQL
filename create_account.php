<!DOCTYPE html>
<html class="my_in_h" style="min-height=2000px">
  <head>
  	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <title>Create Account</title>
	<link rel="stylesheet" href="css/main.css"/>    
    <script type="text/javascript" src="js/create_account.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			var date = new Date();
			var yyyy = date.getFullYear();
			//document.write("WISQL &copy;"+yyyy);
			$('.copyright').html("WISQL &copy;"+yyyy);
			});
		  </script>
  </head>
  <body class="my_in_h">
  <input type="hidden" id="admintag" value="<?php echo isset($_GET['admin']) ? $_GET['admin'] : 0; ?>" />
    <div style="height:10%"></div>
    
    <div class="logo_div_create_account">
      <div class="logo_box_create_account">
	<img src="logo.jpg" alt="WISQL" style="max-height:100%; width:auto; margin: auto;">
      </div>
    </div>

    <div style="height:5%"></div>

    <div class="create_account_div">
      <div class="create_account_box">
	<div class="ca_text">
	  <h3 style="text-align: center;">Create a New Account</h3>
	</div>
	<div class="ca_table_div">
	  <form method="POST">
		  <table class="ca_table">
			  <tr>
				<td style="text-align: right; padding-right:1em;">First Name:</td>
				<td><input type="text" id="addFname" name="fname"/></td>
			  </tr>
			  <tr>
				<td style="text-align: right; padding-right:1em;">Last Name:</td>
				<td><input type="text" id="addLname" name="lname"/></td>
			  </tr>
			  <tr>
				<td style="text-align: right; padding-right:1em;">Phone Number:</td>
				<td><input type="text" id="addPhone" name="phone"/></td>
			  <tr>
				<td style="text-align: right; padding-right:1em;">Username:</td>
				<td><input type="text" id="addUsername" name="username"/></td>
			  </tr>
			  <tr>
				<td style="text-align: right; padding-right:1em;">Password:</td>
				<td><input type="password" id="addPassword" name="password"/></td>
			  </tr>
			  <tr>
				<td></td>
				<td><input type="button" id="CreateAccountButton" value="Create My Account" /></td>
			  </tr>
			  <tr>
				<td></td>
				<td><input type="button" id="Cancel" value="Cancel" onclick="window.location='login.html'" /></td>
			  </tr>
		  </table>
	  </form>
	  <br />
	</div>
      </div>
    </div>


    <div style="height: -webkit-calc(28%); height: -moz-calc(28%); height: -o-calc(28%); height: calc(28%);"></div>

    <div class="copyright_div">
      <div class="copyright_box">
		
		<p class="centered_text copyright">

		</p>
      </div>
    </div>
		<script type="text/javascript">
		  $(document).ready(function(){/*
			$("html").width(window.innerWidth-15);
			$("html").height(window.innerHeight-15);
			$("body").width(window.innerWidth-15);
			$("body").height(window.innerHeight-15);*/
		  });
		</script>
	<div id="test">
	</div>
  </body>
</html>