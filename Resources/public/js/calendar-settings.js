$(function () {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    function modalNew(start, end) {
        var url = Routing.generate('fullcalendarevent_new');
        var $dialog = $('<div></div>')
            .load(url + "?start=" + start + "&end=" + end)
            .dialog({
                autoOpen: false,
                title: 'New event',
                width: 500,
                height: 300
            });
        $dialog.dialog('open');
    }

    $('#fullcalendar').fullCalendar({
        editable: true,
        selectable: true,
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
        },
        select: function (start, end){
            // 'start' and 'end' are Moment objects.
            modalNew(start.format('X'), end.format('X'));
        }
    });
});
