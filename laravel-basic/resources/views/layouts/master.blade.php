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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"  />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    @yield('styles')
</head>

<body>
    <nav class="navbar navbar">
        <div class="container">
            @if (isset($authUser))
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> Hi {{ $authUser->name }} </a></li>
                <li><a href="/logout"><span class="glyphicon glyphicon-log-in"></span> Log out</a></li>
            </ul>
            @endif
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
                <a href="/posts"
                    class="list-group-item @if (isset($currentPage) && $currentPage == 'posts') active @endif">Posts
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