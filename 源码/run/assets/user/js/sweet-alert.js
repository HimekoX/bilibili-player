$(function(){
   'use strict'

	// Message
	$("#but1").on("click", function(e){
		$('body').removeClass('timer-alert');
		var message = $("#message").val();
		if(message == ""){
			message  = "New Notification from Admintro";
		}
		swal(message);
	});

	// With message and title
	$("#but2").on("click", function(e){
		$('body').removeClass('timer-alert');
		var message = $("#message").val();
		var title = $("#title").val();
		if(message == ""){
			message  = "New Notification from Admintro";
		}
		if(title == ""){
			title = "Notifiaction Styles";
		}
		swal(title,message);
	});

	// Show image
	$("#but3").on("click", function(e){
		$('body').removeClass('timer-alert');
		var message = $("#message").val();
		var title = $("#title").val();
		if(message == ""){
			message  = "New Notification from Admintro";
		}
		if(title == ""){
			title = "Notifiaction Styles";
		}
		swal({
			title: title,
			text: message,
			imageUrl: '../../assets/images/brand/favicon.png'
		});
	});

	// Timer
	$("#but4").on("click", function(e){
		$('body').addClass('timer-alert');
		var message = $("#message").val();
		var title = $("#title").val();
		if(message == ""){
			message  = "New Notification from Admintro";
		}
		if(title == ""){
			title = "Notifiaction Styles";
		}
		message += "(close after 2 seconds)";
		swal({
			title: title,
			text: message,
			timer: 2000,
			showConfirmButton: false
		});
	});

	//
	$("#click").on("click", function(e){
		$('body').removeClass('timer-alert');
		var type = $("#type").val();
		swal({
			title: "Notifiaction Styles",
			text: "New Notification from Admintro",
			type: type
		});
	});

	// Prompt
	$("#prompt").on("click", function(e){
		$('body').removeClass('timer-alert');
		swal({
			title: "Notification Alert",
			text: "your getting some notification from mail please check it",
			type: "input",
			showCancelButton: true,
			closeOnConfirm: false,
			inputPlaceholder: "Your message"
		},function(inputValue){


			if (inputValue != "") {
				swal("Input","You have entered : " + inputValue);

			}
		});
	});

	// Confirm
	$("#confirm").on("click", function(e){
		$('body').removeClass('timer-alert');
		swal({
			title: "Notifiaction Styles",
			text: "New Notification from Admintro",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: 'Exit',
			cancelButtonText: 'Stay on the page'
		});
	});


	$("#click").on("click", function(e){
		swal('Congratulations!', 'Your message has been succesfully sent', 'success');
	});
	$("#click1").on("click", function(e){
		swal({
			title: "Some Risk File Is Founded",
			text: "Some Virus file is detected your system going to be in Risk",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: 'Exit',
			cancelButtonText: 'Stay on the page'
		});
	});
	$("#click2").on("click", function(e){
		swal({
			title: "Something Went Wrong",
			text: "Please fix the issue the issue file not loaded & items not found",
			type: "error",
			showCancelButton: true,
			confirmButtonText: 'Exit',
			cancelButtonText: 'Stay on the page'
		});
	});
	$("#click3").on("click", function(e){
		swal({
			title: "Notification Alert",
			text: "your getting some notification from mail please check it",
			type: "info",
			showCancelButton: true,
			confirmButtonText: 'Exit',
			cancelButtonText: 'Stay on the page'
		});
	});
});