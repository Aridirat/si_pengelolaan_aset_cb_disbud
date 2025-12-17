<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Login Sistem</title>
    <link rel="icon" type="image/png" href="{{ asset('../assets/images/logo-lesbud.png') }}"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="h-screen">
<div class="flex">
  <div class="flex flex-col w-64 flex-1 min-h-screen justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img src="{{ asset('../assets/images/logo-lesbud.png') }}" alt="Your Company" class="mx-auto h-30 w-auto" />
        <h2 class="mt-3 text-center text-2xl/9 font-bold tracking-tight">Login</h2>
    </div>
  
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form action="/login" method="POST" class="space-y-6" novalidate>
                @csrf
        <div>
          <label for="username" class="block text-sm/6 font-medium ">Username</label>
          <div class="mt-2">
            <input id="username" type="username" name="username" autocomplete="username" class="block w-full rounded-md px-3 py-1.5 text-base  outline-1 -outline-offset-1 outline-gray-900/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-sky-400 sm:text-sm/6 shadow-sm" />
          </div>
          @error('username')
              <p class="mt-1 text-sm text-red-600">
                  {{ $message }}
              </p>
          @enderror
        </div>
  
        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm/6 font-medium ">Password</label>
            <div class="text-sm">
              {{-- <a href="#" class="font-semibold text-sky-400 hover:text-sky-400">Forgot password?</a> --}}
            </div>
          </div>
          <div class="mt-2 input-group">
            <input id="password" type="password" name="password" autocomplete="current-password" class="block w-full rounded-md px-3 py-1.5 text-base  outline-1 -outline-offset-1 outline-gray-900/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-sky-400 sm:text-sm/6 shadow-sm" />
            <span class="input-group-text" onclick="togglePasswordVisibility()">
                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
            </span>
                  <script>
                  function togglePasswordVisibility() {
                    const passwordField = document.getElementById('password');
                    const toggleIcon = document.getElementById('togglePasswordIcon');
                    if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                    } else {
                    passwordField.type = 'password';
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                    }
                  }
                  </script>
          </div>
          @error('password')
              <p class="mt-1 text-sm text-red-600">
                  {{ $message }}
              </p>
          @enderror
        </div>
  
        <div class="grid grid-cols-3 gap-5">
          <div class="col-start-3">
            <button type="submit" class="btn flex w-full justify-center rounded-md bg-linear-to-r from-blue-600 to-sky-500 px-3 py-1.5 text-white text-sm/6 font-semibold hover:from-blue-800 hover:to-sky-800 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500 shadow-lg shadow-sky-500/50">Masuk</button>
          </div>
        </div>
      </form>
  
    </div>
  </div>

<div class="relative min-h-screen flex flex-col justify-center px-6 lg:px-8 pb-20">

  <!-- Background SVG -->
  <div 
    class="absolute inset-0 bg-cover bg-center"
    style="
      background-image: url('{{ asset('assets/images/login_baner.svg') }}');
      filter: grayscale(100%);
    ">
  </div>

  <!-- Overlay gelap agar teks terbaca -->
  <div class="absolute inset-0 bg-linear-to-b from-sky-600/70 to-blue-700/70"></div>

  <!-- Konten -->
  <div class="relative z-10">
    <div class="mb-20">
      <h1 class="text-white text-2xl font-bold text-center">
        Sistem Informasi Pengelolaan Aset Cagar Budaya
      </h1>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-sm justify-center flex">
      <img 
        src="{{ asset('assets/images/logo-lesbud.png') }}" 
        alt="Logo"
        class="h-60 w-60"
      />
    </div>
  </div>

</div>



</div>

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil Masuk',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 1800
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal Masuk',
        text: "{{ session('error') }}",
        showConfirmButton: true,
    });
</script>
@endif

</body>
</html>