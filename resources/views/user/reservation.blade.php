@extends('layouts.app')

@section('content')

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-3xl font-serif font-bold text-gray-800 border-b-2 border-iium-gold inline-block pb-2">
                My Reservations
            </h2>
            <p class="text-gray-500 text-sm mt-1">Manage and review your venue booking status.</p>
        </div>
        
        <a href="{{ route('reservations.create') }}" class="bg-iium-green text-white px-5 py-2.5 rounded-lg hover:bg-iium-dark transition shadow-lg flex items-center gap-2 font-bold text-sm transform hover:scale-105 duration-200">
            <span class="text-lg">+</span> Book a Venue
        </a>
    </div>

    {{-- TABLE SECTION --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm whitespace-nowrap">
                <thead class="uppercase tracking-wider border-b-2 border-iium-gold bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-bold text-iium-green">Date Request</th>
                        <th class="px-6 py-4 font-bold text-iium-green">Venue</th>
                        <th class="px-6 py-4 font-bold text-iium-green">Booking Date</th>
                        <th class="px-6 py-4 font-bold text-iium-green">Time</th>
                        <th class="px-6 py-4 font-bold text-iium-green">Status</th>
                        <th class="px-6 py-4 font-bold text-iium-green text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reservations as $res)
                        <tr class="hover:bg-gray-50 transition group">
                            {{-- Date Request --}}
                            <td class="px-6 py-4 text-gray-500">
                                <span class="block font-medium text-gray-700">{{ $res->created_at->format('d M Y') }}</span>
                                <span class="text-xs text-gray-400">{{ $res->created_at->format('h:i A') }}</span>
                            </td>

                            {{-- Venue Info --}}
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $res->venue->name ?? 'Unknown' }}
                                <div class="text-xs text-gray-400">{{ $res->venue->location ?? '' }}</div>
                            </td>

                            {{-- Booking Date --}}
                            <td class="px-6 py-4 text-gray-700">
                                {{ \Carbon\Carbon::parse($res->date)->format('D, d M Y') }}
                            </td>

                            {{-- Time --}}
                            <td class="px-6 py-4 text-gray-700">
                                <div class="flex items-center gap-2">
                                    <span class="bg-gray-100 px-2 py-1 rounded text-xs font-bold">{{ \Carbon\Carbon::parse($res->startTime)->format('h:i A') }}</span>
                                    <span class="text-gray-300">➜</span>
                                    <span class="bg-gray-100 px-2 py-1 rounded text-xs font-bold">{{ \Carbon\Carbon::parse($res->endTime)->format('h:i A') }}</span>
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'Approved' => 'bg-green-100 text-green-700 border-green-200',
                                        'Pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                        'Rejected' => 'bg-red-50 text-red-600 border-red-200',
                                        'Cancelled' => 'bg-gray-100 text-gray-500 border-gray-200',
                                    ];
                                    $currentClass = $statusClasses[$res->status] ?? 'bg-gray-50 text-gray-500';
                                @endphp
                                <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-bold {{ $currentClass }} border shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full {{ str_replace(['bg-', 'text-', 'border-'], 'bg-', $currentClass) }} bg-current"></span>
                                    {{ $res->status }}
                                </span>
                            </td>

                            {{-- Actions (Modal) --}}
                            <td class="px-6 py-4 text-center">
                                <div x-data="{ open: false }" @keydown.escape.window="open = false">
                                    <button @click="open = true" class="bg-white border border-iium-green text-iium-green px-3 py-1.5 rounded text-xs hover:bg-iium-green hover:text-white transition font-bold shadow-sm">
                                        View Details
                                    </button>

                                    {{-- Modal Backdrop --}}
                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100"
                                         x-transition:leave-end="opacity-0"
                                         style="display: none;"
                                         class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-60 backdrop-blur-sm p-4">
                                        
                                        {{-- Modal Content --}}
                                        <div @click.away="open = false" 
                                            x-show="open"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 scale-90"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            class="bg-white rounded-lg shadow-2xl w-full max-w-lg p-6 relative text-left border-t-4 border-iium-gold"> {{-- Modal Header --}}
                                            <div class="flex justify-between items-start mb-6 border-b border-gray-100 pb-4">
                                                <div>
                                                    <h3 class="text-xl font-bold text-iium-green">Booking Details</h3>
                                                    <p class="text-xs text-gray-400 uppercase tracking-wide">ID: #{{ $res->reservationID }}</p>
                                                </div>
                                                <button @click="open = false" class="text-gray-400 hover:text-red-500 text-2xl font-bold leading-none">&times;</button>
                                            </div>

                                            <div class="space-y-5 mb-8">
                                                {{-- Reason Section --}}
                                                <div>
                                                    <p class="text-xs font-bold text-iium-gold uppercase tracking-wider mb-1">Reason for Booking</p>
                                                    <p class="text-gray-700 bg-gray-50 p-3 rounded-md border border-gray-100 text-sm leading-relaxed">
                                                        {{ $res->reason ?? 'No reason provided' }}
                                                    </p>
                                                </div>
                                                
                                                {{-- Detailed Grid --}}
                                                <div class="grid grid-cols-2 gap-4">
                                                    {{-- Venue --}}
                                                    <div class="bg-gray-50 p-3 rounded-md border border-gray-100">
                                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Venue</p>
                                                        <p class="text-sm font-bold text-gray-800">{{ $res->venue->name }}</p>
                                                    </div>

                                                    {{-- Kuliyyah --}}
                                                    <div class="bg-gray-50 p-3 rounded-md border border-gray-100">
                                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Kuliyyah</p>
                                                        <p class="text-sm text-gray-800">{{ $res->venue->kuliyyah ?? 'N/A' }}</p>
                                                    </div>

                                                    {{-- Date Logic --}}
                                                    <div class="bg-gray-50 p-3 rounded-md border border-gray-100 col-span-2 sm:col-span-1">
                                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Date</p>
                                                        <p class="text-sm font-bold text-gray-800">
                                                            @if($res->startDate == $res->endDate)
                                                                {{ \Carbon\Carbon::parse($res->startDate)->format('d M Y') }}
                                                            @else
                                                                {{ \Carbon\Carbon::parse($res->startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($res->endDate)->format('d M Y') }}
                                                            @endif
                                                        </p>
                                                    </div>

                                                    {{-- Time --}}
                                                    <div class="bg-gray-50 p-3 rounded-md border border-gray-100 col-span-2 sm:col-span-1">
                                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Time</p>
                                                        <p class="text-sm font-bold text-gray-800">
                                                            {{ \Carbon\Carbon::parse($res->startTime)->format('h:i A') }} - {{ \Carbon\Carbon::parse($res->endTime)->format('h:i A') }}
                                                        </p>
                                                    </div>

                                                    {{-- Location --}}
                                                    <div class="bg-gray-50 p-3 rounded-md border border-gray-100 col-span-2">
                                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Full Location</p>
                                                        <p class="text-sm text-gray-700">{{ $res->venue->location }}</p>
                                                    </div>

                                                    {{-- Status --}}
                                                    <div class="bg-gray-50 p-3 rounded-md border border-gray-100 col-span-2">
                                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Current Status</p>
                                                        <span class="inline-block px-2 py-1 text-xs font-bold rounded uppercase
                                                            @if($res->status === 'Approved') bg-green-100 text-green-700 border border-green-200
                                                            @elseif($res->status === 'Pending') bg-yellow-100 text-yellow-700 border border-yellow-200
                                                            @elseif($res->status === 'Rejected') bg-red-100 text-red-700 border border-red-200
                                                            @else bg-gray-100 text-gray-700 border border-gray-200 @endif">
                                                            {{ $res->status }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Footer Actions --}}
                                            <div class="flex gap-3 justify-end pt-2">
                                                <button @click="open = false" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded text-sm hover:bg-gray-50 font-bold transition">
                                                    Close
                                                </button>
                                                <form action="{{ route('user.reservations.update', $res->reservationID) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="Cancelled">
                                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white border border-red-600 rounded text-sm hover:bg-red-700 shadow font-bold transition">
                                                        Cancel Booking
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-3xl">📅</div>
                                    <h3 class="text-lg font-bold text-gray-700">No upcoming reservations</h3>
                                    <p class="text-sm text-gray-400 mb-4">You haven't made any bookings yet.</p>
                                    <a href="{{ route('reservations.create') }}" class="text-iium-green font-bold hover:underline">Start a new booking &rarr;</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection