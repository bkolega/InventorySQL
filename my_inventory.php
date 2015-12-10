<!DOCTYPE html>
<html class="my_in_h">
  <head>
    <title>My Inventory</title>
    <link rel="stylesheet" href="css/main.css" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="js/session.js"></script>
    <script type="text/javascript" src="js/my_inventory.js"></script>
  </head>
  <body class="my_in_h">
    <div class="top_spacer"></div>
    
    <div class="top_bar">
      <div class="inv_logo_box">
	    <img src="logo.jpg" alt="WISQL" style="max-height:100%; width:auto; margin: auto; padding-left: 25%">
      </div>
      <div class="my_inventory_box">
	    <h3 class="centered_text">My Inventory</h3>
      </div>
    </div>
    
    <div style="height:8px"></div> <!-- SPACER -->

    <div class="main_div_mi">
      <div style="height:2px"></div>
      <div class="basic_search_div">
		<div id="basic_s">
			<div id="basic_search_left">
				<h3>Search: </h3>
			</div>
			<div id="basic_search_center">
				&nbsp <input type="text" id="basic_name" style="width: 95%;" placeholder="Enter Item Name"/>
			</div>
			<div id="basic_search_right">
				<input type="button" id="basic_go" value="GO"/>
			</div>
		</div>
	  <!--
	<table id="basic_s_table">
	  <tr>
	    <td>
	      <h3>Search: </h3>
	    </td>
	    <td>
	      <input type="text" id="basic_name"/>
	    </td>
	    <td>
	      <input type="button" id="basic_go" value="GO"/>
	    </td>
	  <tr>
	</table>-->
      </div>
      	<div class="left_items_div_mi">
		  <div class="left_items_div_mi_1">
			<div class="Adv_search_div">
			  <br />
			  <p class="centered_text">Navigation</p>
			  <ul>
			   <li><a href="login.html">Logout</a></li>
			   <li><a href="add_inv.html">Add/Modify Inventory</a></li>
			   <li><a href="my_account.html">My Account</a></li>
			   <li><a href="my_reports.html">My Reports</a></li>
			  </ul>
			  <br clear="all" />
			  <p class="centered_text">Advanced Search</p>
			  <div>
				&nbsp <input type="text" id="adv_name" placeholder="Name" style="max-width:75%;"/>
			  </div>
			  <div>
				&nbsp <input type="text" id="adv_price" placeholder="Price"style="max-width:75%;"/>
			  </div>
			  <div>
				&nbsp <input type="text" id="adv_cat" placeholder="Category"style="max-width:75%;"/>
			  </div>
			  <div>
				&nbsp <input type="button" id="adv_go" value="Go" />
			  </div>
			</div>
		  </div>
		  <div style="height:7px; float: left; width: 100%;"></div>
		  <div class="left_items_div_mi_2">
			<div class="Adv_search_div quickstats">
			</div>
		  </div>
	  </div>
	  <div class="my_inv_expanding">
		<div style="height: 8px; width: 100%"></div>
			<!--<script type="text/javascript">
				$(document).ready(function(){
					$.post("php/my_inv.php").done(function(d){
						$('div.my_inv_expanding').append(d);
					});
			})
			</script>-->
	  </div>
	</div>
    
    <div style="height: 8px"></div> <!-- SPACER -->

    <div class="copyright_div_mi">
      <div class="copyright_box">
	    <p class="centered_text">
	      <script type="text/javascript">
            var date = new Date();
            var yyyy = date.getFullYear();
			var data;
            document.write("WISQL &copy;"+yyyy);
          </script>
	    </p>
      </div>
    </div>
    <script type="text/javascript">
      $(document).ready(function(){/*
        $("html").width(window.innerWidth-15);
        $("html").height(window.innerHeight-15);
        $("body").width(window.innerWidth-15);
        $("body").height(window.innerHeight-15);*/
		$.post("php/view.php").done(function(d){
			$('p.centered_text').last().append("<br />");
			$('p.centered_text').last().append(d);
		});
      });
    </script>
  </body>
</html>
