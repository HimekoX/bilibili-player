/**
 * Template Name: EON Admin
 * Author: Spruko Technologies
 * Email: sprukotechnologies@gmail.com
 * Description: An Admin Bootstrap-4 Dashboard template
 * VectorMap
 */

! function($) {
	"use strict";

	var VectorMap = function() {
	};

	VectorMap.prototype.init = function() {
		//various examples
		$('#world-map-markers').vectorMap({
			map : 'world_mill_en',
			scaleColors : ['#04A8FB', '#871faf'],
			normalizeFunction : 'polynomial',
			hoverOpacity : 0.7,
			hoverColor : false,
			regionStyle : {
				initial : {
					fill : '#e5e9f2'
				}
			},
			 markerStyle: {
                initial: {
                    r: 9,
                    'fill': '#2d66f7',
                    'fill-opacity': 0.9,
                    'stroke': '#fff',
                    'stroke-width' : 9,
                    'stroke-opacity': 0.2
                },

                hover: {
                    'stroke': '#fff',
                    'fill-opacity': 1,
                    'stroke-width': 1.5
                }
            },
			backgroundColor : 'transparent',
			markers : [{
				latLng : [41.90, 12.45],
				name : 'Vatican City'
			}, {
				latLng : [43.73, 7.41],
				name : 'Monaco'
			}, {
				latLng : [-0.52, 166.93],
				name : 'Nauru'
			}, {
				latLng : [-8.51, 179.21],
				name : 'Tuvalu'
			}, {
				latLng : [43.93, 12.46],
				name : 'San Marino'
			}, {
				latLng : [47.14, 9.52],
				name : 'Liechtenstein'
			}, {
				latLng : [7.11, 171.06],
				name : 'Marshall Islands'
			}, {
				latLng : [17.3, -62.73],
				name : 'Saint Kitts and Nevis'
			}, {
				latLng : [3.2, 73.22],
				name : 'Maldives'
			}, {
				latLng : [35.88, 14.5],
				name : 'Malta'
			}, {
				latLng : [12.05, -61.75],
				name : 'Grenada'
			}, {
				latLng : [13.16, -61.23],
				name : 'Saint Vincent and the Grenadines'
			}, {
				latLng : [13.16, -59.55],
				name : 'Barbados'
			}, {
				latLng : [17.11, -61.85],
				name : 'Antigua and Barbuda'
			}, {
				latLng : [-4.61, 55.45],
				name : 'Seychelles'
			}, {
				latLng : [7.35, 134.46],
				name : 'Palau'
			}, {
				latLng : [42.5, 1.51],
				name : 'Andorra'
			}, {
				latLng : [14.01, -60.98],
				name : 'Saint Lucia'
			}, {
				latLng : [6.91, 158.18],
				name : 'Federated States of Micronesia'
			}, {
				latLng : [1.3, 103.8],
				name : 'Singapore'
			}, {
				latLng : [1.46, 173.03],
				name : 'Kiribati'
			}, {
				latLng : [-21.13, -175.2],
				name : 'Tonga'
			}, {
				latLng : [15.3, -61.38],
				name : 'Dominica'
			}, {
				latLng : [-20.2, 57.5],
				name : 'Mauritius'
			}, {
				latLng : [26.02, 50.55],
				name : 'Bahrain'
			}, {
				latLng : [0.33, 6.73],
				name : 'São Tomé and Príncipe'
			}]
		});


	$('#vmap2').vectorMap({
		map: 'asia_mill',
		showTooltip: true,
		backgroundColor: '#fa057a',
		hoverColor: '#00cccc'
	});
	$('#vmap3').vectorMap({
		map: 'au_mill',
		color: '#212229',
		borderColor: '#fff',
		backgroundColor: '#f72d66',
		hoverColor: '#00cccc',
		showLabels: true
	});
	$('#vmap4').vectorMap({
		map: 'ca_lcc',
		color: '#00cccc',
		borderColor: '#fff',
		backgroundColor: '#2dce89',
		hoverColor: '#00cccc',
		showLabels: true
	});

	$('#vmap5').vectorMap({
		map: 'de_mill',
		color: '#3bb001',
		borderColor: '#fff',
		backgroundColor: '#45aaf2',
		hoverColor: '#212229',
		showLabels: true
	});

	$('#vmap6').vectorMap({
		map: 'europe_mill_en',
		color: '#dc3545',
		borderColor: '#fff',
		backgroundColor: '#ecb403',
		hoverColor: '#dc3545',
		showLabels: true
	});

	$('#vmap7').vectorMap({
		map: 'in_mill',
		color: '#ea614c',
		borderColor: '#fff',
		backgroundColor: '#ff5b51',
		hoverColor: '#ea614c',
		showLabels: true
	});

	$('#vmap8').vectorMap({
		map: 'uk_mill_en',
		color: '#3db4ec',
		borderColor: '#fff',
		backgroundColor: '#2bcbba',
		hoverColor: '#3db4ec',
		showLabels: true
	});

	$('#vmap9').vectorMap({
		map: 'us_aea_en',
		color: '#f10075',
		borderColor: '#fff',
		backgroundColor: '#1e74a0',
		hoverColor: '#f10075',
		showLabels: true
	});


	},
	//init
	$.VectorMap = new VectorMap, $.VectorMap.Constructor =
	VectorMap
}(window.jQuery),

//initializing
function($) {
	"use strict";
	$.VectorMap.init()
}(window.jQuery);
