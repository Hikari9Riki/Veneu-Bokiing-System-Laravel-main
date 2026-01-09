<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IIUM Venue System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-iium-green { background-color: #007A5E; }
        .text-iium-green { color: #007A5E; }
        .bg-iium-gold { background-color: #C5A059; }
        .border-iium-gold { border-color: #C5A059; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center h-screen">

    <div class="w-full max-w-md bg-white rounded-lg shadow-xl overflow-hidden border-t-4 border-iium-gold">
        
        <div class="p-6 text-center border-b border-gray-100">
            <img src="{{ asset('logo uia.png') }}" alt="IIUM Logo" class="mx-auto h-24 w-auto object-contain mb-3" onerror="this.src='https://upload.wikimedia.org/wikipedia/en/thumb/8/8f/International_Islamic_University_Malaysia_logo.svg/1200px-International_Islamic_University_Malaysia_logo.svg.png'">
            <h2 class="text-2xl font-serif font-bold text-iium-green uppercase tracking-wide">Venue Reservation</h2>
            <p class="text-sm text-gray-500 mt-1">Please login to continue</p>
        </div>

        <div class="p-8">
            
            {{-- ERROR DISPLAY BLOCK --}}
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 text-sm">
                    <p class="font-bold">Login Failed</p>
                    <p>{{ $errors->first() }}</p>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf 
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-[#007A5E] focus:border-transparent transition" placeholder="student@iium.edu.my" required>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-[#007A5E] focus:border-transparent transition" placeholder="••••••••" required>
                </div>

                <button type="submit" class="w-full bg-iium-green text-white font-bold py-3 px-4 rounded hover:bg-[#00604a] transition duration-200 shadow-md">
                    Login
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">Don't have an account? 
                    <a href="{{ route('register') }}" class="text-iium-green font-bold hover:underline">Register here</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>