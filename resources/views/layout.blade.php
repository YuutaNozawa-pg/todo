<!DOCTYPE html>

<html>
  <head>
    <!--jQueryの読み込み-->
    <script type="text/javascript" src="{{ asset('/js/jquery-3.4.1.js') }}" defer></script>
    <!--Bootstrap.JSの読み込み-->
    <script type="text/javascript" src="{{ asset('/js/bootstrap.js') }}" defer></script>
    <!--モーダルウィンドウ動かすのに使う -->
    <script type="text/javascript" src="{{ asset('/js/jquery-ui.js') }}" defer></script>
    <!--Sortable.min.js -->
    <script type="text/javascript" src="{{ asset('/js/Sortable.min.js') }}" defer></script>


    <!--BootstrapのCSS読み込み-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.css') }}">
    <!--todo.cssの読み込み -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/todo.css') }}">
    <!--header.cssの読み込み -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/header.css') }}">

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
  </head>
  <body>
    <header>
      <a href="/home">
        <p>Todo</p>
      </a>
      <div class="user-name">
        {{ Auth::user()->name }}
      </div>
    </header>

    <div class="container">
      @yield('content')
    </div>
  </body>
</html>
