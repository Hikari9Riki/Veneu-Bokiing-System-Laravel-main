@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Make a Reservation</h2>

    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Kuliyyah --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Select Kuliyyah</label>
            <select id="kuliyyah" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500" required>
                <option value="">-- Choose Kuliyyah --</option>
                @foreach($venues->pluck('kuliyyah')->unique() as $kuliyyah)
                    <option value="{{ $kuliyyah }}">{{ $kuliyyah }}</option>
                @endforeach
            </select>
        </div>

        {{-- Venue --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Select Venue</label>
            <select name="venueID" id="venue" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500" required >
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
        
        {{-- location --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Venue Location</label>
            <input type="text" id="venueLocation" name="location" class="w-full border p-2 rounded bg-gray-100 cursor-not-allowed" readonly placeholder="Auto-filled after selecting venue">
        </div>

        {{-- Reason --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Reason for Booking</label>
            <input type="text" name="reason" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500" required>
        </div>

        {{-- Date --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Reservation Date</label>
            <input type="date" name="date" min="{{ date('Y-m-d') }}"
                   class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500" required>
        </div>

        {{-- Time --}}
        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Start Time</label>
                <input type="time" name="startTime" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">End Time</label>
                <input type="time" name="endTime" class="w-full border p-2 rounded" required>
            </div>
        </div>

        <div class="mt-6 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:underline">Cancel</a>
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Confirm Booking
            </button>
        </div>
    </form>
</div>

{{-- JS --}}
<script>
    // 1. Existing Kuliyyah Filter Logic (Keep this)
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

    // 2. NEW: Auto-fill Location Logic
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
@endsection
