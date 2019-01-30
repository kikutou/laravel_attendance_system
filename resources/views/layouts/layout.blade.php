<!DOCTYPE html>
<html>
 <head>
   <meta charset="utf-8">
   <title>@yield('title')</title>

   <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
   <link rel="stylesheet" href="{{ asset('/css/layout.css') }}">
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

 </head>
 <body>

   <div id="content" class="container-fluid">
     @yield('content')
   </div>

 </body>
</html>
