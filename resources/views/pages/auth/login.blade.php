<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Login Sistem</title>
</head>

<body class="h-screen">
<div class="flex">
  <div class="flex flex-col w-64 flex-1 min-h-screen justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" class="mx-auto h-10 w-auto" />
      <h2 class="mt-5 text-center text-2xl/9 font-bold tracking-tight">Login</h2>
    </div>
  
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form action="/login" method="POST" class="space-y-6">
                @csrf
        <div>
          <label for="username" class="block text-sm/6 font-medium ">Username</label>
          <div class="mt-2">
            <input id="username" type="username" name="username" required autocomplete="username" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base  outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
          </div>
        </div>
  
        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm/6 font-medium ">Password</label>
            <div class="text-sm">
              {{-- <a href="#" class="font-semibold text-indigo-400 hover:text-indigo-300">Forgot password?</a> --}}
            </div>
          </div>
          <div class="mt-2 input-group">
            <input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base  outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
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
        </div>
  
        <div class="grid grid-cols-3 gap-5">
          <div class="col-start-3">
            <button type="submit" class="btn flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-white text-sm/6 font-semibold  hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Masuk</button>
          </div>
        </div>
      </form>
  
    </div>
  </div>
  <div class="flex flex-col w-64 flex-1 min-h-screen justify-center px-6 lg:px-8 pb-20 bg-gray-700">
    <div class="mb-20">
      <h1 class="text-white text-2xl font-bold text-center">Sistem Informasi Pengelolaan Aset Cagar Budaya</h1>
    </div>
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" class="aspect-2/1" />
    </div>
  </div>
</div>

</body>
</html>