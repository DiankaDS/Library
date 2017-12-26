<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Books') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <style>
        body {
            /*background-image: url('http://tianyihengfeng.com/wp-content/uploads/2016/07/website-background-wallpapers.jpg');*/
            background-color: #cccccc;
        }
    </style>

</head>

<body>
    <div id="admin">
        <nav class="navbar navbar-inverse">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Books') }}
                    </a>

                    <a class="navbar-brand" href="{{ url('admin_users') }}"> Admin page </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->

                        <li><a href="admin_users"> Users </a></li>

                        <li><a href="admin_books"> Books </a></li>

                        <li><a href="admin_authors"> Authors </a></li>

                        <li><a href="admin_genres"> Genres </a></li>

                        <li><a href="admin_orders"> Orders </a></li>

                        <li><a href="admin_reviews"> Reviews </a></li>

                        <li><a href="admin_tags"> Tags </a></li>

                        <li><a href="admin_formats"> Formats </a></li>

                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body" align="center"></div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" id="YesButton">Yes, continue</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal">No, back</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script type="text/javascript" src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css') }}"/>

</body>
</html>
