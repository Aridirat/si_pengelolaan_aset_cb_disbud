<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-blue-50 text-gray-900">

<div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-64 min-h-screen bg-blue-200 shadow-md px-6 py-8">

        <div class="text-center mb-10">
            <div class="w-20 h-20 bg-blue-300 rounded-full mx-auto flex items-center justify-center text-xl font-bold">
                Logo
            </div>
        </div>

        <nav class="space-y-4 text-lg font-medium">
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-blue-200 border border-blue-300 text-blue-900 font-medium">
                <span class="material-icons-outlined">dashboard</span>
                Dashboard
            </a>
            <a href="#" class="block hover:text-blue-700">Cagar Budaya</a>
            <a href="#" class="block hover:text-blue-700">Pemugaran</a>
            <a href="#" class="block hover:text-blue-700">Mutasi</a>
            <a href="#" class="block hover:text-blue-700">Penghapusan</a>
            <a href="#" class="block hover:text-blue-700">Pengguna</a>
        </nav>

        <div class="mt-10">
            <form action="/logout" method="post">
            @csrf
            @method('POST')
            <button type="submit" class="btn w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded">Logout</button>
          </form>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1">

        <!-- TOP BAR -->
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-end">
            <!-- Right Icons -->
            <div class="flex items-center gap-6">
                <!-- User Info -->
                <div class="flex items-center gap-3">
                    <div>
                        <p class="text-sm font-medium">{{ Auth::user()->nama }}</p>
                    </div>
                </div>

            </div>

        </header>

        <!-- CAGAR BUDAYA -->
        <section class="bg-white p-6 rounded-xl shadow mb-8">
            <h2 class="text-lg font-semibold mb-4">Cagar Budaya</h2>

            <div class="grid grid-cols-3 gap-4">
                <div class="bg-blue-100 p-5 rounded-lg shadow text-center">
                    <p class="font-medium">Kondisi Baik</p>
                    <p class="text-3xl font-bold mt-2">10</p>
                </div>

                <div class="bg-blue-100 p-5 rounded-lg shadow text-center">
                    <p class="font-medium">Kondisi Rusak Ringan</p>
                    <p class="text-3xl font-bold mt-2">10</p>
                </div>

                <div class="bg-blue-100 p-5 rounded-lg shadow text-center">
                    <p class="font-medium">Kondisi Rusak Berat</p>
                    <p class="text-3xl font-bold mt-2">10</p>
                </div>
            </div>
        </section>

        <!-- MUTASI DATA -->
        <section class="bg-white p-6 rounded-xl shadow mb-8">
            <h2 class="text-lg font-semibold mb-4">Mutasi Data</h2>

            <div class="grid grid-cols-3 gap-4 items-center">
                <div class="bg-blue-100 p-5 rounded-lg shadow text-center">
                    <p class="font-medium">Total Mutasi Data</p>
                    <p class="text-3xl font-bold mt-2">10</p>
                </div>

                <div class="flex flex-col">
                    <label class="font-medium mb-2">Filter Berdasarkan:</label>
                    <select class="border border-gray-300 rounded p-2">
                        <option>Field 1</option>
                        <option>Field 2</option>
                        <option>Field 3</option>
                    </select>
                </div>

                <div class="bg-blue-100 p-5 rounded-lg shadow text-center">
                    <p class="font-medium">10</p>
                </div>
            </div>
        </section>

        <!-- PEMUGARAN -->
        <section class="bg-white p-6 rounded-xl shadow mb-8">
            <h2 class="text-lg font-semibold mb-4">Pemugaran</h2>

            <div class="grid grid-cols-6 gap-4">
                @foreach (['Pending','Diproses','Selesai','Menunggu','Disetujui','Ditolak'] as $status)
                <div class="bg-blue-100 p-5 rounded-lg shadow text-center">
                    <p class="font-medium">Status {{ $status }}</p>
                    <p class="text-3xl font-bold mt-2">10</p>
                </div>
                @endforeach
            </div>
        </section>

        <!-- MUTASI -->
        <section class="bg-white p-6 rounded-xl shadow mb-8">
            <h2 class="text-lg font-semibold mb-4">Mutasi</h2>

            <div class="grid grid-cols-6 gap-4">
                @foreach (['Pending','Diproses','Selesai','Menunggu','Disetujui','Ditolak'] as $status)
                <div class="bg-blue-100 p-5 rounded-lg shadow text-center">
                    <p class="font-medium">Status {{ $status }}</p>
                    <p class="text-3xl font-bold mt-2">10</p>
                </div>
                @endforeach
            </div>
        </section>

        <!-- PENGHAPUSAN -->
        <section class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-semibold mb-4">Penghapusan</h2>

            <div class="grid grid-cols-6 gap-4">
                @foreach (['Pending','Diproses','Selesai','Menunggu','Disetujui','Ditolak'] as $status)
                <div class="bg-blue-100 p-5 rounded-lg shadow text-center">
                    <p class="font-medium">Status {{ $status }}</p>
                    <p class="text-3xl font-bold mt-2">10</p>
                </div>
                @endforeach
            </div>
        </section>

    </main>

</div>


<body class="bg-gray-50">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-blue-100 border-r border-blue-200 p-6 flex flex-col">

        <!-- Logo -->
        <div class="flex items-center gap-3 mb-10">
            <div class="w-10 h-10 bg-blue-600 text-white rounded-lg flex items-center justify-center font-bold text-lg">
                T
            </div>
            <span class="text-xl font-semibold text-blue-800">TailPanel</span>
        </div>

        <!-- Menu -->
        <nav class="flex-1 space-y-2">

            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-blue-200 border border-blue-300 text-blue-900 font-medium">
                <span class="material-icons-outlined">dashboard</span>
                Dashboard
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-blue-200 rounded-lg font-medium">
                <span class="material-icons-outlined">analytics</span>
                Analytics
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-blue-200 rounded-lg font-medium">
                <span class="material-icons-outlined">group</span>
                User Management
            </a>

            <a href="#" class="flex items-center justify-between px-4 py-3 hover:bg-blue-200 rounded-lg font-medium">
                <div class="flex items-center gap-3">
                    <span class="material-icons-outlined">rocket_launch</span>
                    Showcase
                </div>
                <span class="material-icons-outlined text-sm">expand_more</span>
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-blue-200 rounded-lg font-medium">
                <span class="material-icons-outlined">shopping_cart</span>
                E-Commerce
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-blue-200 rounded-lg font-medium">
                <span class="material-icons-outlined">show_chart</span>
                Charts
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-blue-200 rounded-lg font-medium">
                <span class="material-icons-outlined">table_chart</span>
                Tables
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-blue-200 rounded-lg font-medium">
                <span class="material-icons-outlined">article</span>
                Forms
            </a>
        </nav>

        <!-- Footer User -->
        <div class="mt-10 flex items-center gap-3 p-3 bg-white border border-gray-300 rounded-lg shadow-sm">
            <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-semibold">
                AS
            </div>
            <div>
                <p class="font-medium text-gray-800">Admin User</p>
                <p class="text-sm text-gray-500">admin@example.com</p>
            </div>
        </div>

    </aside>

    <!-- CONTENT AREA -->
    <div class="flex-1 flex flex-col">

        <!-- NAVBAR -->
        

        <!-- MAIN CONTENT -->
        <main class="p-6">
            <h1 class="text-3xl font-bold mb-2">Dashboard Overview</h1>
            <p class="text-gray-600 mb-6">Welcome back! Here's what's happening today.</p>

            <!-- Tempat konten dashboard Anda -->
        </main>

    </div>

</div>

<!-- Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">



</body>
</html>
