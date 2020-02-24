<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Register</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        
    </head>
    <body>
        <div class="card" style="height: 820px; width: 600px; position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
            <form action="/student/register" method="POST" enctype="multipart/form-data" style="padding: 25px 50px 50px 50px">
                @csrf
                <div class="form-group" >
                    <label for="firstname">First Name</label>
                    <input type="text" required class="form-control" id="firstname" name="firstname" placeholder="Enter first name">
                </div>
                <div class="form-group" >
                    <label for="lastname">Last Name</label>
                    <input type="text" required class="form-control" id="lastname" name="lastname" placeholder="Enter last name">
                </div>
                <div class="form-group">
                    <label>Grade</label>
                    <select class="form-control" required name="grade">
                        <option disabled selected>-- Select Your Grade --</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Section</label>
                    <select class="form-control" required name="section">
                        <option disabled selected>-- Select Your Section --</option>
                        @for($counter = 0; $counter < $sections->count(); $counter++)
                            <option value="{{ $sections[$counter]->sectionId }}">{{ $sections[$counter]->name }}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label>Track</label>
                    <select class="form-control" required name="track">
                        <option disabled selected>-- Select Your Track --</option>
                        @for($counter = 0; $counter < $tracks->count(); $counter++)
                            <option value="{{ $tracks[$counter]->trackId }}">{{ $tracks[$counter]->name }}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group" >
                    <label for="username">Username</label>
                    <input type="text" required class="form-control" id="username" name="username" placeholder="Enter username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" required class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="imageInput">Profile Picture</label><br>
                    <input data-preview="#preview" name="input_img" type="file" id="imageInput">
                    <img class="col-sm-6" id="preview"  src="">
                </div>
                @if ( session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if ( session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div style="text-align: center;">
                    <button type="submit" class="btn btn-primary" style="width: 100px;">Register</button>
                </div>
            </form>
        </div>
    </body>
</html>
