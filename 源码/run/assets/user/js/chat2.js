$(function() {
	'use strict'
	$('#chatActiveContacts').lightSlider({
		autoWidth: true,
		controls: false,
		pager: false,
		slideMargin: 12
	});
	
	const ps = new PerfectScrollbar('#ChatList', {
	  useBothWheelAxes:false,
	  suppressScrollX:false,
	});
	
	const ps1 = new PerfectScrollbar('#ChatBody', {
	  useBothWheelAxes:false,
	  suppressScrollX:false,
	});
	
	$('[data-toggle="tooltip"]').tooltip();
	
});