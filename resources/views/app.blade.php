<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Maye Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">
   <nav class="bg-blue-600 p-4 shadow-lg mb-6">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-white text-2xl font-bold uppercase tracking-widest">Maye Store</h1>
        
        @auth
        <div class="flex items-center space-x-4">
            @if(Auth::user()->role == 'admin')
                <a href="{{ url('/register') }}" class="bg-white text-blue-600 hover:bg-blue-50 px-3 py-1 rounded text-[10px] font-bold uppercase transition shadow-sm">
                    + Add New User
                </a>
            @endif

            <span class="text-white text-xs font-semibold">
                Hi, {{ Auth::user()->name }}! ({{ strtoupper(Auth::user()->role) }})
            </span>
            
            <form action="{{ url('/logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-bold uppercase transition">
                    Logout
                </button>
            </form>
        </div>
        @endauth
    </div>
</nav>

    <div class="container mx-auto px-4">
        @yield('main-content')
    </div>
</body>
</html>