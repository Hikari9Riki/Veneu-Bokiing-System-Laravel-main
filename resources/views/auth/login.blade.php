<!DOCTYPE html>
<html>
<head>
    <title>Login - Venue System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>
    body {
        background-color: black;
    }
</style>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
        
        <form action="{{ route('login') }}" method="POST">
            @csrf <div class="mb-4">
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password" class="w-full border p-2 rounded" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
                Login
            </button>
        </form>

        @if ($errors->any())
            <p class="text-red-500 mt-4 text-sm">{{ $errors->first() }}</p>
        @endif

    </div>

    
</body>

</html>