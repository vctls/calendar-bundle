$(function () {

    var fullcalendar = $('#fullcalendar');

    var urlNew = Routing.generate('fullcalendarevent_new');
    var urlEdit = Routing.generate('fullcalendarevent_edit');
    // TODO Find a way of dynamically define the event class name and form type.
    var className = '';
    var formType = "";

    function modal(url) {
        var $dialog = $('<div id="modalEventForm"></div>')
            .load(url, function () {
                initAjaxForm(this);
            })
            .dialog({
                autoOpen: false,
                title: 'New event',
                width: 500,
                height: 300,
                modal: true
            });
        $dialog.dialog('open');
    }

    function initAjaxForm(modal) {
        $(modal).on('submit', '.ajaxForm', function (e) {
            e.preventDefault();

            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize()
            })
                .done(function () {
                    fullcalendar.fullCalendar('refetchEvents');
                    $(modal).dialog('close');
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    if (typeof jqXHR.responseJSON !== 'undefined') {
                        if (jqXHR.responseJSON.hasOwnProperty('form')) {
                            $('#form_body').html(jqXHR.responseJSON.form);
                        }

                        $('.form_error').html(jqXHR.responseJSON.message);

                    } else {
                        alert(errorThrown);
                    }
                });
        });
    }

    fullcalendar.fullCalendar({
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
        select: function (start, end){
            // 'start' and 'end' are Moment objects.
            modal(
                urlNew + "?start=" + start.format('X') + "&end=" + end.format('X') + "&class=" + className + "&formType=" + formType
            );
        },
        eventDrop: function (event, delta, revertFunc) {
            $.ajax(Routing.generate('fullcalendarevent_drop'), {
                method: 'PATCH',
                data: {
                    class: event.class,
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
        eventResize: function (event) {
            $.ajax(Routing.generate('fullcalendarevent_resize'), {
                method: 'PATCH',
                data: {
                    class: event.class,
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
        eventClick: function(event) {
            modal(urlEdit + "?id=" + event.id + "&class=" + event.class + "&formType=" + formType)
        }
    });
});
