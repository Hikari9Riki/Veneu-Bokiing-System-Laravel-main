@extends('layouts.app')

@section('content')

    <div class="max-w-2xl mx-auto">
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-serif font-bold text-gray-800 border-b-2 border-iium-gold inline-block pb-2">
                Edit Venue
            </h2>
            <a href="{{ route('venues.index') }}" class="text-gray-500 hover:text-iium-green text-sm font-bold">
                &larr; Back to List
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-8">
            
            <form action="{{ route('venues.update', $venue->venueID) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Venue ID (Read Only) --}}
                <div class="mb-5">
                    <label class="block text-gray-600 text-xs font-bold uppercase mb-2">Venue ID</label>
                    <input type="text" value="{{ $venue->venueID }}" class="w-full border border-gray-200 p-3 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed" readonly>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-600 text-xs font-bold uppercase mb-2">Venue Name</label>
                    <input type="text" name="name" value="{{ old('name', $venue->name) }}" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-1 focus:ring-iium-green focus:border-iium-green outline-none" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-gray-600 text-xs font-bold uppercase mb-2">Kuliyyah</label>
                        <select name="kuliyyah" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-1 focus:ring-iium-green bg-white">
                            @foreach(['ICT', 'ENGIN', 'AIKOL', 'KENMS', 'IRKHS', 'EDU', 'SCI'] as $fac)
                                <option value="{{ $fac }}" {{ $venue->kuliyyah == $fac ? 'selected' : '' }}>{{ $fac }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-600 text-xs font-bold uppercase mb-2">Capacity</label>
                        <input type="number" name="capacity" value="{{ old('capacity', $venue->capacity) }}" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-1 focus:ring-iium-green outline-none" required>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-600 text-xs font-bold uppercase mb-2">Location</label>
                    <input type="text" name="location" value="{{ old('location', $venue->location) }}" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-1 focus:ring-iium-green outline-none" required>
                </div>

                <div class="mb-8">
                    <label class="block text-gray-600 text-xs font-bold uppercase mb-2">Status</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="available" value="1" {{ $venue->available ? 'checked' : '' }} class="text-iium-green focus:ring-iium-green">
                            <span class="text-sm">Available</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="available" value="0" {{ !$venue->available ? 'checked' : '' }} class="text-iium-green focus:ring-iium-green">
                            <span class="text-sm">Under Maintenance</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('venues.index') }}" class="px-5 py-2.5 rounded-lg text-gray-600 font-bold hover:bg-gray-100 transition">Cancel</a>
                    <button type="submit" class="bg-iium-green text-white font-bold py-2.5 px-6 rounded-lg shadow hover:bg-iium-dark transition">
                        Update Changes
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection