<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-blue-50 text-gray-900 ">

<div class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gray-700 text-white shrink-0 fixed inset-y-0 left-0 z-50">
        @include('layouts.sidebar')
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex flex-col flex-1 ml-64">
        @include('layouts.navbar')

        <!-- NAVBAR (FIXED) -->

        <!-- CONTENT (SCROLLABLE) -->
        <main class="overflow-y-auto h-full">
            @yield('content')
        </main>
    </div>

</div>


<!-- Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

</body>
</html>