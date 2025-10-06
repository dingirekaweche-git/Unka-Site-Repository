<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Unka Go')</title>
    @vite('resources/css/app.css') {{-- Tailwind CSS --}}
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="min-h-screen">
        <main class="min-h-screen flex items-center justify-center px-6 py-8">
    @yield('content')
</main>
    </div>
</body>
</html>
