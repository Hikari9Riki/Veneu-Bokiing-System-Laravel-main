@extends('layouts.app')

@section('content')

    {{-- 1. Styles for FullCalendar Overrides (Scoped to this page) --}}
    <style>
        .fc-button-primary { background-color: #007A5E !important; border-color: #007A5E !important; }
        .fc-button-primary:hover { background-color: #00604a !important; }
        .fc-daygrid-day.fc-day-today { background-color: #f0fdf4 !important; }
        .fc-event { cursor: pointer; border: none !important; }
        .fc-toolbar-title { font-family: ui-serif, Georgia, Cambria, "Times New Roman", Times, serif; font-weight: bold; color: #374151; }
    </style>

    {{-- 2. Page Header & Filters --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        
        <div>
            <h2 class="text-3xl font-serif font-bold text-gray-800 border-b-2 border-iium-gold inline-block pb-2">
                Venue Availability
            </h2>
            <p class="text-gray-500 text-sm mt-1">Check availability before making a reservation.</p>
        </div>
        
        {{-- Filters --}}
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <select id="kuliyyah" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:border-iium-green focus:ring-1 focus:ring-iium-green outline-none shadow-sm" onchange="filterVenues()">
                 <option value="">-- All Kuliyyah --</option>
                 @if(isset($kulliyyahs))
                     @foreach($kulliyyahs as $kuliyyah)
                         <option value="{{ $kuliyyah }}">{{ $kuliyyah }}</option>
                     @endforeach
                 @endif
            </select>

            <select id="venue" class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:border-iium-green focus:ring-1 focus:ring-iium-green outline-none shadow-sm" onchange="loadCalendarEvents()">
                 <option value="">-- All Venues --</option>
            </select>
        </div>
    </div>

    {{-- 3. Calendar Container --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div id="calendar"></div>
    </div>

    {{-- 4. Scripts --}}
    {{-- Load FullCalendar via CDN --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>

    <script>
        let calendar;

        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                height: 'auto',
                events: [], // Initially empty, loaded via AJAX
                
                // Event Click - Show details
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    let e = info.event;
                    let kuliyyah = e.extendedProps.kuliyyah || 'N/A';
                    
                    // Simple alert for now (can be upgraded to a modal later)
                    let msg = `📅 RESERVATION DETAIL\n` +
                              `------------------------\n` +
                              `📍 Venue: ${e.title}\n` +
                              `🏢 Kuliyyah: ${kuliyyah}\n` +
                              `⏰ Start: ${e.start.toLocaleString()}\n` +
                              `🏁 End: ${e.end ? e.end.toLocaleString() : 'N/A'}`;
                    alert(msg);
                }
            });

            calendar.render();
            // Load initial events
            loadCalendarEvents();
        });

        // --- Function 1: Filter Venues by Kuliyyah ---
        function filterVenues() {
            let selectedKulliyyah = document.getElementById('kuliyyah').value;
            let venueSelect = document.getElementById('venue');
            
            // Reset Venue Dropdown
            venueSelect.innerHTML = '<option value="">-- All Venues --</option>';

            // If a Kuliyyah is selected, fetch specific venues
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
            // Reload calendar (will show events for the new selection)
            loadCalendarEvents();
        }

        // --- Function 2: Fetch Events for Calendar ---
        function loadCalendarEvents() {
            let venueId = document.getElementById('venue').value;
            let url = "{{ route('reservations.getreservations') }}"; 
            
            // Append Venue ID if selected
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
                        color: '#C5A059', // IIUM Gold color for events
                        textColor: '#FFFFFF'
                    });
                });
            })
            .catch(error => console.error('Error fetching events:', error));
        }
    </script>
@endsection