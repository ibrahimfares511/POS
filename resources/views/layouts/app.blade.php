<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="icon" href="{{URL::asset('pos_style/images/route.jfif')}}" type="image/x-icon" />

  <title>
    @php
        if(isset($title))
        {
            echo $title;
        }
        else{
            echo "POS";
        }
    @endphp

</title>
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;700;900&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('pos_style/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('pos_style/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('pos_style/css/cute-alert.css') }}" rel="stylesheet">
  <link href="{{ asset('pos_style/css/style.css') }}" rel="stylesheet">
  <script src="{{asset('pos_style/js/jquery-3.5.1.min.js')}}"></script>

</head>
<body>

  @include('includes.navbar')
  @yield('content')

  <!-- /#page-content-wrapper -->
    <script src="{{ asset('pos_style/js/popper-1.16.0.js')}}"></script>
    <script src="{{ asset('pos_style/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('pos_style/js/cute-alert.js')}}"></script>
    <script src="{{ asset('pos_style/js/main.js')}}"></script>
    <script src="{{ asset('pos_style/js/table2excel.js')}}"></script>
    <script src="{{ asset('pos_style/js/html2pdf.bundle.min.js')}}"></script>
    <link href="{{ asset('js/app.js') }}" rel="stylesheet">

    <div class="custom-alert"></div>
</body>
</html>
