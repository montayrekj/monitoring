<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        
    </head>
    <body>
        <div class="card" style="height: 600px; width: 600px; position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
            <img src="https://upload.wikimedia.org/wikipedia/en/8/8a/Cebu_Institute_of_Technology_-_University_Logo.jpg" width="150" height="150" style="margin: 50px auto;"/>
            <form action="/auth" method="POST" style="padding: 25px 50px 50px 50px">
                @csrf
                <div class="form-group" >
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                @if ( session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <label>Don't have an account? Sign up <a href="/student/register">here!</a></label>
                <div style="text-align: center;padding-top: 10px;">
                    <button type="submit" class="btn btn-primary" style="width: 100px;">Login</button>
                </div>
            </form>
        </div>
    </body>
</html>
