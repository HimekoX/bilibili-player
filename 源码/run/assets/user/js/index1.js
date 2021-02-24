$(function(e){
  'use strict'

	/* E-chart */
	var chartdata = [
		{
			name: 'Total Units Sold',
			type: 'line',
			smooth:true,
			data: [8, 5, 15, 10, 10, 8, 9, 12, 5, 15, 10, 10, 8, 16],
			itemStyle: {
				normal: { barBorderRadius: [50 ,50, 0 ,0],
						color: new echarts.graphic.LinearGradient(
							0, 0, 0, 1,
							[
								{offset: 0, color: '#fd6f82'},
								{offset: 1, color: '#fb1c52'}
							]
						)
				}
			},
		},
		{
			name: 'Total Sales',
			symbolSize:20,
			barWidth: 20,
			type: 'bar',
			data: [13, 17, 19, 22, 17, 11, 19, 20, 17, 19, 25, 17, 11, 19],
			symbolSize:5,
			itemStyle: {
				normal: { barBorderRadius: [50 ,50, 0 ,0],
						color: new echarts.graphic.LinearGradient(
							0, 0, 0, 1,
							[
								{offset: 0, color: '#705ec8'},
								{offset: 1, color: '#20c2fa'}

							]
						)
				}
			},
		}
	];
	var chart = document.getElementById('echart1');
	var barChart = echarts.init(chart);
	var option = {
		grid: {
		  top: '6',
		  right: '0',
		  bottom: '17',
		  left: '25',
		},
		xAxis: {
		  data: [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		  axisLine: {
			lineStyle: {
			  color: 'rgba(67, 87, 133, .09)'
			}
		  },
		  axisLabel: {
			fontSize: 10,
			color: '#8e9cad'
		  }
		},
		tooltip: {
			show: true,
			showContent: true,
			alwaysShowContent: true,
			triggerOn: 'mousemove',
			trigger: 'axis',
			axisPointer:
			{
				label: {
					show: false,
				}
			}

		},
		yAxis: {
		  splitLine: {
			lineStyle: {
			  color: 'rgba(67, 87, 133, .09)'
			}
		  },
		  axisLine: {
			lineStyle: {
			  color: 'rgba(67, 87, 133, .09)'
			}
		  },
		  axisLabel: {
			fontSize: 10,
			color: '#8e9cad'
		  }
		},
		series: chartdata,
		color:[ '#ef6430', '#2205bf']
	};
	barChart.setOption(option);
	/* E-chart */


	/*sparkline*/
    var randomizeArray = function (arg) {
		var array = arg.slice();
		var currentIndex = array.length,
		temporaryValue, randomIndex;
		while (0 !== currentIndex) {
			randomIndex = Math.floor(Math.random() * currentIndex);
			currentIndex -= 1;

			temporaryValue = array[currentIndex];
			array[currentIndex] = array[randomIndex];
			array[randomIndex] = temporaryValue;
		}
		return array;
    }

	var sparklineData = [0, 45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46];
	//Spark1
    var spark1 = {
      chart: {
        type: 'area',
        height: 60,
        sparkline: {
          enabled: true
        },
		dropShadow: {
			enabled: true,
			blur: 3,
			opacity: 0.2,
		}
		},
		stroke: {
			show: true,
			curve: 'smooth',
			lineCap: 'butt',
			colors: undefined,
			width: 2,
			dashArray: 0,
		},
      fill: {
        gradient: {
          enabled: false
        }
      },
	  tooltip: {
		enabled: false,
	  },
      series: [{
		name: 'Total Sales',
        data: randomizeArray(sparklineData)
      }],
      yaxis: {
        min: 0
      },
      colors: ['#fa057a'],

    }
	var spark1 = new ApexCharts(document.querySelector("#spark1"), spark1);
    spark1.render();

	var sparklineData2 = [0, 45, 93, 53, 61, 27, 54, 43, 19, 46, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 31];
	//Spark2
    var spark2 = {
      chart: {
        type: 'area',
        height: 60,
        sparkline: {
          enabled: true
        },
		dropShadow: {
			enabled: true,
			blur: 3,
			opacity: 0.2,
		}
		},
		stroke: {
			show: true,
			curve: 'smooth',
			lineCap: 'butt',
			colors: undefined,
			width: 2,
			dashArray: 0,
		},
		fill: {
        gradient: {
          enabled: false
        }
      },
	   tooltip: {
		enabled: false,
	  },
      series: [{
		name: 'Total User',
        data: randomizeArray(sparklineData2)
      }],
      yaxis: {
        min: 0
      },
      colors: ['#2dce89'],

    }
	var spark2 = new ApexCharts(document.querySelector("#spark2"), spark2);
    spark2.render();

	var sparklineData3 = [0, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46,45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51];
	//Spark3
    var spark3 = {
      chart: {
        type: 'area',
        height: 60,
        sparkline: {
          enabled: true
        },
		dropShadow: {
			enabled: true,
			blur: 3,
			opacity: 0.2,
		}
		},
		stroke: {
			show: true,
			curve: 'smooth',
			lineCap: 'butt',
			colors: undefined,
			width: 2,
			dashArray: 0,
		},
		fill: {
        gradient: {
          enabled: false
        }
      },
	   tooltip: {
		enabled: false,
	  },
      series: [{
		name: 'Total Income',
        data: randomizeArray(sparklineData3)
      }],
      yaxis: {
        min: 0
      },
      colors: ['#ff5b51'],

    }
	var spark3 = new ApexCharts(document.querySelector("#spark3"), spark3);
    spark3.render();

	var sparklineData4 = [0, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46,45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51];
	//Spark4
    var spark4 = {
      chart: {
        type: 'area',
        height: 60,
        sparkline: {
          enabled: true
        },
		dropShadow: {
			enabled: true,
			blur: 3,
			opacity: 0.2,
		}
		},
		stroke: {
			show: true,
			curve: 'smooth',
			lineCap: 'butt',
			colors: undefined,
			width: 2,
			dashArray: 0,
		},
		fill: {
        gradient: {
          enabled: false
        }
      },
	   tooltip: {
		enabled: false,
	  },
      series: [{
		name: 'Total Tax',
        data: randomizeArray(sparklineData3)
      }],
      yaxis: {
        min: 0
      },
      colors: ['#fcbf09'],

    }
	var spark4 = new ApexCharts(document.querySelector("#spark4"), spark4);
    spark4.render();


	/*----simplebar2 JS ----*/
		var scrollbar3 = document.getElementById('scrollbar3')
		new SimpleBar(scrollbar3);
	/*-----simplebar2 JS -----*/
	

 });