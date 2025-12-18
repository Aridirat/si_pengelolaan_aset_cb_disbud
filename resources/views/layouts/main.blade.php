<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Sistem Pengelolaan Aset Cagar Budaya</title>

    <link rel="icon" type="image/png" href="{{ asset('../assets/images/logo-lesbud.png') }}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>


</head>

<body class="bg-blue-50 text-gray-900 ">

<div class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="bg-white text-white shrink-0 fixed inset-y-0 left-0 z-50">
        @include('layouts.sidebar')
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex flex-col flex-1 ml-56">
        @include('layouts.navbar')

        <!-- NAVBAR (FIXED) -->

        <!-- CONTENT (SCROLLABLE) -->
        <main class="overflow-y-auto h-full">
            @yield('content')
        </main>
    </div>

</div>

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 1800
    });
</script>
@endif

<!-- Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</body>
</html>