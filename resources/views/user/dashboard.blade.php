@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    
    {{-- Header Section --}}
    <div class="bg-white p-6 rounded-lg shadow-md mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Welcome, {{ $user->name }}</h1>
            <p class="text-gray-600">Here are your upcoming venue reservations.</p>
        </div>
        <a href="{{ route('reservations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow">
            + Book a Venue
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm whitespace-nowrap">
                <thead class="uppercase tracking-wider border-b-2 border-gray-200 bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-medium text-gray-500">Date Request</th>
                        <th class="px-6 py-4 font-medium text-gray-500">Venue</th>
                        <th class="px-6 py-4 font-medium text-gray-500">Booking Date</th>
                        <th class="px-6 py-4 font-medium text-gray-500">Time</th>
                        <th class="px-6 py-4 font-medium text-gray-500">Status</th>
                        <th class="px-6 py-4 font-medium text-gray-500 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reservations as $res)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-500">
                                {{ $res->created_at->format('d M Y') }}
                                <div class="text-xs text-gray-400">{{ $res->created_at->format('h:i A') }}</div>
                            </td>

                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $res->venue->name ?? 'Unknown' }}
                                <div class="text-xs text-gray-400">{{ $res->venue->location ?? '' }}</div>
                            </td>

                            <td class="px-6 py-4 text-gray-700">
                                {{ \Carbon\Carbon::parse($res->date)->format('D, d M Y') }}
                            </td>

                            <td class="px-6 py-4 text-gray-700">
                                <span class="bg-gray-100 px-2 py-1 rounded text-xs font-bold">
                                    {{ \Carbon\Carbon::parse($res->startTime)->format('h:i A') }}
                                </span>
                                <span class="text-gray-400 mx-1">to</span>
                                <span class="bg-gray-100 px-2 py-1 rounded text-xs font-bold">
                                    {{ \Carbon\Carbon::parse($res->endTime)->format('h:i A') }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'Approved' => 'bg-green-50 text-green-600 border-green-200',
                                        'Pending' => 'bg-yellow-50 text-yellow-600 border-yellow-200',
                                        'Rejected' => 'bg-red-50 text-red-600 border-red-200',
                                        'Cancelled' => 'bg-gray-50 text-gray-600 border-gray-200',
                                    ];
                                    $currentClass = $statusClasses[$res->status] ?? 'bg-gray-50 text-gray-500';
                                @endphp
                                <span class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-semibold {{ $currentClass }} border">
                                    {{ $res->status }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div x-data="{ open: false }" @keydown.escape.window="open = false">
                                    <button @click="open = true" class="bg-blue-600 text-white px-3 py-1.5 rounded text-xs hover:bg-blue-700 transition">
                                        Review
                                    </button>

                                    {{-- Modal --}}
                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100"
                                         style="display: none;"
                                         class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-sm p-4">
                                        
                                        <div @click.away="open = false" class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
                                            <div class="flex justify-between items-center mb-4 border-b pb-2">
                                                <h3 class="text-lg font-bold text-gray-800">Booking Details</h3>
                                                <button @click="open = false" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
                                            </div>

                                            <div class="text-left space-y-3 mb-6">
                                                <div>
                                                    <p class="text-xs font-bold text-gray-400 uppercase">Reason</p>
                                                    <p class="text-gray-700">{{ $res->reason }}</p>
                                                </div>
                                                <hr>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <p class="text-xs font-bold text-gray-400 uppercase">Venue</p>
                                                        <p class="text-sm text-gray-700">{{ $res->venue->name }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs font-bold text-gray-400 uppercase">Location</p>
                                                        <p class="text-sm text-gray-700">{{ $res->venue->location }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex gap-3 justify-end">
                                                <button @click="open = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded text-sm hover:bg-gray-300">Close</button>
                                                @if($res->status === 'Pending')
                                                <form action="{{ route('user.reservations.update', $res->reservationID) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="Cancelled">
                                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded text-sm hover:bg-red-700 shadow">Cancel Booking</button>
                                                </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <p class="text-lg">No upcoming reservations found.</p>
                                <a href="{{ route('reservations.create') }}" class="text-blue-600 hover:underline">Create your first booking</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="//unpkg.com/alpinejs" defer></script>
@endsection