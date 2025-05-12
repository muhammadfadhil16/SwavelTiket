@extends('layouts.authLayout')

@section('title', 'Login')

@section('content')

<div class="py-20">
    <div class="flex h-full items-center justify-center">
        <div
            class="rounded-lg border border-gray-200 bg-white shadow-md dark:border-gray-700 dark:bg-gray-900 flex-col flex h-full items-center justify-center sm:px-4">
            <div class="flex h-full flex-col justify-center gap-4 p-6">
                <div class="left-0 right-0 inline-block border-gray-200 px-2 py-2.5 sm:px-4">

                    <!-- Notifikasi -->
                    @if (session('error'))
                        <div class="notification error">
                            {{ session('error') }}
                        </div>
                    @elseif (session('success'))
                        <div class="notification success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4 pb-4">
                        @csrf
                        <h1 class="mb-4 text-2xl font-bold dark:text-white">Login</h1>

                        <!-- Input Email -->
                        <div>
                            <div class="mb-2">
                                <label class="text-sm font-medium text-gray-900 dark:text-gray-300" for="email_user">Email:</label>
                            </div>
                            <div class="flex w-full rounded-lg pt-1">
                                <div class="relative w-full">
                                    <input
                                        class="block w-full border disabled:cursor-not-allowed disabled:opacity-50 bg-gray-50 border-gray-300 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-cyan-500 dark:focus:ring-cyan-500 p-2.5 text-sm rounded-lg"
                                        id="email_user" type="email" name="email_user" placeholder="email@example.com" required autofocus />
                                </div>
                            </div>
                        </div>

                        <!-- Input Password -->
                        <div>
                            <div class="mb-2">
                                <label class="text-sm font-medium text-gray-900 dark:text-gray-300" for="password">Password:</label>
                            </div>
                            <div class="flex w-full rounded-lg pt-1">
                                <div class="relative w-full">
                                    <input
                                        class="block w-full border disabled:cursor-not-allowed disabled:opacity-50 bg-gray-50 border-gray-300 text-gray-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-cyan-500 dark:focus:ring-cyan-500 p-2.5 text-sm rounded-lg"
                                        id="password" type="password" name="password" placeholder="Password" required />
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Login -->
                        <div class="flex flex-col gap-2">
                            <button
                                class="mt-2 tracking-wide font-semibold bg-blue-800 text-gray-100 w-full py-4 rounded-lg hover:bg-blue-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                                </svg>
                                <span class="ml-3">
                                    Sign In
                                </span>
                            </button>
                        </div>
                    </form>

                    <!-- Link ke Register -->
                    <div class="min-w-[270px]">
                        <div class="mt-4 text-center dark:text-gray-200">New user?
                            <a class="text-blue-500 underline hover:text-blue-600" href="{{ route('register') }}">Create account here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
