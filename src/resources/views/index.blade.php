<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8"/>
        <meta name="csrf_token" content="{{  csrf_token() }}" id="csrf_token">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lexend+Deca&display=swap">
        <link rel="stylesheet" type="text/css" href="{{ url('/css/app.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('/css/event.css') }}">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous">

        <meta property="og:image" content="https://autumn.fluffici.eu/attachments/eI0QemKZhF6W9EYnDl5JcBGYGvPiIxjPzvrDY_9Klk" />
        <meta property="og:image:secure_url" content="https://autumn.fluffici.eu/attachments/eI0QemKZhF6W9EYnDl5JcBGYGvPiIxjPzvrDY_9Klk" />
        <meta property="og:image:type" content="image/png" />
        <meta property="og:image:width" content="128" />

        <meta name="og:title" content="@yield('title') • Fluffici"/>
        <meta name="og:type" content="summary"/>

        <meta name="og:description" content="@yield('description')"/>

        <meta name="copyright" content="Fluffici Z.S">
        <meta name="webmaster" content="Vakea, vakea@fluffici.eu">

        <meta name="contact" content="administrace@fluffici.eu">

        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta content="yes" name="apple-touch-fullscreen" />
        <meta name="apple-mobile-web-app-status-bar-style" content="red">
        <meta name="format-detection" content="telephone=no">
        <meta name="theme-color" content="#FF002E">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">

        @yield('head')

        <title>@yield('title') - Fluffici</title>
    </head>
   <body>
        <x-fluffici-aside/>

        <main class="main-content">
            <section class="dashboard-section">
                <h2>@yield('title')</h2>
            </section>

            @yield('content')
        </main>

        <script src="{{ url('/js/app.js') }}"></script>
        @yield('modals')
        @yield('script')
    </body>
</html>
