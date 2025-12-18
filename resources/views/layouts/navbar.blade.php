<header class="bg-linear-to-r from-sky-600 to-sky-900 border-b border-gray-200 px-6 py-4 flex items-center justify-end h-15">
            <!-- Right Icons -->
            <div class="flex items-center gap-6">
                <!-- User Info -->
                <div class="flex items-center gap-2">
                    <div>
                        <p class="text-sm text-white font-medium">{{ Auth::user()->nama }}</p>
                    </div>
                    <span>
                        <i class="fas fa-user-circle text-xl text-white"></i>
                    </span>
                </div>
            </div>
        </header>