<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Admin</title>
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
            @include('common.adminsidebar', ['id' => $id, 'selected' => 'changePassword'])
            <div class="content" style="width: 80%; height: 100%; float: right; padding: 20px; display: flex; flex-direction: column; overflow: scroll">
                <form action="/admin/{{$id}}/changePassword" method="POST">
                    @csrf
                    <div class="form-group" >
                        <label for="currentPassword">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Enter current password">
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter new password">
                    </div>
                    @if ( session('error') )
                        <div class="alert alert-danger">
                            {{ session('error')  }}
                        </div>
                    @endif
                    @if ( session('success') )
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div>
                        <button type="submit" class="btn btn-primary" style="width: 150px;">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>