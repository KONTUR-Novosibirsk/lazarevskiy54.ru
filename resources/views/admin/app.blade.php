<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="icon" type="image/x-icon" href="{{ asset('/' . settings('favicon', default: 'default-favicon.ico')) }}">
    <title inertia>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet"
          href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css') }}">
    @routes
    @vite(['resources/admin/sass/dashboard.scss', 'resources/admin/js/dashboard.js', "resources/admin/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>
<body>
@inertia
</body>
</html>
