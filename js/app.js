jQuery(document).ready(function($) {
		var pluginDir = 'wp-content/plugins/bandwidthcalculator/';
		$("#bandwidthInfo,#errorMsg").hide();
		$("#submitbtn").click(function(event){
			event.preventDefault();
			if(validate()){
				$("#bandwidthInfo").fadeOut("fast");
				var bandwidth = calculateBandwidth();
			}
		});
		
		function validate(){

			//validate URL
			var urlregex = new RegExp("^(http|https)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\"\\\+&amp;%\$#\=~_\-]+))*$");
			if (!urlregex.test( $("#website").val() )) {
				$("#website").addClass("error").focus();
				return false;
			}else{
				$("#website").removeClass("error");
			}
			
			//validate visitors number
			if(!isNumber( $("#visitors").val() )){
				$("#visitors").addClass("error").focus();
				return false;
			}else{
				$("#visitors").removeClass("error");
			}
			
			return true;
		}
		
		function isNumber(n){
			return !isNaN(parseFloat(n)) && isFinite(n);
		}
		
		function calculateBandwidth(){
			$("#submitbtn").spinner();
			$("#website, #visitors").prop("disabled", true);
			$("#errorMsg").fadeOut("fast");
			$.ajax({
				url: pluginDir + "analize.php",
				type: "POST",
				data: { url : $("#website").val() },
				context: document.body,
				error: function (xhr, ajaxOptions, thrownError) {
					$("#submitbtn").spinner("remove");
					$("#website, #visitors").prop("disabled", false);
					$("errorMsg").html("Sorry, we were not possible to calculate bandwidth!").fadeIn("slow");
				}
			}).done(function(data) {
				$("#submitbtn").spinner("remove");
				$("#bandwidth").html(
				   ((data/(1024*1024)) * parseFloat($("#visitors").val())).toFixed(2)
				);
				$("#bandwidthInfo").fadeIn("slow");
				$("#website, #visitors").prop("disabled", false);
			})
		}
		
		// default spinner options
		$.fn.spinner.defaults = {
			position    : "right"       // left, right, center
			, img       : pluginDir + "js/spinner.gif" // path to spinner img
			, height    : 16            // height of spinner img
			, width     : 16            // width of spinner img
			, zIndex    : 1001          // z-index of spinner
			, hide      : false         // whether to hide the elem
			, onStart   : function(){ 
				$(this).css("opacity", "0.5"); 
				$(this).prop("disabled", true);
			} // start callback
			, onFinish  : function(){ 
				$(this).css("opacity", "1"); 
				$(this).prop("disabled", false);
			} // end callback
		};
	});