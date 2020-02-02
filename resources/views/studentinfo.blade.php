<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Teacher's Home</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="{{  URL::asset('css/all.css') }}" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
        <style>
            .fas {
                padding: 10px;
            }

            div.sidebar ul a li{
                color: #eee;
            }

            ul.sample a li:hover{
                background: #23395D;
            }

            ul.sample a.active li{
                background: #23395D;
            }

            .navbar {
                position: sticky;
                top: 0;
            }

            .btn-attendance {
                width: 200px;
            }

            .subject {
                margin: 0px;
                width: 100%;
                cursor: pointer;
                text-align: center;
            }
        </style>
    </head>
    <body style="background: #eee;">
        <nav class="navbar navbar-light bg-light" style="background: white !important;">
            <a class="navbar-brand" href="#">Class Attendance Monitoring</a>
        </nav>
                
        <div class="container" style="background:#F5FCFF; height: 100%; padding: 0px;">
            <div class="sidebar" style="width: 20%; height: 100%; background-color: #192841; float:left; color: white; padding: 10px 20px;">
                <ul style="padding: 0px; list-style-type: none;" class="sample">
                    <a href="/student/{{ $id }}" class="active">
                        <li>
                        <i class="fas fa-user-friends"></i>Schedule
                        </li>
                    </a>
                    <a href="/student/{{ $id }}/changePassword">
                        <li>
                            <i class="fas fa-cogs"></i>Change Password
                        </li>
                    </a>
                    <a href="/logout">
                        <li>
                            <i class="fas fa-user-friends"></i>Logout
                        </li>
                    </a>
                </ul>
            </div>
            <div class="content" style="width: 80%; height: 100%; float: right; padding: 20px; display: flex; flex-direction: column; overflow: scroll">
                <div class="student-info" style="height: 150px">
                    <img width="150" height="150" style="float: left"src="https://i2.wp.com/peoplaid.com/wp-content/uploads/2019/03/James-Reid.jpg?w=469&ssl=1 469w, https://i2.wp.com/peoplaid.com/wp-content/uploads/2019/03/James-Reid.jpg?resize=150%2C150&ssl=1 150w, https://i2.wp.com/peoplaid.com/wp-content/uploads/2019/03/James-Reid.jpg?resize=298%2C300&ssl=1 298w, https://i2.wp.com/peoplaid.com/wp-content/uploads/2019/03/James-Reid.jpg?resize=60%2C60&ssl=1 60w"/>
                    <div style="float: left; height: 150px; display: flex; flex-direction: column; justify-content: center; padding: 20px;">
                        <div>Name: <b>{{ $student->firstName }} {{ $student->lastName }}</b></div>
                        <div>Grade & Section: <b>{{ $student->grade }} - {{ $student->section }}</b></div>
                        <div>Academic Track: <b>{{ $student->track }}</b></div>
                        <div>Adviser: <b>{{ $student->adviser }}</b></div>
                    </div>
                </div>
                <br>
                <br>
                <div class="schedule">
                    <div class="schedule-title" style="text-align: center;">
                        <h3>SCHEDULE</h3>
                        <div style="margin: 0 auto;">Click the subjects to see your attendance</div>
                    </div>
                    <div>
                        <table class="table table-bordered table-striped " style="margin: 20px auto;" id="schedule">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Time</th>
                                    <th>Monday</th>
                                    <th>Tuesday</th>
                                    <th>Wednesday</th>
                                    <th>Thursday</th>
                                    <th>Friday</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($counter = 0; $counter < count($timeframes); $counter++)
                                    <tr>
                                        <td>{{ $timeframes[$counter] }}</td>
                                        
                                        @for($day = 1; $day <= 5; $day++)
                                            @php
                                                $flag = false;
                                            @endphp

                                            @for($counter2 = 0; $counter2 < count($schedules); $counter2++)
                                                @if($schedules[$counter2]->timeframe == $timeframes[$counter] && $day == $schedules[$counter2]->day)
                                                @php
                                                    $url = 'attendance/'.Auth::user()->id.'?';
                                                    $url .= 'scheduleId='.$schedules[$counter2]->scheduleId;
                                                @endphp
                                                <td><a href="/<?php echo $url ?>"><label class="subject">{{ $schedules[$counter2]->subject }}</label></a></td>
                                                    @php
                                                        $flag = true;
                                                    @endphp
                                                @endif
                                            @endfor

                                            @if($flag == false)
                                                <td></td>
                                            @endif
                                        @endfor
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- SCRIPT BELOW -->
        <script>
            $('#datepicker').datepicker({
                uiLibrary: 'bootstrap4',
            });
            $(document).ready(function() {
                $('select[name="sections"]').on('change', function() {
                    var sectionId = $(this).val();
                    if(sectionId) {
                        $.ajax({
                            url: '/teacher/2/getSubjects/'+encodeURI(sectionId),
                            type: "GET",
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success:function(data) {
                                $('select[name="subjects"]').empty();
                                $('select[name="subjects"]').append('<option disabled selected>-- Select Subject --</option>');
                                $('select[name="subjects"]').removeAttr('disabled');
                                
                                if(data.length > 0) {
                                    $.each(data, function(key, value) {
                                        $('select[name="subjects"]').append('<option value="'+ value['id'] +'">'+ value['name'] +'</option>');
                                    });
                                } else {
                                    $('select[name="subjects"]').attr({
                                        'disabled': 'disabled'
                                    });
                                    $('select[name="subjects"]').empty();
                                    $('select[name="subjects"]').append('<option disabled selected>-- Select Subject --</option>');
                                }
                            }
                        });
                    }else{
                        $('select[name="subjects"]').attr({
                            'disabled': 'disabled'
                        });
                        $('select[name="subjects"]').empty();
                        $('select[name="subjects"]').append('<option disabled selected>-- Select Subject --</option>');
                    }
                });


                $('select[name="subjects"]').on('change', function() {
                    $('input[id="datepicker"]').removeAttr('disabled');
                });

                $('button[id="getAttendance"]').on('click', function() {
                    var scheduleId = $('select[name="subjects"]').val();
                    var date = $('input[id="datepicker"]').val();
                    var apiurl = '/teacher/{{ $id }}/getAttendance?'+ 'scheduleId=' + scheduleId + '&date=' + date;
                    $.ajax({
                        url: apiurl,
                        type: "GET",
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success:function(data) {
                            console.log(data)
                            if(data.length == 0) {
                                $("#attendanceTable > tbody").html("");
                            } else {
                                $("#attendanceTable > tbody").html("");
                                var counter = 1;
                                $.each(data, function(key, value) {
                                    console.log(value);
                                    var row = 
                                    `
                                        <tr>
                                            <td>`+counter+`</td>
                                            <td>`+value['studentName']+`</td>
                                            <td>`+value['timeIn']+`</td>
                                            <td>`+value['timeInRemarks']+`</td>
                                            <td>`+value['timeOut']+`</td>
                                            <td>`+value['timeOutRemarks']+`</td>
                                        </tr>
                                    `;
                                    $('#attendanceTable > tbody:last-child').append(row);
                                    counter++;
                                });
                            }
                        },
                        error: function(request, status, error) {
                            console.log(request.responseText);
                        }
                    });
                });
            });
        </script>
    </body>
</html>
<!--DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login</title>


        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="{{ URL::asset('css/studentinfo.css') }}" rel="stylesheet"> 
    </head>
    <body>
    <div class="container">
            
        </div>
    </body>
</html-->
