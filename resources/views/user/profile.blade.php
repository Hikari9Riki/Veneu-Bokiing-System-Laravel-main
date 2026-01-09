<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - IIUM Venue Reservation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-iium-green { background-color: #007A5E; }
        .text-iium-green { color: #007A5E; }
        .bg-iium-gold { background-color: #C5A059; }
        .border-iium-gold { border-color: #C5A059; }
    </style>
</head>
<body class="bg-gray-50 font-sans h-screen flex flex-col">

    <header class="bg-white border-b-4 border-iium-gold shadow-sm px-6 py-3 shrink-0">
        <div class="flex items-center justify-between">
            <img src="{{ asset('logo uia.png') }}" class="h-12 w-auto" onerror="this.src='https://upload.wikimedia.org/wikipedia/en/thumb/8/8f/International_Islamic_University_Malaysia_logo.svg/1200px-International_Islamic_University_Malaysia_logo.svg.png'">
            <h1 class="text-xl font-serif font-bold text-iium-green uppercase tracking-wide">VENUE RESERVATION SYSTEM</h1>
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden">
        <div class="w-64 bg-white border-r shadow-inner flex flex-col shrink-0">
            <div class="p-6 text-center border-b border-gray-100 bg-gray-50">
                <div class="w-20 h-20 bg-gray-200 rounded-full mx-auto mb-3 flex items-center justify-center border-2 border-iium-gold">
                    <span class="text-3xl">👤</span>
                </div>
                <h2 class="font-bold text-lg text-iium-green">{{ Auth::user()->name }}</h2>
                <p class="text-xs text-gray-500 uppercase tracking-wide">User Profile</p>
            </div>
            <nav class="flex-1 mt-2">
                <a href="{{ route('dashboard') }}" class="block py-3 px-6 text-gray-600 hover:bg-gray-100 hover:text-iium-green transition border-l-4 border-transparent">Dashboard</a>
                <a href="{{ route('reservations.index') }}" class="block py-3 px-6 text-gray-600 hover:bg-gray-100 hover:text-iium-green transition border-l-4 border-transparent">My Reservation</a>
                <a href="{{ route('reservations.create') }}" class="block py-3 px-6 text-gray-600 hover:bg-gray-100 hover:text-iium-green transition border-l-4 border-transparent">Make Reservation</a>
                <a href="{{ route('profile.show') }}" class="block py-3 px-6 bg-iium-green text-white font-bold border-l-4 border-iium-gold shadow">User Detail</a>
            </nav>
             <div class="p-4 border-t">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 rounded text-sm font-bold">Log Out</button>
                </form>
            </div>
        </div>

        <div class="flex-1 p-10 overflow-y-auto bg-gray-50">
            <h2 class="text-3xl font-serif font-bold text-gray-800 mb-6 border-b-2 border-iium-gold inline-block pb-2">User Details</h2>

            <div class="bg-white rounded-lg shadow-md border border-gray-200 max-w-4xl flex overflow-hidden">
                <div class="w-1/3 bg-gray-50 p-8 text-center border-r border-gray-200 flex flex-col items-center justify-center">
                    <div class="w-32 h-32 bg-white rounded-full mb-4 flex items-center justify-center border-4 border-iium-gold shadow-sm">
                        <span class="text-5xl text-gray-300">📷</span>
                    </div>
                    <p class="text-sm text-gray-500">Profile Picture</p>
                </div>

                <div class="w-2/3 p-8">
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 text-sm">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 text-sm">
                            <ul>@foreach ($errors->all() as $error) <li>- {{ $error }}</li> @endforeach</ul>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-4">
                            <label class="block text-xs font-bold uppercase mb-1 text-gray-500">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-300 p-2 rounded focus:border-[#007A5E] focus:ring-1 focus:ring-[#007A5E]">
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-bold uppercase mb-1 text-gray-500">Phone</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full border border-gray-300 p-2 rounded focus:border-[#007A5E]">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase mb-1 text-gray-500">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-gray-300 p-2 rounded focus:border-[#007A5E]">
                            </div>
                        </div>
                        <hr class="my-6 border-gray-200">
                        <div class="mb-4">
                            <label class="block text-xs font-bold uppercase mb-1 text-gray-500">New Password (Optional)</label>
                            <input type="password" name="password" class="w-full border border-gray-300 p-2 rounded focus:border-[#007A5E]">
                        </div>
                        <div class="mb-6">
                            <label class="block text-xs font-bold uppercase mb-1 text-gray-500">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="w-full border border-gray-300 p-2 rounded focus:border-[#007A5E]">
                        </div>
                        <div class="text-right">
                            <button type="submit" class="bg-iium-green text-white font-bold py-2 px-6 rounded text-sm hover:bg-[#005f49] shadow-md">Update Details</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>