<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 1rem;
            }
        </style>

    </head>
    <body>
        <h1>
            <img class="title-area-logo" src="https://wwwcdn.bigcommerce.com/www1.bigcommerce.com/assets/logos/bc-logo-dark.svg" alt="">
            @yield('title')
        </h1>

        <nav>
            <ul>
                <li>
                    <a href="/customers">Customers</a>
                </li>
            </ul>
        </nav>

        @yield('content')
    </body>
</html>
