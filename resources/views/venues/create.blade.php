@extends('layouts.app')

@section('content')

    <div class="max-w-2xl mx-auto">
        
        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-serif font-bold text-gray-800 border-b-2 border-iium-gold inline-block pb-2">
                Add New Venue
            </h2>
            <a href="{{ route('venues.index') }}" class="text-gray-500 hover:text-iium-green text-sm font-bold">
                &larr; Back to List
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-8">
            
            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('venues.store') }}" method="POST">
                @csrf

                {{-- Venue ID (Manual Entry) --}}
                <div class="mb-5">
                    <label class="block text-gray-600 text-xs font-bold uppercase mb-2">Venue ID (Unique Code)</label>
                    <input type="text" name="venueID" value="{{ old('venueID') }}" placeholder="e.g. V-ICT-01" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-1 focus:ring-iium-green focus:border-iium-green outline-none uppercase" required>
                    <p class="text-xs text-gray-400 mt-1">This ID cannot be changed later.</p>
                </div>

                {{-- Venue Name --}}
                <div class="mb-5">
                    <label class="block text-gray-600 text-xs font-bold uppercase mb-2">Venue Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Main Auditorium" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-1 focus:ring-iium-green focus:border-iium-green outline-none" required>
                </div>

                {{-- Grid for Kuliyyah & Capacity --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-gray-600 text-xs font-bold uppercase mb-2">Kuliyyah (Faculty)</label>
                        <select name="kuliyyah" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-1 focus:ring-iium-green focus:border-iium-green outline-none bg-white">
                            <option value="">-- Select --</option>
                            <option value="ICT">ICT</option>
                            <option value="ENGIN">Engineering</option>
                            <option value="AIKOL">AIKOL</option>
                            <option value="KENMS">KENMS</option>
                            <option value="IRKHS">IRKHS</option>
                            <option value="EDU">Education</option>
                            <option value="SCI">Science</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-600 text-xs font-bold uppercase mb-2">Capacity (Pax)</label>
                        <input type="number" name="capacity" value="{{ old('capacity') }}" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-1 focus:ring-iium-green focus:border-iium-green outline-none" min="1" required>
                    </div>
                </div>

                {{-- Location --}}
                <div class="mb-5">
                    <label class="block text-gray-600 text-xs font-bold uppercase mb-2">Location Details</label>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g. Block B, Level 2" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-1 focus:ring-iium-green focus:border-iium-green outline-none" required>
                </div>

                {{-- Availability --}}
                <div class="mb-8">
                    <label class="block text-gray-600 text-xs font-bold uppercase mb-2">Status</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="available" value="1" checked class="text-iium-green focus:ring-iium-green">
                            <span class="text-sm">Available</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="available" value="0" class="text-iium-green focus:ring-iium-green">
                            <span class="text-sm">Under Maintenance / Closed</span>
                        </label>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end gap-3">
                    <a href="{{ route('venues.index') }}" class="px-5 py-2.5 rounded-lg text-gray-600 font-bold hover:bg-gray-100 transition">Cancel</a>
                    <button type="submit" class="bg-iium-green text-white font-bold py-2.5 px-6 rounded-lg shadow hover:bg-iium-dark transition">
                        Create Venue
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection