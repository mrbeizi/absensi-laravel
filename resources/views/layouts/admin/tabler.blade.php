
<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta16
* @link https://tabler.io
* Copyright 2018-2022 The Tabler Authors
* Copyright 2018-2022 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Dashboard - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
    <!-- CSS files -->
    <link href="{{asset('tabler/dist/css/tabler.min.css?1668287865')}}" rel="stylesheet"/>
    <link href="{{asset('tabler/dist/css/tabler-flags.min.css?1668287865')}}" rel="stylesheet"/>
    <link href="{{asset('tabler/dist/css/tabler-payments.min.css?1668287865')}}" rel="stylesheet"/>
    <link href="{{asset('tabler/dist/css/tabler-vendors.min.css?1668287865')}}" rel="stylesheet"/>
    <link href="{{asset('tabler/dist/css/demo.min.css?1668287865')}}" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: Inter, -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
    </style>
  </head>
  <body >
    <script src="{{asset('tabler/dist/js/demo-theme.min.js?1668287865')}}"></script>
    <div class="page">
      <!-- Sidebar -->
      @include('layouts.admin.sidebar')
      <!-- Navbar -->
      @include('layouts.admin.header')
      <div class="page-wrapper"> 
        @yield('content')       
        @include('layouts.admin.footer')
      </div>
    </div>
    <!-- Libs JS -->
    <script src="{{asset('tabler/dist/libs/apexcharts/dist/apexcharts.min.js?1668287865')}}" defer></script>
    <script src="{{asset('tabler/dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1668287865')}}" defer></script>
    <script src="{{asset('tabler/dist/libs/jsvectormap/dist/maps/world.js?1668287865')}}" defer></script>
    <script src="{{asset('tabler/dist/libs/jsvectormap/dist/maps/world-merc.js?1668287865')}}" defer></script>
    <!-- Tabler Core -->
    <script src="{{asset('tabler/dist/js/tabler.min.js?1668287865')}}" defer></script>
    <script src="{{asset('tabler/dist/js/demo.min.js?1668287865')}}" defer></script>
  </body>
</html>