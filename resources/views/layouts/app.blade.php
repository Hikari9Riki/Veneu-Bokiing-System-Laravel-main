<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IIUM Venue Reservation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- FullCalendar CDN --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Inter:wght@300;400;600&display=swap');
        
        .font-serif-header { font-family: 'Cinzel', serif; }
        .font-sans-body { font-family: 'Inter', sans-serif; }
        
        .bg-iium-green { background-color: #007A5E; }
        .text-iium-green { color: #007A5E; }
        .border-iium-green { border-color: #007A5E; }
        
        .bg-iium-gold { background-color: #C5A059; }
        .text-iium-gold { color: #C5A059; }
        .border-iium-gold { border-color: #C5A059; }

        /* Sidebar Active State */
        .nav-active { border-left: 5px solid #007A5E; background-color: #F3F4F6; color: #007A5E; font-weight: bold; }
    </style>
</head>
<body class="bg-white font-sans-body text-gray-800 min-h-screen flex flex-col">

    <header class="bg-white shadow-sm border-b border-gray-200 py-3 px-6 lg:px-12 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <img src="{{ asset('logo uia.png') }}" alt="IIUM Logo" class="h-16 w-auto object-contain" 
                 onerror="this.src='https://upload.wikimedia.org/wikipedia/en/thumb/8/8f/International_Islamic_University_Malaysia_logo.svg/1200px-International_Islamic_University_Malaysia_logo.svg.png'">
            
            <div class="hidden md:block">
                <h1 class="text-xl font-serif-header font-bold text-gray-800 leading-tight">
                    الجامعة الإسلامية العالمية ماليزيا<br>
                    <span class="text-sm font-sans-body font-normal tracking-widest uppercase">International Islamic University Malaysia</span>
                </h1>
            </div>
        </div>

        <div class="flex items-center gap-6">
            <div class="hidden lg:block text-right text-xs uppercase tracking-wide text-iium-green font-bold">
                <span class="text-iium-gold">Tawhidic Epistemology</span> <br> Leading The Way<br>
                <span class="text-iium-gold">Ummatic Excellence</span> <br> Leading The World
            </div>

            @auth
                <div class="flex items-center gap-2">
                    <span class="text-sm font-bold">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded">Logout</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="border border-gray-400 px-4 py-1 rounded text-sm hover:bg-gray-50">Login</a>
            @endauth
        </div>
    </header>

    <div class="flex flex-1 h-[calc(100vh-90px)] overflow-hidden">
        @yield('content')
    </div>

</body>
</html>