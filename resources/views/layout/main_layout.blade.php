<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  @livewireStyles()
  @vite('resources/css/app.css')
</head>
<body>
  <main>
    @yield('content')
  </main>
<script src="{{ asset('js/script.js') }}"></script>
@livewireScripts()
</body>
</html>