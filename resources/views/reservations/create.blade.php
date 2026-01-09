<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Reservation - IIUM Venue Reservation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-iium-green { background-color: #007A5E; }
        .text-iium-green { color: #007A5E; }
        .border-iium-green { border-color: #007A5E; }
        .bg-iium-gold { background-color: #C5A059; }
        .text-iium-gold { color: #C5A059; }
        .border-iium-gold { border-color: #C5A059; }
    </style>
</head>
<body class="bg-gray-50 font-sans h-screen flex flex-col">

    <header class="bg-white border-b-4 border-iium-gold shadow-sm px-6 py-3">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            
            <div class="w-full md:w-3/4 max-w-4xl">
                <img src="{{ asset('logo uia.png') }}" alt="IIUM Banner" class="w-full h-auto object-contain" onerror="this.src='https://upload.wikimedia.org/wikipedia/en/thumb/8/8f/International_Islamic_University_Malaysia_logo.svg/1200px-International_Islamic_University_Malaysia_logo.svg.png'; this.style.height='50px'; this.style.width='auto';"> 
            </div>

            <div class="text-center md:text-right whitespace-nowrap">
                <div class="h-10 w-1 bg-iium-gold inline-block align-middle mr-3 hidden md:inline-block"></div>
                <div class="inline-block align-middle">
                    <h1 class="text-xl md:text-2xl font-serif font-bold text-iium-green uppercase tracking-wide">VENUE RESERVATION SYSTEM</h1>
                </div>
            </div>

        </div>
    </header>

    <div class="flex flex-1 overflow-hidden">
        
        <div class="w-64 bg-white border-r shadow-inner flex flex-col">
            <div class="p-6 text-center border-b border-gray-100 bg-gray-50">
                <div class="w-20 h-20 bg-gray-200 rounded-full mx-auto mb-3 flex items-center justify-center border-2 border-iium-gold">
                    <span class="text-3xl">👤</span>
                </div>
                <h2 class="font-bold text-lg text-iium-green">{{ Auth::user()->name ?? 'User Name' }}</h2>
                <p class="text-xs text-gray-500 uppercase tracking-wide">Student ID: {{ Auth::user()->id ?? 'N/A' }}</p>
            </div>
            <nav class="flex-1 mt-2">
                <a href="{{ route('dashboard') }}" class="block py-3 px-6 text-gray-600 hover:bg-gray-100 hover:text-iium-green transition border-l-4 border-transparent">
                    Dashboard
                </a>
                <a href="{{ route('reservations.getreservations') }}" class="block py-3 px-6 text-gray-600 hover:bg-gray-100 hover:text-iium-green transition border-l-4 border-transparent">
                    My Reservation
                </a>
                <a href="#" class="block py-3 px-6 bg-iium-green text-white font-bold border-l-4 border-iium-gold shadow">
                    Make Reservation
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
            <h2 class="text-3xl font-serif font-bold text-gray-800 mb-6 border-b-2 border-iium-gold inline-block pb-2">Make a Reservation</h2>

            <div class="bg-white rounded-lg shadow-md border border-gray-200 max-w-4xl p-8">
                
                {{-- Flash Messages --}}
                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('reservations.store') }}" method="POST">
                    @csrf

                    {{-- Kuliyyah --}}
                    <div class="mb-4">
                        <label class="block text-gray-500 text-xs font-bold uppercase mb-1">Select Kuliyyah</label>
                        <select id="kuliyyah" class="w-full bg-white border border-gray-300 p-2 rounded text-gray-800 focus:border-[#007A5E] focus:ring-1 focus:ring-[#007A5E]" required>
                            <option value="">-- Choose Kuliyyah --</option>
                            @foreach($venues->pluck('kuliyyah')->unique() as $kuliyyah)
                                <option value="{{ $kuliyyah }}">{{ $kuliyyah }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Venue --}}
                    <div class="mb-4">
                        <label class="block text-gray-500 text-xs font-bold uppercase mb-1">Select Venue</label>
                        <select name="venueID" id="venue" class="w-full bg-white border border-gray-300 p-2 rounded text-gray-800 focus:border-[#007A5E] focus:ring-1 focus:ring-[#007A5E]" required>
                            <option value="">-- Choose a Venue --</option>
                            @foreach($venues as $venue)
                                <option 
                                    value="{{ $venue->venueID }}"
                                    data-kuliyyah="{{ $venue->kuliyyah }}"
                                    data-location="{{ $venue->location }}" class="hidden"
                                >
                                    {{ $venue->name }} (Cap: {{ $venue->capacity }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Location --}}
                    <div class="mb-4">
                        <label class="block text-gray-500 text-xs font-bold uppercase mb-1">Venue Location</label>
                        <input type="text" id="venueLocation" name="location" class="w-full border border-gray-300 p-2 rounded bg-gray-100 text-gray-500 cursor-not-allowed" readonly placeholder="Auto-filled after selecting venue">
                    </div>

                    {{-- Reason --}}
                    <div class="mb-4">
                        <label class="block text-gray-500 text-xs font-bold uppercase mb-1">Reason for Booking</label>
                        <input type="text" name="reason" class="w-full bg-white border border-gray-300 p-2 rounded text-gray-800 focus:border-[#007A5E] focus:ring-1 focus:ring-[#007A5E]" required>
                    </div>

                    {{-- Date --}}
                    <div class="mb-4">
                        <label class="block text-gray-500 text-xs font-bold uppercase mb-1">Reservation Date</label>
                        <input type="date" name="date" min="{{ date('Y-m-d') }}"
                               class="w-full bg-white border border-gray-300 p-2 rounded text-gray-800 focus:border-[#007A5E] focus:ring-1 focus:ring-[#007A5E]" required>
                    </div>

                    {{-- Time --}}
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-gray-500 text-xs font-bold uppercase mb-1">Start Time</label>
                            <input type="time" name="startTime" class="w-full bg-white border border-gray-300 p-2 rounded text-gray-800 focus:border-[#007A5E] focus:ring-1 focus:ring-[#007A5E]" required>
                        </div>
                        <div>
                            <label class="block text-gray-500 text-xs font-bold uppercase mb-1">End Time</label>
                            <input type="time" name="endTime" class="w-full bg-white border border-gray-300 p-2 rounded text-gray-800 focus:border-[#007A5E] focus:ring-1 focus:ring-[#007A5E]" required>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="mt-6 flex justify-end items-center gap-4">
                        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-red-600 text-sm font-bold uppercase tracking-wide">Cancel</a>
                        <button type="submit"
                            class="bg-iium-green text-white font-bold py-2 px-6 rounded text-sm hover:bg-[#005f49] transition shadow-md">
                            Confirm Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- JS Functionality from Original --}}
    <script>
        // 1. Existing Kuliyyah Filter Logic
        document.getElementById('kuliyyah').addEventListener('change', function () {
            const selected = this.value;
            const venueSelect = document.getElementById('venue');

            venueSelect.value = ''; // Reset selection
            
            // Clear the location box when Kuliyyah changes
            document.getElementById('venueLocation').value = ''; 

            [...venueSelect.options].forEach(option => {
                if (!option.dataset.kuliyyah) return;
                option.classList.toggle('hidden', option.dataset.kuliyyah !== selected);
            });
        });

        // 2. Auto-fill Location Logic
        document.getElementById('venue').addEventListener('change', function() {
            // Get the selected option element
            const selectedOption = this.options[this.selectedIndex];
            
            // Get the location data we stored in Step 1
            const location = selectedOption.dataset.location;
            
            // Update the input field
            const locationInput = document.getElementById('venueLocation');
            
            if (location) {
                locationInput.value = location;
            } else {
                locationInput.value = '';
            }
        });
    </script>

</body>
</html>