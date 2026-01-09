@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">
    {{-- Header --}}
    <div class="mb-6 border-b border-gray-200 pb-4">
        <h2 class="text-3xl font-serif font-bold text-gray-800 border-b-2 border-iium-gold inline-block pb-1">
            Register User
        </h2>
        <p class="text-gray-500 text-sm mt-1">Create a new account for a student or administrator.</p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-8">
        {{-- Display Errors --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            {{-- Name --}}
            <div class="mb-5">
                <label for="name" class="block text-gray-700 font-bold mb-2">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-iium-gold focus:border-transparent" required autofocus>
            </div>

            {{-- Email --}}
            <div class="mb-5">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-iium-gold focus:border-transparent" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                {{-- Phone (Optional) --}}
                <div>
                    <label for="phone" class="block text-gray-700 font-bold mb-2">Phone Number</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-iium-gold focus:border-transparent">
                </div>

                {{-- Role Selection --}}
                <div>
                    <label for="role" class="block text-gray-700 font-bold mb-2">Role</label>
                    <select id="role" name="role" class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-iium-gold focus:border-transparent">
                        <option value="student">Student</option>
                        <option value="admin">Administrator</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
            </div>

            {{-- Password Section --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                {{-- Password --}}
                <div>
                    <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
                    <input id="password" type="password" name="password" class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-iium-gold focus:border-transparent" required>
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-iium-gold focus:border-transparent" required>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end mt-8 border-t border-gray-100 pt-6">
                <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700 font-bold mr-6">
                    Cancel
                </a>
                <button type="submit" class="bg-iium-green hover:bg-green-800 text-white font-bold py-2 px-6 rounded shadow transition">
                    Register User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection