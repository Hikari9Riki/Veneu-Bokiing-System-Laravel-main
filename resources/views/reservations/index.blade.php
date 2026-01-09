<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reservations - IIUM Venue System</title>
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
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="w-full md:w-3/4 max-w-4xl">
                 <img src="{{ asset('logo uia.png') }}" alt="IIUM Banner" class="w-full h-auto object-contain" style="max-height: 80px;" onerror="this.src='https://upload.wikimedia.org/wikipedia/en/thumb/8/8f/International_Islamic_University_Malaysia_logo.svg/1200px-International_Islamic_University_Malaysia_logo.svg.png'; this.style.height='50px'; this.style.width='auto';">
            </div>
            <div class="text-center md:text-right">
                <h1 class="text-xl md:text-2xl font-serif font-bold text-iium-green uppercase tracking-wide">VENUE RESERVATION SYSTEM</h1>
            </div>
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden">
        
        <div class="w-64 bg-white border-r shadow-inner flex flex-col shrink-0">
            <div class="p-6 text-center border-b border-gray-100 bg-gray-50">
                <div class="w-20 h-20 bg-gray-200 rounded-full mx-auto mb-3 flex items-center justify-center border-2 border-iium-gold">
                    <span class="text-3xl">👤</span>
                </div>
                <h2 class="font-bold text-lg text-iium-green">{{ Auth::user()->name }}</h2>
                <p class="text-xs text-gray-500 uppercase tracking-wide">Student</p>
            </div>
            
            <nav class="flex-1 mt-2">
                <a href="{{ route('dashboard') }}" class="block py-3 px-6 text-gray-600 hover:bg-gray-100 hover:text-iium-green transition border-l-4 border-transparent">
                    Dashboard
                </a>
                <a href="{{ route('reservations.index') }}" class="block py-3 px-6 bg-iium-green text-white font-bold border-l-4 border-iium-gold shadow">
                    My Reservation
                </a>
                <a href="{{ route('profile.show') }}" class="block py-3 px-6 text-gray-600 hover:bg-gray-100 hover:text-iium-green transition border-l-4 border-transparent">
                    User Detail
                </a>
            </nav>

             <div class="p-4 border-t">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 rounded text-sm font-bold">Log Out</button>
                </form>
            </div>
        </div>

        <div class="flex-1 p-10 overflow-y-auto bg-gray-50">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-serif font-bold text-gray-800 border-b-2 border-iium-gold inline-block pb-2">My Reservations</h2>
                <a href="{{ route('reservations.create') }}" class="bg-iium-gold text-white font-bold py-2 px-4 rounded hover:bg-[#b08d4b] transition shadow">
                    + New Booking
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Venue / Kuliyyah
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Date & Time
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Reason
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations as $reservation)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center">
                                    <div class="ml-3">
                                        <p class="text-gray-900 whitespace-no-wrap font-bold">
                                            {{ $reservation->venue->name }}
                                        </p>
                                        <p class="text-gray-500 text-xs">{{ $reservation->venue->kuliyyah }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}</p>
                                <p class="text-gray-500 text-xs">
                                    {{ \Carbon\Carbon::parse($reservation->startTime)->format('h:i A') }} - 
                                    {{ \Carbon\Carbon::parse($reservation->endTime)->format('h:i A') }}
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $reservation->reason }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span class="relative inline-block px-3 py-1 font-semibold leading-tight">
                                    @if($reservation->status == 'Approved')
                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative text-green-900">Approved</span>
                                    @elseif($reservation->status == 'Rejected')
                                        <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                        <span class="relative text-red-900">Rejected</span>
                                    @else
                                        <span aria-hidden class="absolute inset-0 bg-yellow-200 opacity-50 rounded-full"></span>
                                        <span class="relative text-yellow-900">Pending</span>
                                    @endif
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                No reservations found. Start by booking a venue!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>