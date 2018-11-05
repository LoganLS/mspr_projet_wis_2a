<?php
    session_start();
    $title='';
    $description='';
?>
<?php include_once('layouts/header.php');?>
<main>
    <div id='calendar-container'>
        <div id='calendar'></div>
    </div>
    <script>
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
            
            
            
            
            
        ]
    });
});
    </script>
</main>
<?php include_once('layouts/footer.php');?>