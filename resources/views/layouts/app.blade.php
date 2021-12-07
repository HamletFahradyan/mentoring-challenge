<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mentoring challenge</title>
    <!-- Styles -->
    @yield('style')
</head>
<body>
@yield('content')

@yield('script')
</body>
</html>
