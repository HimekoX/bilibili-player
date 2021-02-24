$(document).ready(function() {
	'use strict';
	$('.select2').select2({
		minimumResultsForSearch: Infinity,
		width: '100%'
	});
	// Select2 by showing the search
	$('.select2-show-search').select2({
		minimumResultsForSearch: '',
		width: '100%'
	});
	// Colored Hover
	$('#select2').select2({
		dropdownCssClass: 'hover-success',
		minimumResultsForSearch: Infinity, // disabling search
		width: '100%'
	});
	$('#select3').select2({
		dropdownCssClass: 'hover-danger',
		minimumResultsForSearch: Infinity // disabling search
	});
	// Outline Select
	$('#select4').select2({
		containerCssClass: 'select2-outline-success',
		dropdownCssClass: 'bd-success hover-success',
		minimumResultsForSearch: Infinity // disabling search
	});
	$('#select5').select2({
		containerCssClass: 'select2-outline-info',
		dropdownCssClass: 'bd-info hover-info',
		minimumResultsForSearch: Infinity // disabling search
	});
	// Full Colored Select Box
	$('#select6').select2({
		containerCssClass: 'select2-full-color select2-primary',
		minimumResultsForSearch: Infinity // disabling search
	});
	$('#select7').select2({
		containerCssClass: 'select2-full-color select2-danger',
		dropdownCssClass: 'hover-danger',
		minimumResultsForSearch: Infinity // disabling search
	});
	// Full Colored Dropdown
	$('#select8').select2({
		dropdownCssClass: 'select2-drop-color select2-drop-primary',
		minimumResultsForSearch: Infinity // disabling search
	});
	$('#select9').select2({
		dropdownCssClass: 'select2-drop-color select2-drop-indigo',
		minimumResultsForSearch: Infinity // disabling search
	});
	// Full colored for both box and dropdown
	$('#select10').select2({
		containerCssClass: 'select2-full-color select2-primary',
		dropdownCssClass: 'select2-drop-color select2-drop-primary',
		minimumResultsForSearch: Infinity // disabling search
	});
	$('#select11').select2({
		containerCssClass: 'select2-full-color select2-indigo',
		dropdownCssClass: 'select2-drop-color select2-drop-indigo',
		minimumResultsForSearch: Infinity // disabling search
	});
});