<!DOCTYPE html>

<html>
  <head>

    <!--BootstrapのCSS読み込み-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.css') }}">
    <!--jQueryの読み込み-->
    <script type="text/javascript" src="{{ asset('/js/jquery-3.4.1.js') }}"></script>
    <!--Bootstrap.JSの読み込み-->
    <script type="text/javascript" src="{{ asset('/js/bootstrap.js') }}" defer></script>

    <!--todo.cssの読み込み -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/todo.css') }}">
    <title>@yield('title')</title>
  </head>
  <body>
    <div class="container">
      @yield('content')
    </div>
  </body>
</html>
