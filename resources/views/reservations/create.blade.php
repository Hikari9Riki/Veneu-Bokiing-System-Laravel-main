<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Reservation - IIUM Venue System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>
    <style>
        .bg-iium-green { background-color: #007A5E; }
        .text-iium-green { color: #007A5E; }
        .border-iium-gold { border-color: #C5A059; }
        .flatpickr-day.selected { background: #007A5E !important; border-color: #007A5E !important; }
    </style>
</head>
<body class="bg-gray-50 font-sans h-screen flex flex-col">

    <header class="bg-white border-b-4 border-iium-gold shadow-sm px-6 py-3 shrink-0">
        <div class="flex items-center justify-between">
            <img src="{{ asset('logo uia.png') }}" class="h-12 w-auto" onerror="this.src='https://upload.wikimedia.org/wikipedia/en/thumb/8/8f/International_Islamic_University_Malaysia_logo.svg/1200px-International_Islamic_University_Malaysia_logo.svg.png'">
            <h1 class="text-xl font-serif font-bold text-iium-green uppercase">Venue Reservation</h1>
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
                <a href="{{ route('reservations.create') }}" class="block py-3 px-6 bg-iium-green text-white font-bold border-l-4 border-iium-gold shadow">Make Reservation</a>
                <a href="{{ route('profile.show') }}" class="block py-3 px-6 text-gray-600 hover:bg-gray-100 hover:text-iium-green transition border-l-4 border-transparent">User Detail</a>
            </nav>
             <div class="p-4 border-t">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 rounded text-sm font-bold">Log Out</button>
                </form>
            </div>
        </div>

        <div class="flex-1 p-6 overflow-y-auto bg-gray-50">
            <div class="flex flex-col lg:flex-row gap-6 h-full">
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">New Booking</h3>
                        @if(session('error')) <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">{{ session('error') }}</div> @endif
                        <form action="{{ route('reservations.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-gray-500 text-xs font-bold uppercase mb-1">Select Kuliyyah</label>
                                <select id="kuliyyah" class="w-full border border-gray-300 p-2 rounded focus:ring-1 focus:ring-iium-green">
                                    <option value="">-- Choose --</option>
                                    @foreach($venues->pluck('kuliyyah')->unique() as $kuliyyah)
                                        <option value="{{ $kuliyyah }}">{{ $kuliyyah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-500 text-xs font-bold uppercase mb-1">Select Venue</label>
                                <select name="venueID" id="venue" class="w-full border border-gray-300 p-2 rounded focus:ring-1 focus:ring-iium-green" required>
                                    <option value="">-- First Choose Kuliyyah --</option>
                                    @foreach($venues as $venue)
                                        <option value="{{ $venue->venueID }}" data-kuliyyah="{{ $venue->kuliyyah }}" class="hidden">{{ $venue->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-500 text-xs font-bold uppercase mb-1">Start Date & Time</label>
                                <input type="text" name="start_datetime" id="startPicker" class="w-full border border-gray-300 p-2 rounded bg-white cursor-pointer focus:ring-1 focus:ring-iium-green" placeholder="Select Start..." required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-500 text-xs font-bold uppercase mb-1">End Date & Time</label>
                                <input type="text" name="end_datetime" id="endPicker" class="w-full border border-gray-300 p-2 rounded bg-white cursor-pointer focus:ring-1 focus:ring-iium-green" placeholder="Select End..." required>
                            </div>
                            <div class="mb-6">
                                <label class="block text-gray-500 text-xs font-bold uppercase mb-1">Reason</label>
                                <input type="text" name="reason" class="w-full border border-gray-300 p-2 rounded" required>
                            </div>
                            <button type="submit" class="w-full bg-iium-green text-white font-bold py-3 rounded shadow hover:bg-[#00604a] transition">Confirm Booking</button>
                        </form>
                    </div>
                </div>
                <div class="w-full lg:w-2/3">
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 h-full flex flex-col">
                        <div class="text-sm text-gray-500 mb-2">Check availability for selected venue:</div>
                        <div id="calendar" class="flex-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        flatpickr("#startPicker", { enableTime: true, dateFormat: "Y-m-d H:i", minDate: "today", time_24hr: true });
        flatpickr("#endPicker", { enableTime: true, dateFormat: "Y-m-d H:i", minDate: "today", time_24hr: true });

        let calendar;
        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek' },
                height: '100%',
                allDaySlot: false,
                slotMinTime: "08:00:00",
                slotMaxTime: "23:00:00",
                events: [] 
            });
            calendar.render();
            setupDropdowns();
        });

        function setupDropdowns() {
            const kuliyyahSelect = document.getElementById('kuliyyah');
            const venueSelect = document.getElementById('venue');
            kuliyyahSelect.addEventListener('change', function() {
                const selected = this.value;
                venueSelect.value = '';
                [...venueSelect.options].forEach(opt => {
                    if (opt.value === "") return;
                    if (opt.dataset.kuliyyah === selected) opt.classList.remove('hidden');
                    else opt.classList.add('hidden');
                });
                calendar.removeAllEvents();
            });
            venueSelect.addEventListener('change', function() {
                if (this.value) fetchEvents(this.value);
            });
        }

        function fetchEvents(venueId) {
            let url = "{{ route('reservations.getreservations') }}?venue_id=" + venueId;
            fetch(url, { headers: { "X-Requested-With": "XMLHttpRequest" } })
                .then(response => response.json())
                .then(data => {
                    calendar.removeAllEvents();
                    data.forEach(event => { calendar.addEvent(event); });
                });
        }
    </script>
</body>
</html>