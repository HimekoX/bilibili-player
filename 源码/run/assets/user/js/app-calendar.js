$(function() {
	'use strict'
	// Datepicker found in left sidebar of the page
	var highlightedDays = ['2018-5-10', '2018-5-11', '2018-5-12', '2018-5-13', '2018-5-14', '2018-5-15', '2018-5-16'];
	var date = new Date();
	
	var generateTime = function(element) {
		var n = 0,
			min = 30,
			periods = [' AM', ' PM'],
			times = [],
			hours = [12, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
		for (var i = 0; i < hours.length; i++) {
			times.push(hours[i] + ':' + n + n + periods[0]);
			while (n < 60 - min) {
				times.push(hours[i] + ':' + ((n += min) < 10 ? 'O' + n : n) + periods[0])
			}
			n = 0;
		}
		times = times.concat(times.slice(0).map(function(time) {
			return time.replace(periods[0], periods[1])
		}));
		//console.log(times);
		$.each(times, function(index, val) {
			$(element).append('<option value="' + val + '">' + val + '</option>');
		});
	}
	generateTime('.main-event-time');
	// Initialize fullCalendar
	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		navLinks: true, // can click day/week names to navigate views
 		selectable: true,
 		selectHelper: true,
 		select: function(start, end) {
 			var title = prompt('Event Title:');
 			var eventData;
 			if (title) {
 				eventData = {
 					title: title,
 					start: start,
 					end: end
 				};
 				$('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
 			}
 			$('#calendar').fullCalendar('unselect');
 		},
		eventSources: [sptCalendarEvents, sptBirthdayEvents, sptHolidayEvents, sptOtherEvents],
		eventAfterAllRender: function(view) {
			if (view.name === 'listMonth' || view.name === 'listWeek') {
				var dates = view.el.find('.fc-list-heading-main');
				dates.each(function() {
					var text = $(this).text().split(' ');
					var now = moment().format('DD');
					$(this).html(text[0] + '<span>' + text[1] + '</span>');
					if (now === text[1]) {
						$(this).addClass('now');
					}
				});
			}
			console.log(view.el);
		},
		eventRender: function(event, element) {
			if (event.description) {
				element.find('.fc-list-item-title').append('<span class="fc-desc">' + event.description + '</span>');
				element.find('.fc-content').append('<span class="fc-desc">' + event.description + '</span>');
			}
			var eBorderColor = (event.source.borderColor) ? event.source.borderColor : event.borderColor;
			element.find('.fc-list-item-time').css({
				color: eBorderColor,
				borderColor: eBorderColor
			});
			element.find('.fc-list-item-title').css({
				borderColor: eBorderColor
			});
			element.css('borderLeftColor', eBorderColor);
		},
	});
	var azCalendar = $('#calendar').fullCalendar('getCalendar');
	// change view to week when in tablet
	if (window.matchMedia('(min-width: 576px)').matches) {
		azCalendar.changeView('agendaWeek');
	}
	// change view to month when in desktop
	if (window.matchMedia('(min-width: 992px)').matches) {
		azCalendar.changeView('month');
	}
	// change view based in viewport width when resize is detected
	azCalendar.option('windowResize', function(view) {
		if (view.name === 'listWeek') {
			if (window.matchMedia('(min-width: 992px)').matches) {
				azCalendar.changeView('month');
			} else {
				azCalendar.changeView('listWeek');
			}
		}
	});
	// display current date
	var azDateNow = azCalendar.getDate();
	azCalendar.option('select', function(startDate, endDate) {
		$('#modalSetSchedule').modal('show');
		$('#mainEventStartDate').val(startDate.format('LL'));
		$('#EventEndDate').val(endDate.format('LL'));
		$('#mainEventStartTime').val(startDate.format('LT')).trigger('change');
		$('#EventEndTime').val(endDate.format('LT')).trigger('change');
	});
	// Display calendar event modal
	azCalendar.on('eventClick', function(calEvent, jsEvent, view) {
		var modal = $('#modalCalendarEvent');
		modal.modal('show');
		modal.find('.event-title').text(calEvent.title);
		if (calEvent.description) {
			modal.find('.event-desc').text(calEvent.description);
			modal.find('.event-desc').prev().removeClass('d-none');
		} else {
			modal.find('.event-desc').text('');
			modal.find('.event-desc').prev().addClass('d-none');
		}
		modal.find('.event-start-date').text(moment(calEvent.start).format('LLL'));
		modal.find('.event-end-date').text(moment(calEvent.end).format('LLL'));
		//styling
		modal.find('.modal-header').css('backgroundColor', (calEvent.source.borderColor) ? calEvent.source.borderColor : calEvent.borderColor);
	});
	// Enable/disable calendar events from displaying in calendar
	$('.main-nav-calendar-event a').on('click', function(e) {
		e.preventDefault();
		if ($(this).hasClass('exclude')) {
			$(this).removeClass('exclude');
			$(this).is(':first-child') ? azCalendar.addEventSource(sptCalendarEvents) : '';
			$(this).is(':nth-child(2)') ? azCalendar.addEventSource(sptBirthdayEvents) : '';
			$(this).is(':nth-child(3)') ? azCalendar.addEventSource(sptHolidayEvents) : '';
			$(this).is(':nth-child(4)') ? azCalendar.addEventSource(sptOtherEvents) : '';
		} else {
			$(this).addClass('exclude');
			$(this).is(':first-child') ? azCalendar.removeEventSource(1) : '';
			$(this).is(':nth-child(2)') ? azCalendar.removeEventSource(2) : '';
			$(this).is(':nth-child(3)') ? azCalendar.removeEventSource(3) : '';
			$(this).is(':nth-child(4)') ? azCalendar.removeEventSource(4) : '';
		}
		azCalendar.render();
		if (window.matchMedia('(max-width: 575px)').matches) {
			$('body').removeClass('main-content-left-show');
		}
	});
})