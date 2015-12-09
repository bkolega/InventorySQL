function quickstats(userID){
	$.post("php/quickstats.php",{
		user: userID
	},function(data, status){
		$('.quickstats').last().append(data);
	});
}


$(document).ready(function(){
	// alert($('#userID').val())
	quickstats($('#userID').val());
});