$(function() {
	'use strict';
	var morrisData = [{
		y: '2006',
		a: 12,
		b: 18
	}, {
		y: '2007',
		a: 18,
		b: 22
	}, {
		y: '2008',
		a: 15,
		b: 18
	}, {
		y: '2009',
		a: 25,
		b: 28
	}, {
		y: '2010',
		a: 30,
		b: 35
	}, {
		y: '2011',
		a: 18,
		b: 28
	}, {
		y: '2012',
		a: 12,
		b: 18
	}];
	var morrisData2 = [{
		y: '2006',
		a: 12,
		b: 18,
		c: 20
	}, {
		y: '2007',
		a: 18,
		b: 22,
		c: 25
	}, {
		y: '2008',
		a: 15,
		b: 18,
		c: 24
	}, {
		y: '2009',
		a: 25,
		b: 28,
		c: 30
	}, {
		y: '2010',
		a: 30,
		b: 35,
		c: 38
	}, {
		y: '2011',
		a: 18,
		b: 28,
		c: 40
	}, {
		y: '2012',
		a: 12,
		b: 18,
		c: 28
	}];
	new Morris.Bar({
		element: 'morrisBar1',
		data: morrisData,
		xkey: 'y',
		ykeys: ['a', 'b'],
		labels: ['Series A', 'Series B'],
		barColors: ['#705ec8','#fb1c52'],
		gridTextSize: 11,
		hideHover: 'auto',
		resize: true
	});
	new Morris.Bar({
		element: 'morrisBar3',
		data: morrisData,
		xkey: 'y',
		ykeys: ['a', 'b'],
		labels: ['Series A', 'Series B'],
		barColors: ['#705ec8','#fb1c52'],
		stacked: true,
		gridTextSize: 11,
		hideHover: 'auto',
		resize: true
	});
	new Morris.Line({
		element: 'morrisLine1',
		data: [{
			y: '2006',
			a: 12,
			b: 18
		}, {
			y: '2007',
			a: 18,
			b: 22
		}, {
			y: '2008',
			a: 15,
			b: 18
		}, {
			y: '2009',
			a: 25,
			b: 28
		}, {
			y: '2010',
			a: 30,
			b: 35
		}, {
			y: '2011',
			a: 18,
			b: 28
		}, {
			y: '2012',
			a: 12,
			b: 18
		}],
		xkey: 'y',
		ykeys: ['a', 'b'],
		labels: ['Series A', 'Series B'],
		lineColors: ['#705ec8','#fb1c52'],
		lineWidth: 1,
		ymax: 'auto 50',
		gridTextSize: 11,
		hideHover: 'auto',
		resize: true
	});
	new Morris.Area({
		element: 'morrisArea1',
		data: [{
			y: '2006',
			a: 12,
			b: 18
		}, {
			y: '2007',
			a: 18,
			b: 22
		}, {
			y: '2008',
			a: 15,
			b: 18
		}, {
			y: '2009',
			a: 25,
			b: 28
		}, {
			y: '2010',
			a: 30,
			b: 35
		}, {
			y: '2011',
			a: 18,
			b: 28
		}, {
			y: '2012',
			a: 12,
			b: 18
		}],
		xkey: 'y',
		ykeys: ['a', 'b'],
		labels: ['Series A', 'Series B'],
		lineColors: ['#705ec8','#fb1c52'],
		lineWidth: 1,
		fillOpacity: 0.9,
		gridTextSize: 11,
		hideHover: 'auto',
		resize: true,
		ymax: 'auto 100',
	});


	var nReloads = 0;
	function data(offset) {
	  var ret = [];
	  for (var x = 0; x <= 360; x += 10) {
		var v = (offset + x) % 360;
		ret.push({
		  x: x,
		  y: Math.sin(Math.PI * v / 180).toFixed(4),
		  z: Math.cos(Math.PI * v / 180).toFixed(4)
		});
	  }
	  return ret;
	}

	/*---- morrisBar6----*/
	var graph = Morris.Line({
		element: 'morrisBar6',
		data: data(0),
		xkey: 'x',
		ykeys: ['y', 'z'],
		labels: ['data1', 'data2'],
		lineColors: ['#705ec8', '#fb1c52'],
		parseTime: false,
		ymin: -1.0,
		ymax: 1.0,
		hideHover: true
	});
	function update() {
	  nReloads++;
	  graph.setData(data(5 * nReloads));
	  $('#reloadStatus').text(nReloads + ' reloads');
	}
	setInterval(update, 100);

	/*---- morrisBar7----*/
	var day_data = [
	  {"period": "2012-10-01", "licensed": 3407, "sorned": 660},
	  {"period": "2012-09-30", "licensed": 3351, "sorned": 629},
	  {"period": "2012-09-29", "licensed": 3269, "sorned": 618},
	  {"period": "2012-09-20", "licensed": 3246, "sorned": 661},
	  {"period": "2012-09-19", "licensed": 3257, "sorned": 667},
	  {"period": "2012-09-18", "licensed": 3248, "sorned": 627},
	  {"period": "2012-09-17", "licensed": 3171, "sorned": 660},
	  {"period": "2012-09-16", "licensed": 3171, "sorned": 676},
	  {"period": "2012-09-15", "licensed": 3201, "sorned": 656},
	  {"period": "2012-09-10", "licensed": 3215, "sorned": 622}
	];
	new Morris.Line({
	  element: 'morrisBar7',

	  data: day_data,
	  xkey: 'period',
	  ykeys: ['licensed', 'sorned'],
	  labels: ['Licensed', 'SORN'],
		lineColors: ['#705ec8', '#fb1c52'],
	});

	new Morris.Donut({
		element: 'morrisDonut1',
		data: [{
			label: 'Google',
			value: 42
		}, {
			label: 'Firefox',
			value: 32
		}, {
			label: 'IE',
			value: 26
		}],
		colors: ['#fb1c52','#705ec8', '#2dce89'],
		storke: ['#fb1c52','#705ec8', '#2dce89'],
		resize: true,
		backgroundColor: 'rgba(119, 119, 142, 0.2)',
		labelColor: '#8e9cad',
	});
});