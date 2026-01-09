<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - IIUM Venue System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-iium-green { background-color: #007A5E; }
        .text-iium-green { color: #007A5E; }
        .border-iium-gold { border-color: #C5A059; }
        .text-iium-gold { color: #C5A059; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen py-10">

    <div class="w-full max-w-lg bg-white rounded-lg shadow-xl overflow-hidden border-t-4 border-iium-gold">
        
        <div class="p-6 text-center border-b border-gray-100">
            <h2 class="text-2xl font-serif font-bold text-iium-green uppercase">Student Registration</h2>
            <p class="text-sm text-gray-500 mt-1">Create your account to book venues</p>
        </div>

        <div class="p-8">
            {{-- ERROR DISPLAY BLOCK --}}
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 text-sm">
                    <p class="font-bold">Registration Failed</p>
                    <ul class="list-disc list-inside mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 p-3 rounded focus:ring-2 focus:ring-[#007A5E] outline-none transition" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 p-3 rounded focus:ring-2 focus:ring-[#007A5E] outline-none transition" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Phone Number</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full border border-gray-300 p-3 rounded focus:ring-2 focus:ring-[#007A5E] outline-none transition" required>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                        <input type="password" name="password" class="w-full border border-gray-300 p-3 rounded focus:ring-2 focus:ring-[#007A5E] outline-none transition" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Confirm</label>
                        <input type="password" name="password_confirmation" class="w-full border border-gray-300 p-3 rounded focus:ring-2 focus:ring-[#007A5E] outline-none transition" required>
                    </div>
                </div>

                <button type="submit" class="w-full bg-iium-green text-white font-bold py-3 px-4 rounded hover:bg-[#00604a] transition duration-200 shadow-md">
                    Register Account
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-iium-green font-medium">Already have an account? Login</a>
            </div>
        </div>
    </div>

</body>
</html>