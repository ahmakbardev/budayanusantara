@extends('layouts.layout')

@section('content')
    <div class="flex bg-[#ff9532] justify-center items-center h-screen relative">
        <div
            class="absolute top-3 right-3 p-3 rounded-md bg-white {{ session()->has('error') ? 'block' : 'hidden' }} transition-all transform {{ session()->has('error') ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-full' }}">
            @if (session()->has('error'))
                <h1>{{ session('error') }}</h1>
            @endif
        </div>


        <a href="/" class="absolute flex gap-5 top-5 left-5 items-center"><i
                class="text-sm bg-white rounded-full w-8 aspect-square grid place-items-center fa-solid fa-arrow-left"></i><span>
                Kembali ke Beranda</span></a>
        <div class="bg-white p-8 rounded shadow-2xl max-w-sm w-full">
            <h2 class="text-2xl font-semibold mb-6">Login</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address
                        <input type="email" id="email" name="email"
                            class="mt-1 py-2 px-3 block w-full transition-all ease-in-out focus:rounded-md border-b border-b-slate-400 shadow-sm focus:border-indigo-300 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            required>

                    </label>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password
                        <input type="password" id="password" name="password"
                            class="mt-1 py-2 px-3 block w-full transition-all ease-in-out focus:rounded-md border-b border-b-slate-400 shadow-sm focus:border-indigo-300 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            required>

                    </label>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="text-white bg-[#EA580C] hover:ring-[#EA580C] hover:bg-transparent hover:ring-1 hover:text-[#EA580C] transition-all ease-in-out py-2 px-5 rounded-md">Login</button>
                    <p class="text-sm ">Belum punya akun? <a href="{{ route('register.form') }}"
                            class="text-[#EA580C] hover:text-[#ff9a64]">Daftar</a></p>
                </div>
            </form>
        </div>
    </div>
@endsection
