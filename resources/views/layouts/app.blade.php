<!DOCTYPE html>
<html>
<head>
    <title>Venue Booking System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">Venue Booking</h1>
            @guest
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
            @endguest
            @auth
                <div class="flex items-center gap-4">
                    <span>{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700">Logout</button>
                    </form>
                    <form method="GET" action="{{ route('dashboard') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700">Dashboard</button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    @stack('scripts')    
</body>
</html>
