<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
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