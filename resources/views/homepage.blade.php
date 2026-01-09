@extends('layouts.app')

@section('content')
<h1>Kambing</h1>
<div class="container-fluid mt-4">
    <div class="row">
        <!-- Calendar Section (2/3) -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Venue Reservations Calendar</h5>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <!-- Sidebar Section (1/3) -->
        <div class="col-lg-4">
            <!-- Select Kuliyyah -->
            <div class="card mb-3">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">Select Kuliyyah</h6>
                </div>
                <div class="card-body">
                    <select id="kuliyyah" class="form-control" onchange="filterVenues()">
                        <option value="">-- Choose Kuliyyah --</option>
                        @foreach($kulliyyahs as $kuliyyah)
                            <option value="{{ $kuliyyah }}">{{ $kuliyyah }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Select Venue -->
            <div class="card mb-3">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">Select Venue</h6>
                </div>
                <div class="card-body">
                    <select id="venue" class="form-control" onchange="loadCalendarEvents()">
                        <option value="">-- Choose Venue --</option>
                    </select>
                </div>
            </div>

            <!-- Make Booking Button -->
            <a href="{{ route('reservations.create') }}">Book a Venue</a>
        </div>
    </div>
</div>

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">New Booking</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
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
            height: 'auto'
        });

        calendar.render();

        // ✅ LOAD ALL RESERVATIONS FIRST
        loadCalendarEvents();
    });


    function filterVenues() {
        let selectedKulliyyah = document.getElementById('kuliyyah').value;
        let venueSelect = document.getElementById('venue');
        venueSelect.innerHTML = '<option value="">-- Choose Venue --</option>';

        if (selectedKulliyyah) {
            // USE THIS LINE EXACTLY:
            // It uses Laravel to build the full correct URL (e.g. http://127.0.0.1:8000/api/venues)
            let apiUrl = "{{ url('/venues') }}"; 

            fetch(`${apiUrl}?kuliyyah=${encodeURIComponent(selectedKulliyyah)}`)
                .then(response => {
                    // Check if the link actually worked
                    if (!response.ok) {
                        console.error("API Link Failed:", response.status);
                        return [];
                    }
                    return response.json();
                })
                .then(data => {

                    data.forEach(venue => {
                        let option = document.createElement('option');
                        // Matches your DB column 'venueID'
                        option.value = venue.venueID; 
                        option.textContent = venue.name;
                        venueSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        }
    }

    function loadCalendarEvents() {
        let venueId = document.getElementById('venue').value;
        let url = '/reservations';
        console.log("Loading events for Venue ID:", venueId);
        // 🔹 Jika venue dipilih → tambah query
        if (venueId) {
            url += `?venue_id=${venueId}`;
        }

        console.log("Fetching URL:", url);

        fetch(url)
            
            .then(response => response.json())
            .then(data => {
                
                calendar.removeAllEvents();

                data.forEach(event => {
                    calendar.addEvent(event);
                });
            });
    }

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

            // SIMPLE ALERT ON CLICK
            eventClick: function(info) {
                info.jsEvent.preventDefault(); // Prevent browser navigation
                let eventObj = info.event;

                // Format the dates to look nice
                let start = eventObj.start ? eventObj.start.toLocaleString() : 'N/A';
                let end = eventObj.end ? eventObj.end.toLocaleString() : 'N/A';
                let locate = eventObj.extendedProps.location || 'N/A';
                let kuliyyah = eventObj.extendedProps.kuliyyah || 'N/A';

                // Create the message string
                let message = "Reservation Details:\n" +
                            "-------------------\n" +
                            "Venue: " + eventObj.title + "\n" +
                            "Kuliyyah: " + kuliyyah + "\n" +
                            "Location: " + locate + "\n" +
                            "Start: " + start + "\n" +
                            "End: " + end;

                // Show the alert
                alert(message);
            }
        });

        calendar.render();
        loadCalendarEvents();
    });

</script>
@endpush
@endsection