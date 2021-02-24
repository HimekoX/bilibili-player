$(function () {
	
	// Cookies
	var options = {
		title: "We Care about your privacy",
		text: "By using this site, you agree to our use of cookies, Terms And Conditions.",
		theme: "white",
		learnMore: true,
		position: "bottom",
		onAccept: acceptCallbackFunction
	};
		
	var cookie = $.acceptCookies(options);

	$('.clear-button').click(function(e) {
		e.preventDefault();
		$('#cookie-popup-container').remove();
		document.cookie = 'cookiesAccepted=; path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
		cookie = $.acceptCookies(options);
		$(".cookie-indicator").removeClass("badge-success").addClass("badge-danger").text("No cookie found");
		updateCodeArea();
	});

	$('.theme-button').click(function(e) {
		e.preventDefault();
		$('#cookie-popup-container').remove();
		options.theme = $(this).data("theme1").replace("theme-", "");
		cookie = $.acceptCookies(options);
		updateCodeArea();
	});

	$('.position-button').click(function(e) {
		e.preventDefault();
		$('#cookie-popup-container').remove();

		var position = $(this).data("position");
		options.position = position;
		cookie = $.acceptCookies(options);
		updateCodeArea();
	});

	$('#btnCustomize').click(function(e) {
		e.preventDefault();

		$('html, body').animate({
			scrollTop: ($('.theme-buttons').offset().top)
		},500);
	});

	$('.option-button').click(function(e) {
		e.preventDefault();
		$('#cookie-popup-container').remove();
		var option = $(this).data("option");

		if(option == "default") {
			options = {
				title: "Cookies & Privacy Policy",
				text: "There are no cookies used on this site, but if there were this message could be customised to provide more details. Click the accept button below to see the optional callback in action... .",
				theme: "dark",
				learnMore: true,
				position: "top",
				onAccept: acceptCallbackFunction
			}
		}
		else if(option == "nolearnbutton")
			options.learnMore = false;
		else if(option == "customtext") {
			if($("#customHeader").val() != "")
				options.title = $("#customHeader").val();
			if($("#customSubHeader").val() != "")
				options.text = $("#customSubHeader").val();
			if($("#customAccept").val() != "")
				options.acceptButtonText = $("#customAccept").val();
			if($("#customLearnMore").val() != "")
				options.learnMoreButtonText = $("#customLearnMore").val();
			if($("#customLearnMoreInfo").val() != "")
				options.learnMoreInfoText = $("#customLearnMoreInfo").val();
		}

		cookie = $.acceptCookies(options);
	});

	if(getCookie("cookiesAccepted"))
		$(".cookie-indicator").removeClass("badge-danger").addClass("badge-success").text("Cookie saved");
	else
		$(".cookie-indicator").removeClass("badge-success").addClass("badge-danger").text("No cookie found");

	function updateCodeArea() {
		var code =
			"var options = " +
				JSON.stringify(options, null, 5) +
			";\n" +
			"$.acceptCookies(options);";

		$('#currentOptions').val(code);
		$("#currentOptions").height(0);
		$("#currentOptions").height($("#currentOptions").scrollHeight);
	}
});

var acceptCallbackFunction = function() {
	$(".cookie-indicator").removeClass("badge-danger").addClass("badge-success").text("Cookie saved");
}

function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}