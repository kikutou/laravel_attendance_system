<!DOCTYPE html>
<html>
 <head>
   <meta charset="utf-8">
   <title>@yield('title')</title>

   <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
   <link rel="stylesheet" href="{{ asset('/css/layout.css') }}">

 </head>
 <body>

   <div id="content" class="container-fluid">
     @yield('content')
   </div>

 </body>
</html>
