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
        </style>
    </head>
    <body style="background: #eee;">
        <nav class="navbar navbar-light bg-light" style="background: white !important;">
            <a class="navbar-brand" href="#">Class Attendance Monitoring</a>
        </nav>
                
        <div class="container" style="background:#F5FCFF; height: 100%; padding: 0px;">
            <div class="sidebar" style="width: 20%; height: 100%; background-color: #192841; float:left; color: white; padding: 10px 20px;">
                <ul style="padding: 0px; list-style-type: none;" class="sample">
                    <a href="/teacher/{{ $id }}" class="active">
                        <li>
                        <i class="fas fa-user-friends"></i>Classes
                        </li>
                    </a>
                    <a href="/teacher/{{ $id }}/changePassword">
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
                <div class="form-group">
                    <label>Select class section</label>
                    <select class="form-control" name="sections">
                        <option disabled selected>-- Select Section --</option>
                        @for($counter = 0; $counter < $sections->count(); $counter++)
                            <option value="{{ $sections[$counter]->sectionId }}">{{ $sections[$counter]->name }}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label>Select class subject</label>
                    <select class="form-control" name="subjects" disabled>
                        <option>-- Select Subject --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Select date</label>
                    <input id="datepicker" class="form-control" placeholder="-- Select Date --" disabled/>
                </div>
                <button class="btn btn-primary btn-attendance" id="getAttendance"> Get Attendance </button>

                <br><br><br>
                <div>
                <table class="table table-striped" id="attendanceTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Time In</th>
                            <th scope="col">Time In Remarks</th>
                            <th scope="col">Time Out</th>
                            <th scope="col">Time Out Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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