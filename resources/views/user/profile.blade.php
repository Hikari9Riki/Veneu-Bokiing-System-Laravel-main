@extends('layouts.app')

@section('content')

    {{-- Page Header --}}
    <div class="mb-6">
        <h2 class="text-3xl font-serif font-bold text-gray-800 border-b-2 border-iium-gold inline-block pb-2">
            User Details
        </h2>
        <p class="text-gray-500 text-sm mt-1">Update your personal information and security settings.</p>
    </div>

    {{-- Profile Card --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200 max-w-4xl flex flex-col md:flex-row overflow-hidden">
        
        {{-- Left Column: Avatar --}}
        <div class="w-full md:w-1/3 bg-gray-50 p-8 text-center border-b md:border-b-0 md:border-r border-gray-200 flex flex-col items-center justify-center">
            <div class="w-32 h-32 bg-white rounded-full mb-4 flex items-center justify-center border-4 border-iium-gold shadow-sm">
                <span class="text-5xl text-gray-300">📷</span>
            </div>
            <p class="text-sm font-bold text-iium-green uppercase tracking-wide">Profile Picture</p>
            <p class="text-xs text-gray-400 mt-1">Managed via IIUM Database</p>
        </div>

        {{-- Right Column: Form --}}
        <div class="w-full md:w-2/3 p-8">
            
            {{-- Validation Errors (Success is handled globally in layout, but specific form errors go here) --}}
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 mb-6 text-sm rounded-r shadow-sm">
                    <p class="font-bold mb-1">Please fix the following errors:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error) 
                            <li>{{ $error }}</li> 
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf 
                @method('PUT')
                
                {{-- Name --}}
                <div class="mb-4">
                    <label class="block text-xs font-bold uppercase mb-1 text-gray-500">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                           class="w-full border border-gray-300 p-2.5 rounded-lg text-gray-800 focus:border-iium-green focus:ring-1 focus:ring-iium-green outline-none transition">
                </div>

                {{-- Contact Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1 text-gray-500">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                               class="w-full border border-gray-300 p-2.5 rounded-lg text-gray-800 focus:border-iium-green focus:ring-1 focus:ring-iium-green outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1 text-gray-500">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="w-full border border-gray-300 p-2.5 rounded-lg text-gray-800 focus:border-iium-green focus:ring-1 focus:ring-iium-green outline-none transition">
                    </div>
                </div>

                <hr class="my-6 border-gray-100">

                {{-- Password Section --}}
                <div class="mb-4">
                    <label class="block text-xs font-bold uppercase mb-1 text-gray-500">New Password <span class="text-gray-400 font-normal lowercase">(Leave blank to keep current)</span></label>
                    <input type="password" name="password" placeholder="••••••••" 
                           class="w-full border border-gray-300 p-2.5 rounded-lg text-gray-800 focus:border-iium-green focus:ring-1 focus:ring-iium-green outline-none transition">
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold uppercase mb-1 text-gray-500">Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••" 
                           class="w-full border border-gray-300 p-2.5 rounded-lg text-gray-800 focus:border-iium-green focus:ring-1 focus:ring-iium-green outline-none transition">
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-iium-green text-white font-bold py-2.5 px-6 rounded-lg text-sm hover:bg-iium-dark shadow-md transition transform hover:-translate-y-0.5">
                        Update Details
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection