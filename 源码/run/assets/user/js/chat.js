$(function() {
	'use strict'
	const ps = new PerfectScrollbar('#ChatList', {
	  useBothWheelAxes:false,
	  suppressScrollX:false,
	});
	const ps2 = new PerfectScrollbar('#ChatList2', {
	  useBothWheelAxes:false,
	  suppressScrollX:false,
	});
	const ps1 = new PerfectScrollbar('#ChatBody', {
	  useBothWheelAxes:false,
	  suppressScrollX:false,
	});
	
	$('[data-toggle="tooltip"]').tooltip();
	
});