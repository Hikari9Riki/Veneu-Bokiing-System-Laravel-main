@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    <div class="bg-white p-6 rounded-lg shadow-md mb-6 border-l-4 border-blue-600">
        <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
        <p class="text-gray-600">Review pending venue requests.</p>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm whitespace-nowrap">
                <thead class="uppercase tracking-wider border-b-2 border-gray-200 bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-medium text-gray-500">Date Request</th>
                        <th class="px-6 py-4 font-medium text-gray-500">Applicant / Venue</th>
                        <th class="px-6 py-4 font-medium text-gray-500">Event Date</th>
                        <th class="px-6 py-4 font-medium text-gray-500">Time</th>
                        <th class="px-6 py-4 font-medium text-gray-500 text-center">Action / Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pendingReservations as $res)
                        <tr class="hover:bg-gray-50 transition">
                            
                            {{-- Column 1: Date Request --}}
                            <td class="px-6 py-4 text-gray-500">
                                {{ $res->created_at->format('d M Y') }}
                                <div class="text-xs text-gray-400">{{ $res->created_at->diffForHumans() }}</div>
                            </td>

                            {{-- Column 2: Venue & User --}}
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800">{{ $res->venue->name ?? 'Unknown Venue' }}</div>
                                <div class="text-xs text-blue-600">by {{ $res->user->name ?? 'Unknown User' }}</div>
                            </td>

                            {{-- Column 3: Event Date --}}
                            <td class="px-6 py-4 text-gray-700 font-medium">
                                {{ \Carbon\Carbon::parse($res->date)->format('D, d M Y') }}
                            </td>

                            {{-- Column 4: Start & End Time --}}
                            <td class="px-6 py-4 text-gray-700">
                                <span class="bg-gray-100 px-2 py-1 rounded text-xs font-bold">
                                    {{ \Carbon\Carbon::parse($res->startTime)->format('h:i A') }}
                                </span>
                                <span class="text-gray-400 mx-1">-</span>
                                <span class="bg-gray-100 px-2 py-1 rounded text-xs font-bold">
                                    {{ \Carbon\Carbon::parse($res->endTime)->format('h:i A') }}
                                </span>
                            </td>

                            {{-- Column 5: Detail & Actions (MODAL VERSION) --}}
                            <td class="px-6 py-4 text-center">
                                <div x-data="{ open: false }">
                                    {{-- 1. The Trigger Button --}}
                                    <button @click="open = true" class="bg-blue-600 text-white px-3 py-1.5 rounded text-xs hover:bg-blue-700 transition">
                                        Review
                                    </button>

                                    {{-- 2. The Modal Overlay (Covers the whole screen) --}}
                                    <div x-show="open" 
                                         style="display: none;"
                                         class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-sm">
                                        
                                        {{-- 3. The Modal Box --}}
                                        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 transform transition-all scale-100 relative">
                                            
                                            {{-- Header --}}
                                            <div class="flex justify-between items-center mb-4 border-b pb-2">
                                                <h3 class="text-lg font-bold text-gray-800">Review Request</h3>
                                                <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                                                    ✕
                                                </button>
                                            </div>

                                            {{-- Content --}}
                                            <div class="text-left mb-6">
                                                <p class="text-xs font-bold text-gray-500 uppercase">Requester:</p>
                                                <div class="mt-1 p-3 bg-gray-50 rounded border text-gray-700 italic">
                                                    {{ $res->user->name ?? 'Unknown User' }}
                                                </div>
                                                <p class="text-xs font-bold text-gray-500 uppercase">Venue:</p>
                                                <div class="mt-1 p-3 bg-gray-50 rounded border text-gray-700 italic">
                                                    {{ $res->venue->name ?? 'Unknown Venue' }}
                                                </div>
                                                <p class="text-xs font-bold text-gray-500 uppercase">Kuliyyah:</p>
                                                <div class="mt-1 p-3 bg-gray-50 rounded border text-gray-700 italic">
                                                    "{{ $res->venue->kuliyyah ?? 'N/A' }}"
                                                </div>
                                                <p class="text-xs font-bold text-gray-500 uppercase">Location:</p>
                                                <div class="mt-1 p-3 bg-gray-50 rounded border text-gray-700 italic">
                                                    "{{ $res->venue->location ?? 'N/A' }}"
                                                </div>
                                                <p class="text-xs font-bold text-gray-500 uppercase">Date:</p>
                                                <div class="mt-1 p-3 bg-gray-50 rounded border text-gray-700 italic">
                                                    {{ \Carbon\Carbon::parse($res->date)->format('D, d M Y') }}
                                                </div>
                                                <p class="text-xs font-bold text-gray-500 uppercase">Start Time:</p>
                                                <div class="mt-1 p-3 bg-gray-50 rounded border text-gray-700 italic">
                                                    {{ \Carbon\Carbon::parse($res->startTime)->format('h:i A') }}
                                                </div>
                                                <p class="text-xs font-bold text-gray-500 uppercase">End Time:</p>
                                                <div class="mt-1 p-3 bg-gray-50 rounded border text-gray-700 italic">
                                                   {{ \Carbon\Carbon::parse($res->endTime)->format('h:i A') }}
                                                </div>
                                                <p class="text-xs font-bold text-gray-500 uppercase">Reason for booking:</p>
                                                <div class="mt-1 p-3 bg-gray-50 rounded border text-gray-700 italic">
                                                    "{{ $res->reason }}"
                                                </div>
                                            </div>

                                            {{-- Action Buttons --}}
                                            <div class="flex gap-3 justify-end">
                                                <button @click="open = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded text-sm hover:bg-gray-300">
                                                    Cancel
                                                </button>

                                                {{-- Reject Form --}}
                                                <form action="{{ route('admin.reservations.update', $res->reservationID) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="Rejected">
                                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded text-sm hover:bg-red-700 shadow">
                                                        Reject
                                                    </button>
                                                </form>

                                                {{-- Approve Form --}}
                                                <form action="{{ route('admin.reservations.update', $res->reservationID) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="Approved">
                                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded text-sm hover:bg-green-700 shadow">
                                                        Approve
                                                    </button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                    {{-- End Modal --}}

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <p class="text-lg">No pending reservations.</p>
                                <p class="text-sm">Great job! All requests have been processed.</p>
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