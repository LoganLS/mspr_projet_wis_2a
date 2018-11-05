$(document).ready(function(){          
    $('#calendar').fullCalendar({
        locale:'fr',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
        columnFormat:'dddd',
        events:[
            {
              title: 'All Day Event',
              start: '2018-11-05'
            },
            {
              title: 'Long Event',
              start: '2018-11-07',
              end: '2018-11-10'
            }
        ]
    });
});