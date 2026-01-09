@extends('layouts.app')

@section('content')

    {{-- 1. Styles for Datepicker --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .flatpickr-day.selected { background: #007A5E !important; border-color: #007A5E !important; }
    </style>

    {{-- 2. Page Header --}}
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-serif font-bold text-gray-800 border-b-2 border-iium-gold inline-block pb-2">
            Make a Reservation
        </h2>
        <p class="text-gray-500 text-sm mt-2">Fill in the details below to book a venue.</p>
    </div>

    {{-- 3. Main Form Container --}}
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        
        <div class="bg-gray-50 px-8 py-4 border-b border-gray-100 flex items-center gap-3">
            <span class="bg-iium-green text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm">1</span>
            <h3 class="text-lg font-bold text-gray-700">Booking Details</h3>
        </div>

        <div class="p-8">
            @if(session('error')) 
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6 text-sm flex items-start gap-2">
                    <span>{{ session('error') }}</span>
                </div> 
            @endif

            <form action="{{ route('reservations.store') }}" method="POST" class="space-y-6">
                @csrf
                
                {{-- Row 1: Venue Selection --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Kuliyyah --}}
                    <div>
                        <label class="block text-gray-600 text-xs font-bold uppercase mb-2">Select Kuliyyah</label>
                        <select id="kuliyyah" class="w-full border border-gray-300 p-3 rounded-lg text-sm focus:ring-2 focus:ring-iium-green focus:border-iium-green outline-none bg-white">
                            <option value="">-- Choose Faculty --</option>
                            @foreach($venues->pluck('kuliyyah')->unique() as $kuliyyah)
                                <option value="{{ $kuliyyah }}">{{ $kuliyyah }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Venue --}}
                    <div>
                        <label class="block text-gray-600 text-xs font-bold uppercase mb-2">Select Venue</label>
                        <select name="venueID" id="venue" class="w-full border border-gray-300 p-3 rounded-lg text-sm focus:ring-2 focus:ring-iium-green focus:border-iium-green outline-none bg-gray-50 text-gray-400 cursor-not-allowed" disabled required>
                            <option value="">-- Select Kuliyyah First --</option>
                            @foreach($venues as $venue)
                                <option value="{{ $venue->venueID }}" data-kuliyyah="{{ $venue->kuliyyah }}" data-location="{{ $venue->location }}" class="hidden">
                                    {{ $venue->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Row 2: Location (Auto-filled) --}}
                <div>
                    <label class="block text-gray-600 text-xs font-bold uppercase mb-2">Venue Location</label>
                    <input type="text" id="venueLocation" class="w-full border border-gray-300 p-3 rounded-lg text-sm bg-gray-100 text-gray-500 cursor-not-allowed outline-none" placeholder="Auto-filled after selecting venue..." readonly>
                </div>

                <hr class="border-gray-100">

                {{-- Row 3: START Date & Time --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-600 text-xs font-bold uppercase mb-2">Start Date</label>
                        <div class="relative">
                            <input type="text" name="startDate" id="startDate" class="w-full border border-gray-300 p-3 rounded-lg text-sm bg-white cursor-pointer focus:ring-2 focus:ring-iium-green focus:border-iium-green outline-none" placeholder="YYYY-MM-DD" required>
                            <span class="absolute right-3 top-3 text-gray-400">📅</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-600 text-xs font-bold uppercase mb-2">Start Time</label>
                        <div class="relative">
                            <input type="text" name="startTime" id="startTime" class="w-full border border-gray-300 p-3 rounded-lg text-sm bg-white cursor-pointer focus:ring-2 focus:ring-iium-green focus:border-iium-green outline-none" placeholder="HH:MM" required>
                            <span class="absolute right-3 top-3 text-gray-400">⏰</span>
                        </div>
                    </div>
                </div>

                {{-- Row 4: END Date & Time --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-600 text-xs font-bold uppercase mb-2">End Date</label>
                        <div class="relative">
                            <input type="text" name="endDate" id="endDate" class="w-full border border-gray-300 p-3 rounded-lg text-sm bg-white cursor-pointer focus:ring-2 focus:ring-iium-green focus:border-iium-green outline-none" placeholder="YYYY-MM-DD" required>
                            <span class="absolute right-3 top-3 text-gray-400">📅</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-600 text-xs font-bold uppercase mb-2">End Time</label>
                        <div class="relative">
                            <input type="text" name="endTime" id="endTime" class="w-full border border-gray-300 p-3 rounded-lg text-sm bg-white cursor-pointer focus:ring-2 focus:ring-iium-green focus:border-iium-green outline-none" placeholder="HH:MM" required>
                            <span class="absolute right-3 top-3 text-gray-400">⏰</span>
                        </div>
                    </div>
                </div>

                {{-- Row 5: Reason --}}
                <div>
                    <label class="block text-gray-600 text-xs font-bold uppercase mb-2">Reason for Booking</label>
                    <textarea name="reason" rows="3" class="w-full border border-gray-300 p-3 rounded-lg text-sm focus:ring-2 focus:ring-iium-green focus:border-iium-green outline-none resize-none" placeholder="Please describe the purpose of your booking..." required></textarea>
                </div>

                {{-- Submit Button --}}
                <div class="pt-4 flex justify-end gap-4">
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-lg text-gray-600 font-bold hover:bg-gray-100 transition">Cancel</a>
                    <button type="submit" class="bg-iium-green text-white font-bold py-3 px-8 rounded-lg shadow-md hover:bg-iium-dark hover:shadow-lg transition transform hover:-translate-y-0.5">
                        Confirm Reservation
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- 4. Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        // --- 1. Date & Time Picker Initialization ---
        
        // Dates
        flatpickr("#startDate", { 
            dateFormat: "Y-m-d", 
            minDate: "today"
        });
        flatpickr("#endDate", { 
            dateFormat: "Y-m-d", 
            minDate: "today"
        });

        // Times
        flatpickr("#startTime", { 
            enableTime: true, 
            noCalendar: true, 
            dateFormat: "H:i", 
            time_24hr: true 
        });
        flatpickr("#endTime", { 
            enableTime: true, 
            noCalendar: true, 
            dateFormat: "H:i", 
            time_24hr: true 
        });

        // --- 2. Dropdown & Location Logic ---
        document.addEventListener('DOMContentLoaded', function () {
            const kuliyyahSelect = document.getElementById('kuliyyah');
            const venueSelect = document.getElementById('venue');
            const locationInput = document.getElementById('venueLocation');

            // Handle Kuliyyah Change
            kuliyyahSelect.addEventListener('change', function() {
                const selected = this.value;
                venueSelect.value = '';
                locationInput.value = '';
                
                if (selected) {
                    venueSelect.disabled = false;
                    venueSelect.classList.remove('bg-gray-50', 'text-gray-400', 'cursor-not-allowed');
                    venueSelect.classList.add('bg-white', 'text-gray-800');
                } else {
                    venueSelect.disabled = true;
                    venueSelect.classList.add('bg-gray-50', 'text-gray-400', 'cursor-not-allowed');
                    venueSelect.classList.remove('bg-white', 'text-gray-800');
                }

                [...venueSelect.options].forEach(opt => {
                    if (opt.value === "") return;
                    if (opt.dataset.kuliyyah === selected) {
                        opt.classList.remove('hidden');
                    } else {
                        opt.classList.add('hidden');
                    }
                });
            });

            // Handle Venue Change (Auto-fill Location)
            venueSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const location = selectedOption.dataset.location;
                if(location) {
                    locationInput.value = location;
                } else {
                    locationInput.value = '';
                }
            });
        });
    </script>
@endsection