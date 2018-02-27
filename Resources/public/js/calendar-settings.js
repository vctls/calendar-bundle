$(function () {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $('#fullcalendar').fullCalendar({
        editable: true,
        header: {
            left: 'prev, next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        lazyFetching: true,
        timeFormat: 'H(:mn)',
        eventSources: [
            {
                url: Routing.generate('fullcalendar_loader'),
                type: 'GET',
                // A way to add custom filters to your event listeners
                data: {},
                error: function () {
                    alert('There was an error fetching calendar data.');
                }
            }
        ],
        eventDrop: function (event, delta, revertFunc) {
            $.ajax(Routing.generate('fullcalendarevent_edit'), {
                method: 'PATCH',
                data: {
                    id: event.id,
                    start: event.start.utc().format(),
                    end: event.end.utc().format()
                },
                success: function (data) {
                    $('#fullcalendar').fullCalendar('renderEvent',
                        data, true);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    revertFunc();
                    alert('Could not move event: ' + errorThrown);
                }
            });
        }
    });
});
