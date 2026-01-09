@extends('layouts.app')

@section('content')

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-3xl font-serif font-bold text-gray-800 border-b-2 border-iium-gold inline-block pb-2">
                Manage Venues
            </h2>
            <p class="text-gray-500 text-sm mt-1">Add, edit, or remove university venues.</p>
        </div>
        
        {{-- Add New Venue Button --}}
        <a href="{{ route('venues.create') }}" class="bg-iium-green text-white px-5 py-2.5 rounded-lg hover:bg-iium-dark transition shadow-lg flex items-center gap-2 font-bold text-sm transform hover:scale-105 duration-200">
            <span class="text-lg font-bold">+</span> Add New Venue
        </a>
    </div>

    {{-- Venues Table Card --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
        
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm whitespace-nowrap">
                <thead class="uppercase tracking-wider border-b-2 border-iium-gold bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-bold text-iium-green">Image</th>
                        <th class="px-6 py-4 font-bold text-iium-green">Venue Name</th>
                        <th class="px-6 py-4 font-bold text-iium-green">Kuliyyah</th>
                        <th class="px-6 py-4 font-bold text-iium-green text-center">Capacity</th>
                        <th class="px-6 py-4 font-bold text-iium-green">Location</th>
                        <th class="px-6 py-4 font-bold text-iium-green text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($venues as $venue)
                        <tr class="hover:bg-gray-50 transition group">
                            
                            {{-- Image Column --}}
                            <td class="px-6 py-4">
                                <div class="h-12 w-20 rounded bg-gray-200 overflow-hidden border border-gray-300">
                                    @if($venue->image)
                                        <img src="{{ asset('storage/' . $venue->image) }}" alt="Venue" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-400 text-xs">No Img</div>
                                    @endif
                                </div>
                            </td>

                            {{-- Name --}}
                            <td class="px-6 py-4 font-bold text-gray-800">
                                {{ $venue->name }}
                            </td>

                            {{-- Kuliyyah --}}
                            <td class="px-6 py-4 text-gray-600">
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs border border-gray-200 font-semibold">
                                    {{ $venue->kuliyyah }}
                                </span>
                            </td>

                            {{-- Capacity --}}
                            <td class="px-6 py-4 text-center text-gray-600">
                                {{ $venue->capacity }} <span class="text-xs text-gray-400">pax</span>
                            </td>

                            {{-- Location --}}
                            <td class="px-6 py-4 text-gray-500 text-xs max-w-xs truncate">
                                {{ $venue->location }}
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-2">
                                    {{-- Edit --}}
                                    <a href="{{ route('venues.edit', $venue->venueID) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-full transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    {{-- Delete (with confirmation) --}}
                                    <form action="{{ route('venues.destroy', $venue->venueID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{ $venue->name }}? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-full transition" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="text-4xl mb-2 opacity-50">🏢</span>
                                    <p class="text-lg font-medium">No venues found.</p>
                                    <p class="text-sm text-gray-400 mb-4">Start by adding the first venue to the system.</p>
                                    <a href="{{ route('venues.create') }}" class="text-iium-green font-bold hover:underline">Add Venue Now</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination (If you use paginate() in controller later) --}}
        {{-- <div class="p-4 border-t border-gray-100">
            {{ $venues->links() }}
        </div> --}}
    </div>

@endsection