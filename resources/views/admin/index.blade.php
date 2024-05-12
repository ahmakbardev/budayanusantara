@extends('admin.layouts.layout')

@section('admin_content')
    <!-- Desktop sidebar -->


    <main class="h-full overflow-y-auto relative">
        <div class="px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-gray-200">
                Dashboard
            </h2>

            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    @livewire('update-status-daerah')
                </div>
            </div>
            <div class="py-5">
                <div class="flex justify-between py-2">
                    <h1 class="text-white text-2xl font-semibold">Konten Per Daerah</h1>
                    <a href="{{ route('tambah.daerah') }}"
                        class="flex items-center justify-between w-fit px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Tambah Daerah
                        <span class="ml-2" aria-hidden="true">+</span>
                    </a>
                </div>
                @livewire('daerah-list')
            </div>
            <div class="py-5">
                <div class="flex justify-between py-2">
                    <h1 class="text-white text-2xl font-semibold">Quest</h1>
                    <a href="{{ route('quest.tambah') }}"
                        class="flex items-center justify-between w-fit px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Tambah Quest
                        <span class="ml-2" aria-hidden="true">+</span>
                    </a>
                </div>
                <div class="grid grid-cols-4 gap-3">
                    @foreach ($quest1s as $quest)
                        @php
                            // Mendapatkan array data JSON
                            $jsonData = json_decode($quest->data, true);
                            // Mengambil data pertama dari array data JSON
                            $firstData = isset($jsonData[0]) ? $jsonData[0] : null;
                        @endphp
                        @if ($firstData)
                            <div
                                class="p-3 rounded-lg border shadow-md flex flex-col gap-2 relative overflow-hidden group hover:scale-95 transition-all ease-in-out">
                                <!-- Menggunakan gambar pertama dari data JSON -->
                                <img class="w-3/4 mx-auto min-h-36 max-h-36 object-contain"
                                    src="{{ asset('storage/' . $firstData['gambar']) }}" alt="">
                                <!-- Menggunakan properti nama_quest -->
                                <p class="text-lg font-semibold text-white">{{ $quest->nama_quest }}</p>
                                <!-- Tautan menuju halaman detail quest -->
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection
