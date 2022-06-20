<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', '@Master Layout'))</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin-style.css') }}">
    <script type="text/javascript" src="{{ URL::asset('js/script.js') }}"></script>

    @yield('styles')
</head>

<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Admin Panel</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span
                            class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Page 1-1</a></li>
                        <li><a href="#">Page 1-2</a></li>
                        <li><a href="#">Page 1-3</a></li>
                    </ul>
                </li>
                <li><a href="#">Page 2</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-user">Hi</span></a></li>
                <li><a href="#"><span class="glyphicon glyphicon-log-in"></span></a></li>
            </ul>

        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                <a href="/users"
                    class="list-group-item @if (isset($currentPage) && $currentPage == 'users') active @endif">Users
                    Management</a>
                <a href="/products"
                    class="list-group-item @if (isset($currentPage) && $currentPage == 'products') active @endif">Products
                    Management</a>
            </div>
            <div class="col-sm-9">
                @yield('content')
            </div>
        </div>
    </div>
    <div class="col-sm-12" style="background-color: #ccc">
        <footer class="page-footer font-small blue pt-4">
            <div class="container-fluid text-center text-md-left">
                <div class="row">
                    <div class="col-md-12 mt-md-0 mt-3">
                        <h5 class="text-uppercase">Học Laravel 2022</h5>
                        <p>Email: <a href="mailto:nguyenhuumanhit@gmail.com">nguyenhuumanhit@gmail.com</a></p>
                        <p>Phone: 0797.924.070</p>
                    </div>
                </div>
            </div>
        </footer>
        @yield('scripts')
</body>

</html>