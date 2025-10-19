<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Task Manager')</title>
    <link rel="stylesheet" href="{{ asset('css/top.css') }}">
</head>
<body>
    <header>
        <h2>Task Manager</h2>
    </header>

    <main>
        @yield('content')   
    </main>

    @yield('scripts')
</body>
</html>