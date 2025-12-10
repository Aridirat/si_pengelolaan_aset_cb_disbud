@php
    $menus = [
        (object) [
            "title" => "Dashboard", 
            "path" => "/dashboard", 
            "icon" => "fas fa-tachometer-alt",
            "active" => request()->is('dashboard')
        ],
        (object) [
            "title" => "Cagar Budaya", 
            "path" => "cagar_budaya", 
            "icon" => "fas fa-theater-masks",
            "active" => request()->is('cagar_budaya*')
        ],
        (object) [
            "title" => "Mutasi Data", 
            "path" => "mutasi_data", 
            "icon" => "fas fa-landmark",
            "active" => request()->is('mutasi_data*')
        ],
        (object) [
            "title" => "Pemugaran", 
            "path" => "pemugaran", 
            "icon" => "fas fa-calendar-alt",
            "active" => request()->is('pemugaran*')
        ],
        (object) [
            "title" => "Mutasi", 
            "path" => "mutasi", 
            "icon" => "fas fa-exchange-alt",
            "active" => request()->is('mutasi*')
        ],
        (object) [
            "title" => "Penghapusan", 
            "path" => "penghapusan", 
            "icon" => "fas fa-trash-alt",
            "active" => request()->is('penghapusan*')
        ],
        (object) [
            "title" => "Pengguna", 
            "path" => "user", 
            "icon" => "fas fa-users",
            "active" => request()->is('user*')
        ],
    ];
@endphp

<aside class="w-64 min-h-screen bg-gray-700 shadow-md px-6 py-8">
    <div class="text-center mb-5">
        <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" 
             alt="Your Company" 
             class="mx-auto h-10 w-10" />
    </div>

    <hr class="mb-5">

    <nav class="text-sm font-medium">
        <ul class="flex flex-col">
            @foreach ($menus as $menu)
                <li class="my-2">
                    <a href="{{ url($menu->path) }}"
                        class="
                            nav-link 
                            text-base block 
                            hover:text-blue-300
                            {{ $menu->active ? 'text-blue-400 font-bold' : 'text-gray-400' }}
                        ">
                        
                        <i class="nav-icon {{ $menu->icon }}"></i>
                        <span class="ml-2">{{ $menu->title }}</span>

                        @if($menu->active && request()->segment(2))
                            {{-- @php
                                $sub = request()->segment(2);
                                $subLabel = match (true) {
                                    $sub === 'create' => 'Tambah',
                                    is_numeric($sub) => 'Edit',
                                    default => strtoupper($sub)
                                };
                            @endphp --}}
                            {{-- <span class="right badge badge-light text-dark">{{ $subLabel }}</span> --}}
                        @endif

                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <hr class="my-5">

    <div class="mt-5">
        <form action="/logout" method="post">
            @csrf
    
            <button 
                type="submit" 
                class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded">
                Logout
            </button>
        </form>
    </div>
</aside>

