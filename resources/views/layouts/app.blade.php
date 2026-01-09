<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Reservation System - IIUM</title>
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- AlpineJS (Required for Modals/Dropdowns) --}}
    <script src="//unpkg.com/alpinejs" defer></script>
    
    <style>
        /* IIUM Corporate Colors */
        .bg-iium-green { background-color: #007A5E; }
        .text-iium-green { color: #007A5E; }
        .border-iium-green { border-color: #007A5E; }
        
        .bg-iium-gold { background-color: #C5A059; }
        .text-iium-gold { color: #C5A059; }
        .border-iium-gold { border-color: #C5A059; }

        /* Custom Hover for Green Buttons */
        .hover\:bg-iium-dark:hover { background-color: #00604a; }
        
        /* Scrollbar styling for sidebar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    </style>
</head>
<body class="bg-gray-50 font-sans h-screen flex flex-col">

    {{-- HEADER SECTION --}}
    <header class="bg-white border-b-4 border-iium-gold shadow-sm px-6 py-3 shrink-0 z-20">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            {{-- Logo Area --}}
            <div class="w-full md:w-3/4 max-w-4xl">
                 <img src="{{ asset('logo uia.png') }}" alt="IIUM Banner" class="w-full h-auto object-contain" style="max-height: 80px;" onerror="this.src='https://upload.wikimedia.org/wikipedia/en/thumb/8/8f/International_Islamic_University_Malaysia_logo.svg/1200px-International_Islamic_University_Malaysia_logo.svg.png'; this.style.height='50px'; this.style.width='auto';">
            </div>
            
            {{-- Title Area --}}
            <div class="text-center md:text-right whitespace-nowrap">
                <div class="h-10 w-1 bg-iium-gold inline-block align-middle mr-3 hidden md:inline-block"></div>
                <div class="inline-block align-middle">
                    <h1 class="text-xl md:text-2xl font-serif font-bold text-iium-green uppercase tracking-wide">VENUE RESERVATION SYSTEM</h1>
                </div>
            </div>
        </div>
    </header>

    {{-- MAIN LAYOUT (Sidebar + Content) --}}
    <div class="flex flex-1 overflow-hidden">
        
        {{-- SIDEBAR --}}
        <div class="w-64 bg-white border-r shadow-inner flex flex-col shrink-0 z-10 hidden md:flex">
            {{-- User Profile Snippet --}}
            <div class="p-6 text-center border-b border-gray-100 bg-gray-50">
                <div class="w-20 h-20 bg-gray-200 rounded-full mx-auto mb-3 flex items-center justify-center border-2 border-iium-gold shadow-sm">
                    <span class="text-3xl">👤</span>
                </div>
                <h2 class="font-bold text-lg text-iium-green">{{ Auth::user()->name ?? 'Guest' }}</h2>
                
                {{-- Show role badge --}}
                @if(Auth::user()->role === 'admin')
                    <span class="bg-iium-gold text-white text-[10px] px-2 py-0.5 rounded-full uppercase font-bold tracking-wider">Administrator</span>
                @else
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Student ID: {{ Auth::user()->id ?? 'N/A' }}</p>
                @endif
            </div>
            
            {{-- Navigation Links --}}
            <nav class="flex-1 mt-2 overflow-y-auto">
                
                {{-- 🟢 ADMIN MENU --}}
                @if(Auth::user()->role === 'admin')
                    
                    <div class="px-6 pt-4 pb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Admin Management</div>

                    {{-- Admin Dashboard --}}
                    <a href="{{ route('admin.dashboard') }}" 
                       class="block py-3 px-6 transition border-l-4 {{ request()->routeIs('admin.dashboard') ? 'bg-iium-green text-white font-bold border-iium-gold shadow' : 'text-gray-600 hover:bg-gray-100 hover:text-iium-green border-transparent' }}">
                        Dashboard
                    </a>

                    {{-- Manage Venues (Update Venue) --}}
                    <a href="{{ route('venues.index') }}" 
                       class="block py-3 px-6 transition border-l-4 {{ request()->routeIs('venues.*') ? 'bg-iium-green text-white font-bold border-iium-gold shadow' : 'text-gray-600 hover:bg-gray-100 hover:text-iium-green border-transparent' }}">
                        Manage Venues
                    </a>

                    {{-- Manage Users (Update User) --}}
                    <a href="{{ route('admin.users.index') }}" 
                       class="block py-3 px-6 transition border-l-4 {{ request()->routeIs('admin.users.*') ? 'bg-iium-green text-white font-bold border-iium-gold shadow' : 'text-gray-600 hover:bg-gray-100 hover:text-iium-green border-transparent' }}">
                        Manage Users
                    </a>

                {{-- 🟢 STUDENT/NORMAL MENU --}}
                @else

                    <div class="px-6 pt-4 pb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Main Menu</div>

                    {{-- Dashboard --}}
                    <a href="{{ route('dashboard') }}" 
                       class="block py-3 px-6 transition border-l-4 {{ request()->routeIs('dashboard') ? 'bg-iium-green text-white font-bold border-iium-gold shadow' : 'text-gray-600 hover:bg-gray-100 hover:text-iium-green border-transparent' }}">
                        Dashboard
                    </a>

                    {{-- My Reservation --}}
                    <a href="{{ route('dashboard.reservation') }}" 
                       class="block py-3 px-6 transition border-l-4 {{ request()->routeIs('dashboard.reservation') ? 'bg-iium-green text-white font-bold border-iium-gold shadow' : 'text-gray-600 hover:bg-gray-100 hover:text-iium-green border-transparent' }}">
                        My Reservation
                    </a>

                    {{-- Make Reservation --}}
                    <a href="{{ route('reservations.create') }}" 
                       class="block py-3 px-6 transition border-l-4 {{ request()->routeIs('reservations.create') ? 'bg-iium-green text-white font-bold border-iium-gold shadow' : 'text-gray-600 hover:bg-gray-100 hover:text-iium-green border-transparent' }}">
                        Make Reservation
                    </a>

                    {{-- User Detail --}}
                    <a href="{{ route('profile.show') }}" 
                       class="block py-3 px-6 transition border-l-4 {{ request()->routeIs('profile.show') ? 'bg-iium-green text-white font-bold border-iium-gold shadow' : 'text-gray-600 hover:bg-gray-100 hover:text-iium-green border-transparent' }}">
                        User Detail
                    </a>

                @endif
            </nav>

            {{-- Logout Button --}}
             <div class="p-4 border-t bg-gray-50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-red-600 hover:bg-red-50 hover:text-red-700 rounded text-sm font-bold transition">
                        <span>Log Out</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        {{-- CONTENT AREA --}}
        <div class="flex-1 p-6 overflow-y-auto bg-gray-50 relative">
            
            {{-- Global Flash Messages --}}
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-iium-green text-green-700 p-4 mb-6 shadow-md rounded-r" role="alert">
                    <p class="font-bold">Success</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-md rounded-r" role="alert">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            {{-- Dynamic Content Injection --}}
            @yield('content')
            
        </div>
    </div>

</body>
</html>