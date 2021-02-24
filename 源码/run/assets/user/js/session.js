$(function() {
	'use strict'
	// ______________ Modal
	$("#myModal").modal('show');
	setTimeout(function(e) {
		$('#myModal').modal('hide');
	}, 20000000);
	
	setInterval(function () {
          var progress = document.getElementById('custom-bar');

          if (progress.value < progress.max) {
              progress.value += 10;
          }

    }, 1000);
});