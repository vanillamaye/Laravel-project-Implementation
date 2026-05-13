<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-96 border-t-4 border-blue-600">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-600 uppercase tracking-widest">Login</h2>
        
        @if(session('error'))
            <div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-sm font-bold text-center">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 text-green-600 p-3 rounded mb-4 text-sm font-bold text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-xs font-bold mb-2 uppercase">Email:</label>
                <input type="email" name="email" class="w-full p-2 border rounded focus:outline-none focus:border-blue-500" placeholder="admin@test.com" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-xs font-bold mb-2 uppercase">Password:</label>
                <input type="password" name="password" class="w-full p-2 border rounded focus:outline-none focus:border-blue-500" placeholder="********" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded hover:bg-blue-700 transition duration-200 uppercase tracking-tighter">
                SIGN IN
            </button>
        </form>

    
    </div>
</body>
</html>