<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <script src="{{ asset('js/app.js') }}" ></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
      @include('layout/header')
      @include('layout/menu')
    <div class="container mb-3">
      @yield('content')
    </div>
    <footer class="footer bg-dark  fixed-bottom">
      @include('layout/footer')
    </footer>


</body>
</html>