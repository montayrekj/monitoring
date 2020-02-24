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
                
        <div class="container-fluid" style="background:#F5FCFF; height: 100%; padding: 0px;">
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
                <div style="text-align: center;">
                    <h3 style="width: 50%; margin: 0 auto;">{{ $subject->name }}</h3>
                    <p>{{ $subject->teacherName }}</p>

                    <div>
                        <table style="margin: 20px auto;" class="table table-bordered table-striped">
                            <thead style="background:white;">
                                <tr>
                                    <td colspan="5" style="text-align: center">EVERY {{ $schedule->dayOfWeek }}</td>
                                </tr>
                            </thead>
                            <thead class="thead-dark"> 
                                <tr>
                                    <th>Date</th>
                                    <th>Time In</th>
                                    <th>Remarks</th>
                                    <th>Time Out</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($counter = 0; $counter < $attendance->count(); $counter++)
                                    <tr>
                                        <td>{{ $attendance[$counter]->date }}</td>
                                        <td>{{ $attendance[$counter]->timeIn }}</td>
                                        <td>{{ $attendance[$counter]->timeInRemarks }}</td>
                                        <td>{{ $attendance[$counter]->timeOut }}</td>
                                        <td>{{ $attendance[$counter]->timeOutRemarks }}</td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
    <div class="container-fluid">
            
        </div>
    </body>
</html-->

<html>
    <head>
        <title>Menu</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <div class="container-fluid">
            
        </div>
    </body>
</html>