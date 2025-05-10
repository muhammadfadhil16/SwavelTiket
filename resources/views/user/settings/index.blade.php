@extends('layouts.userLayout')

@section('title', 'User Settings')

@section('content')
<div class="container mx-auto mt-10 px-4">
  <div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="bg-blue-800 text-white px-6 py-4">
      <h3 class="text-lg font-semibold">User Settings</h3>
    </div>
    <div class="p-6">
      <div class="text-center mb-6">
        <i class="bi bi-person-circle text-6xl text-gray-500"></i>
        <h5 class="mt-2 text-2xl font-bold">Hi, {{ $user->name_user }}</h5>
      </div>

      <!-- Flash Message -->
      @if(session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
          <i class="bi bi-x text-green-700"></i>
        </button>
      </div>
      @endif

      <!-- Form untuk Mengubah Nama -->
      <form method="POST" action="{{ route('user.settings.update') }}">
        @csrf
        <div class="mb-4">
          <label for="name_user" class="block text-sm font-medium text-gray-700">Full Name</label>
          <input type="text" id="name_user" name="name_user" value="{{ old('name_user', $user->name_user) }}"
                 class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
          @error('name_user')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Tampilkan Email (hanya baca) -->
        <div class="mb-4">
          <label for="email_user" class="block text-sm font-medium text-gray-700">Email Address</label>
          <input type="email" id="email_user" value="{{ $user->email_user }}" disabled
                 class="mt-1 block w-full rounded-lg bg-gray-100 border-gray-300 shadow-sm sm:text-sm">
        </div>

        <div class="flex justify-end">
          <button type="submit"
                  class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-800 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
