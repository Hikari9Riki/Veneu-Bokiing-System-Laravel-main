@extends('layouts.app')

@section('content')

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-3xl font-serif font-bold text-gray-800 border-b-2 border-iium-gold inline-block pb-2">
                Manage Users
            </h2>
            <p class="text-gray-500 text-sm mt-1">View registered students and staff.</p>
        </div>

        <div class="flex gap-3">
            {{-- Add User Button --}}
            <a href="{{ route('users.create') }}" class="bg-iium-green hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Register New User
            </a>

            {{-- Stat Card --}}
            <div class="bg-white px-4 py-2 rounded shadow border border-gray-200 text-sm flex flex-col justify-center">
                <span class="text-gray-500 font-bold text-xs uppercase">Total Users</span>
                <span class="text-iium-green font-bold text-lg leading-none">{{ $users->count() }}</span>
            </div>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm whitespace-nowrap">
                <thead class="uppercase tracking-wider border-b-2 border-iium-gold bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-bold text-iium-green">ID</th>
                        <th class="px-6 py-4 font-bold text-iium-green">Name</th>
                        <th class="px-6 py-4 font-bold text-iium-green">Email / Phone</th>
                        <th class="px-6 py-4 font-bold text-iium-green text-center">Role</th>
                        <th class="px-6 py-4 font-bold text-iium-green text-center">Joined</th>
                        <th class="px-6 py-4 font-bold text-iium-green text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            
                            {{-- ID --}}
                            <td class="px-6 py-4 text-gray-500 font-mono">
                                #{{ $user->id }}
                            </td>

                            {{-- Name --}}
                            <td class="px-6 py-4 font-bold text-gray-800">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs text-gray-600 font-bold">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    {{ $user->name }}
                                </div>
                            </td>

                            {{-- Contact --}}
                            <td class="px-6 py-4">
                                <div class="text-gray-700">{{ $user->email }}</div>
                                <div class="text-xs text-gray-400">{{ $user->phone ?? 'No Phone' }}</div>
                            </td>

                            {{-- Role --}}
                            <td class="px-6 py-4 text-center">
                                @if($user->role === 'admin')
                                    <span class="bg-purple-100 text-purple-700 border border-purple-200 px-2 py-1 rounded text-xs font-bold uppercase">
                                        Admin
                                    </span>
                                @elseif($user->role === 'staff')
                                    <span class="bg-blue-50 text-blue-600 border border-blue-100 px-2 py-1 rounded text-xs font-bold uppercase">
                                        Staff
                                    </span>
                                @else
                                    <span class="bg-green-50 text-green-600 border border-green-100 px-2 py-1 rounded text-xs font-bold uppercase">
                                        Student
                                    </span>
                                @endif
                            </td>

                            {{-- Date --}}
                            <td class="px-6 py-4 text-center text-gray-500">
                                {{ $user->created_at->format('d M Y') }}
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-center">
                                @if(Auth::id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure? This will delete the user and all their reservations.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs border border-red-200 bg-red-50 px-3 py-1 rounded transition hover:bg-red-100">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-gray-300 italic">Current User</span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection