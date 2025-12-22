@php

$userRole = auth()->user()->role;

    $menus = [
        (object) [
            "title" => "Dashboard", 
            "path" => "/dashboard", 
            "icon" => "fas fa-gauge",
            "active" => request()->segment(1) === 'dashboard'
        ],
        (object) [
            "title" => "Cagar Budaya", 
            "path" => "cagar_budaya", 
            "icon" => "fas fa-gem",
            "active" => request()->segment(1) === 'cagar_budaya'
        ],
        (object) [
            "title" => "Mutasi Data", 
            "path" => "mutasi_data", 
            "icon" => "fas fa-database",
            "active" => request()->segment(1) === 'mutasi_data'
        ],
        (object) [
            "title" => "Pemugaran", 
            "path" => "pemugaran", 
            "icon" => "fas fa-hammer",
            "active" => request()->segment(1) === 'pemugaran'
        ],
        (object) [
            "title" => "Mutasi", 
            "path" => "mutasi", 
            "icon" => "fas fa-arrow-right-arrow-left",
            "active" => request()->segment(1) === 'mutasi'
        ],
        (object) [
            "title" => "Penghapusan", 
            "path" => "penghapusan", 
            "icon" => "fas fa-file-circle-minus",
            "active" => request()->segment(1) === 'penghapusan'
        ],
    ];

    // Menu khusus admin
    if ($userRole === 'admin') {
        $menus[] = (object) [
            "title" => "Pengguna", 
            "path" => "user", 
            "icon" => "fas fa-users",
            "active" => request()->segment(1) === 'user'
        ];
    }
@endphp



<aside class="w-56 min-h-screen bg-sky-950 px-6 py-2 shadow-md shadow-blue-500/50">
    <div class="text-center mb-2">
    <img src="{{ asset('../assets/images/logo-lesbud.png') }}" 
             alt="Your Company" 
             class="mx-auto h-15 w-15 transition duration-300 ease-in-out hover:scale-105" />
    </div>

    <hr class="mb-5 text-slate-600">

    <nav class="text-sm font-medium">
        <ul class="flex flex-col">
            @foreach ($menus as $menu)
                <li class="my-1">
                    <a 
                        href="{{ url($menu->path) }}"
                        class="
                            flex items-center px-4 py-2 rounded-md transition 
                            text-base
                            {{ 
                                $menu->active 
                                    ? 'bg-linear-to-r from-blue-700 to-sky-600 shadow-md shadow-blue-500/30 text-white hover:bg-sky-900/30 font-bold duration-300 ease-in-out hover:scale-105' 
                                    : 'text-gray-500 hover:bg-sky-900/40 hover:text-white font-medium duration-200'
                            }}
                        "
                    >
                        <i class="nav-icon {{ $menu->icon }}"></i>
                        <span class="ml-3">{{ $menu->title }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>


    <hr class="my-5 text-slate-600">

    <div class="mt-5">
        <form action="/logout" method="post">
            @csrf
    
            <button 
                type="submit" 
                class="w-full font-bold bg-linear-to-r from-red-600 to-rose-500 hover:from-red-800 hover:to-rose-800 shadow-md shadow-red-500/40 text-white py-2 rounded transition duration-300 ease-in-out hover:translate-y-0.5 hover:scale-99">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</aside>

