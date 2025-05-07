<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Appliance Geekz</title>
        @viteReactRefresh
        @vite(['resources/js/src/main.jsx', 'resources/css/app.css'])
    </head>
    <body>
        <div id="loading">Loading...</div>
        <div id="root"></div>
        <script>
            window.AccessToken = @json(session('token'));
            window.user = @json(auth()->user());
        </script>
    </body>
</html>
