<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Admin</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="{{  URL::asset('css/all.css') }}" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <!-- <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" /> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
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
                
        <div class="container-fluid" style="background:#F5FCFF; height: 100%; padding: 0px;">
            @include('common.adminsidebar', ['id' => $id, 'selected' => 'schedules'])
            <div class="content" style="width: 80%; height: 100%; float: right; padding: 20px; display: flex; flex-direction: column; overflow: scroll">
                <form action="/admin/schedules/add" method="POST">
                    @csrf
                    <div class="form-group" >
                        <label for="subject">Subject</label>
                        <select class="form-control" id="subject" name="subject">
                            @for($counter = 0; $counter < $subjects->count(); $counter++)
                                <option value="{{$subjects[$counter]->subjectId}}">{{$subjects[$counter]->name.' - '.$subjects[$counter]->teacher}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group" >
                        <label for="section">Section</label>
                        <select class="form-control" id="section" name="section">
                            @for($counter = 0; $counter < $sections->count(); $counter++)
                                <option value="{{$sections[$counter]->sectionId}}">{{$sections[$counter]->name}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group" >
                        <label for="day">Time From</label>
                        <input id="timeFrom" name="timeFrom" class="form-control">
                    </div>
                    <div class="form-group" >
                        <label for="day">Time To</label>
                        <input id="timeTo" name="timeTo" class="form-control">
                    </div>
                    <div class="form-group" >
                        <label for="day">Day Of The Week</label>
                        <select class="form-control" id="day" name="day">
                            <option value="1">Monday</option>
                            <option value="2">Tuesday</option>
                            <option value="3">Wednesday</option>
                            <option value="4">Thursday</option>
                            <option value="5">Friday</option>
                        </select>
                    </div>
                    @if ( session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div style="padding-top: 10px;">
                        <button type="submit" class="btn btn-primary" style="width: 200px;">Add Section</button>
                    </div>
                </form>
            </div>
        </div>

    </body>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#timeFrom').timepicker({ 
                timeFormat: 'H:mm',
                interval: 30,
                minTime: '7',
                maxTime: '19:00',
                defaultTime: '7:30',
                startTime: '7:00am',
                dynamic: false,
                dropdown: true,
                scrollbar: true
             });
             $('#timeTo').timepicker({ 
                timeFormat: 'H:mm',
                interval: 30,
                minTime: '7',
                maxTime: '19:00',
                defaultTime: '8:30',
                startTime: '7:00am',
                dynamic: false,
                dropdown: true,
                scrollbar: true
             });
        });
    </script>
</html>