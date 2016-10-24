<?php
    include 'db_connect.php';
    /*  The clear button uses both Javascript and PHP when the button is pressed
     *  the Javascript function clearCalendar() is called to clear the javascript
     *  calender, and if there is a clear command in the post, all post data is 
     *  cleared to prevent the form from repopulating with old data.
     */
    if(isset($_POST['clear'])) {
        $_POST = array();
    }
?>
<!DOCTYPE html>
<head>
<link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
<script src='lib/jquery.min.js'></script>
<script src='lib/moment.min.js'></script>
<script src='fullcalendar/fullcalendar.min.js'></script>
<!-- Mixing PHP and Javascript... that's not terrible design or anything... -->
<script>
    //Helper function use to clear the calendar.
    var defaultDate = $('#calendar').fullCalendar('today');
    function clearCalendar() {
        $('#calendar').fullCalendar('removeEvents'); 
    }
    
    
    //Wait for the document to load before anything is rendered
    $(document).ready(function() {
        
    var dates = [];
    //No seriously, nothing can go wrong here...  It's legit I looked this up
    //on Stackoverflow:  http://stackoverflow.com/questions/1961069/getting-value-get-or-post-variable-using-javascript
    //This grabs post data via PHP so I can use it to repopulate the calendar's event
    var postStart = '<?php if (isset($_POST['start'])) {
                        echo $_POST['start'];

                       } else {
                            echo '';
                       }
                    ?>';
    var postEnd = '<?php if (isset($_POST['end'])) {
                        echo $_POST['end'];

                    } else {
                        echo '';
                    }
                ?>';

    //If there is post data, create a new moment object from the dates so
    //a new event object can be created and rendered
    if (postStart != '' && postEnd != '') {

        var momentStart = $.fullCalendar.moment(postStart);
        var momentEnd = $.fullCalendar.moment(postEnd);

        var postEvent = {
            id: 'postEvent',
            title: "",
            start: momentStart.format(),
            end: momentEnd.add(1, 'd').format()
        };  
        document.getElementById('dateStart').value = momentStart.format();
        document.getElementById('dateEnd').value = momentEnd.subtract(1,'d').format();
        defaultDate=momentStart;
        
    }
    else {
        var postEvent = {
            id: 'postEvent',
            title: "",
            start: '1900-01-01',
            end: '1900-01-01'
        };
    }

    
    //Initialize the calendar
    $('#calendar').fullCalendar({
        defaultDate: defaultDate,
        selectable: true,
        aspectRatio: 1,
        header: {
            left: 'prevYear, prev',
            center: 'title',
            right: 'next, nextYear'
            
        },
        events: [postEvent],
        
        //When two dates are clicked, an event is created.  If a third date is clicked
        //the event is destroyed and dayClick waits for two more dates to re-render the event
        dayClick: function(date) {
           dates.push(date);
           //If there was an existing event created from the post data, remove it so
           //the user can create a new event.
           $('#calendar').fullCalendar('removeEvents', 'postEvent');
           
           if (dates.length > 1) {
               
               var start = dates[dates.length - 2];
               var end = dates[dates.length - 1];
            
               if (start.isBefore(end)) {
                    var event = {
                       title: "",
                       start: start.format(),
                       end: end.add(1, 'd').format()
                   };
                   document.getElementById('dateStart').value = start.format();
                   document.getElementById('dateEnd').value = end.subtract(1,'d').format();
               } else if(end.isBefore(start)){
                   var event = {
                       title: "",
                       start: end.format(),
                       end: start.add(1,'d').format()
                   };
                   document.getElementById('dateStart').value = end.format();
                   document.getElementById('dateEnd').value = start.subtract(1,'d').format();
               }
               $('#calendar').fullCalendar('removeEvents');
               $('#calendar').fullCalendar('renderEvent', event, true);
               document.forms['filter'].submit();
           }
           
        },
    })
    
   
});
</script>


</head>
<body>
    <div style="position:relative">
        <div id='calendar' style="height:100%;width:25%;float:left;margin:10px">
            <br/>
            <form action='index.php' method='post' name='filter'>
                
                Name Search:
                <input type='text' name='playerName' value='<?=isset($_POST['playerName'])?$_POST['playerName']:''?>' autofocus>
                <input type='hidden' id='dateStart' name='start' value=''>
                <input type='hidden' id='dateEnd' name='end' value=''>
                <input type='submit' style='float:right' value='Submit'>
                <input type='submit' style='float:right' name='clear' value='Clear' onclick='clearCalendar();'>
                <select name='result' onchange='this.form.submit()'>
                    <option value=''>Any</option>
                    <option value='p1wins' <?=(isset($_POST['result'])&& $_POST['result'] == 'p1wins')?'selected':''?>>Player 1</option>
                    <option value='p2wins' <?=(isset($_POST['result'])&& $_POST['result'] == 'p2wins')?'selected':''?>>Player 2</option>
                    <option value='draw'  <?=(isset($_POST['result'])&& $_POST['result'] == 'draw')?'selected':''?>>Draw</option>
                </select>
             </form>
        

            
            <?php
                if(isset($_POST['id'])) {
                    include 'details.php';
                }
            ?>
        </div>
        <div style ='padding-bottom: 10px;float:left;height:100%;margin:10px;overflow:scroll;overflow-x:hidden'>
           
            <?php include 'output.php'?>
            <!-- IMPORTANT:  The form tag ends after the output include to also include the details image button from the output-->
        </div>
    </div>
    
    
</body>





