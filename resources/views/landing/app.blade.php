<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Core Plasma - Kuasai Materi</title>

    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">

    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body>

    @include('landing.header')

    <main>
        @yield('content')
    </main>

    @include('landing.footer')

</body>
</html>
