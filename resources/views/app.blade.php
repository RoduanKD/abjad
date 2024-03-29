<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1"
        >

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link
            href="https://fonts.googleapis.com/css?family=Cairo:100,300,400,500,700,900"
            rel="stylesheet"
        >
        <link
            href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css"
            rel="stylesheet"
        >

        <!-- Styles -->
        <link
            rel="stylesheet"
            href="{{ mix('css/app.css') }}"
        >

        <!-- Scripts -->
        @routes
        <script
            src="{{ mix('js/app.js') }}"
            defer
        ></script>
        @inertiaHead
    </head>
    <body>
        @inertia

        @env ('local')
            <script src="http://localhost:8080/js/bundle.js"></script>
        @endenv
    </body>
</html>
