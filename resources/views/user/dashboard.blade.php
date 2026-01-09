<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - IIUM Venue Reservation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>
    <style>
        .bg-iium-green { background-color: #007A5E; }
        .text-iium-green { color: #007A5E; }
        .bg-iium-gold { background-color: #C5A059; }
        .border-iium-gold { border-color: #C5A059; }
        
        /* Calendar Theme Overrides */
        .fc-button-primary { background-color: #007A5E !important; border-color: #007A5E !important; }
        .fc-button-primary:hover { background-color: #00604a !important; }
        .fc-daygrid-day.fc-day-today { background-color: #f0fdf4 !important; }
        .fc-event { cursor: pointer; border: none !important; }
    </style>
</head>
<body class="bg-gray-50 font-sans h-screen flex flex-col">

    <header class="bg-white border-b-4 border-iium-gold shadow-sm px-6 py-3 shrink-0">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="w-full md:w-3/4 max-w-4xl">
                 <img src="{{ asset('logo uia.png') }}" alt="IIUM Banner" class="w-full h-auto object-contain" style="max-height: 80px;" onerror="this.src='https://upload.wikimedia.org/wikipedia/en/thumb/8/8f/International_Islamic_University_Malaysia_logo.svg/1200px-International_Islamic_University_Malaysia_logo.svg.png'; this.style.height='50px'; this.style.width='auto';">
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
        
        <div class="w-64 bg-white border-r shadow-inner flex flex-col shrink-0">
            <div class="p-6 text-center border-b border-gray-100 bg-gray-50">
                <div class="w-20 h-20 bg-gray-200 rounded-full mx-auto mb-3 flex items-center justify-center border-2 border-iium-gold">
                    <span class="text-3xl">👤</span>
                </div>
                <h2 class="font-bold text-lg text-iium-green">{{ Auth::user()->name ?? 'Guest' }}</h2>
                <p class="text-xs text-gray-500 uppercase tracking-wide">ID: {{ Auth::user()->id ?? 'N/A' }}</p>
            </div>
            
            <nav class="flex-1 mt-2">
                <a href="{{ route('dashboard') }}" class="block py-3 px-6 bg-iium-green text-white font-bold border-l-4 border-iium-gold shadow">
                    Dashboard
                </a>
                <a href="{{ route('reservations.getreservations') }}" class="block py-3 px-6 text-gray-600 hover:bg-gray-100 hover:text-iium-green transition border-l-4 border-transparent">
                    My Reservation
                </a>
                <a href="{{ route('reservations.create') }}" class="block py-3 px-6 text-gray-600 hover:bg-gray-100 hover:text-iium-green transition border-l-4 border-transparent">
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

        <div class="flex-1 p-6 overflow-y-auto bg-gray-50">
            
            {{-- SUCCESS / ERROR MESSAGES --}}
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

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-serif font-bold text-gray-800 border-b-2 border-iium-gold inline-block pb-2">Venue Availability</h2>
                
                <div class="flex gap-2">
                    <select id="kuliyyah" class="border border-gray-300 rounded px-3 py-2 text-sm focus:border-iium-green focus:outline-none" onchange="filterVenues()">
                         <option value="">-- All Kuliyyah --</option>
                         @if(isset($kulliyyahs))
                             @foreach($kulliyyahs as $kuliyyah)
                                 <option value="{{ $kuliyyah }}">{{ $kuliyyah }}</option>
                             @endforeach
                         @endif
                    </select>
                    <select id="venue" class="border border-gray-300 rounded px-3 py-2 text-sm focus:border-iium-green focus:outline-none" onchange="loadCalendarEvents()">
                         <option value="">-- All Venues --</option>
                    </select>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <script>
        let calendar;

        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                height: 'auto',
                events: [], // Initially empty, loaded via AJAX
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    let e = info.event;
                    let msg = `📅 RESERVATION DETAIL\n\n📍 Venue: ${e.title}\n🏢 Kuliyyah: ${e.extendedProps.kuliyyah || 'N/A'}\n⏰ Start: ${e.start.toLocaleString()}\n🏁 End: ${e.end ? e.end.toLocaleString() : 'N/A'}`;
                    alert(msg);
                }
            });

            calendar.render();
            // Load initial events
            loadCalendarEvents();
        });

        // 1. Fetch Venues
        function filterVenues() {
            let selectedKulliyyah = document.getElementById('kuliyyah').value;
            let venueSelect = document.getElementById('venue');
            venueSelect.innerHTML = '<option value="">-- All Venues --</option>';

            if (selectedKulliyyah) {
                let apiUrl = "{{ url('/venues') }}"; 
                fetch(`${apiUrl}?kuliyyah=${encodeURIComponent(selectedKulliyyah)}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(venue => {
                            let option = document.createElement('option');
                            option.value = venue.venueID; 
                            option.textContent = venue.name;
                            venueSelect.appendChild(option);
                        });
                    })
                    .catch(err => console.error(err));
            }
            loadCalendarEvents();
        }

        // 2. Fetch Events
        function loadCalendarEvents() {
            let venueId = document.getElementById('venue').value;
            let url = "{{ route('reservations.getreservations') }}"; 
            
            if (venueId) {
                url += `?venue_id=${venueId}`;
            }

            fetch(url, {
                headers: { "X-Requested-With": "XMLHttpRequest" } 
            })
            .then(response => response.json())
            .then(data => {
                calendar.removeAllEvents();
                data.forEach(event => {
                    calendar.addEvent({
                        title: event.title || event.venue_name, 
                        start: event.start,
                        end: event.end,
                        extendedProps: {
                            kuliyyah: event.kuliyyah
                        },
                        color: '#C5A059', // Gold color
                        textColor: '#FFFFFF'
                    });
                });
            })
            .catch(error => console.error('Error fetching events:', error));
        }
    </script>

</body>
</html>