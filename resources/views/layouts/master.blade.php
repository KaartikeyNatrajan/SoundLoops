<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sound Loops | {{ $title or 'home' }}</title>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    @yield('css')

    <!-- Scripts -->
    <script>
        
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>

    </script>
</head>
<body>
    @include('navbar')
    
    @yield('content')

    <!-- Scripts -->
    <script src="/js/external-dependencies/jquery-3.1.1.js"></script>
    <script src="/js/external-dependencies/bootstrap.js"></script>
    <script src="/js/external-dependencies/vue.js"></script>
    <script src="/js/external-dependencies/vue-resources.js"></script>
   
    @yield('scripts')

</body>
</html>