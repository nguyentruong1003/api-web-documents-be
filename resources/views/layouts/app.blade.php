<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
  <!-- Font Awesome -->
  {{-- <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css"> --}}
  <!-- icheck bootstrap -->
  {{-- <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css"> --}}
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Custom css -->
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="login-page" style="min-height: 496.391px;">
    @yield('content')
    <!-- Scripts -->
    @livewireScripts
</body>
</html>
