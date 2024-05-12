@extends('layouts.layout')

@section('content')
    <div class="flex max-sm:flex-col gap-3 md:gap-10 justify-between items-center py-10 px-5 md:px-20 relative">
        <div class="flex flex-col justify-center h-full gap-3 sm:basis-1/2 md:basis-1/2 lg:basis-1/2 max-sm:order-2">
            <h1 class="text-3xl text-wrap lg:text-6xl font-bold">BudayaNusantara</h1>
            <p class="text-base text-start lg:text-lg">Selamat Datang di BudayaNusantara, Mari Menjelajahi Kekayaan Budaya
                Indonesia. Mulai
                Petualangan Pendidikan Anda di BudayaNusantara!</p>
            <button
                class="text-white mt-5 bg-[#EA580C] hover:ring-[#EA580C] hover:bg-transparent hover:ring-1 hover:text-[#EA580C] transition-all ease-in-out text-lg py-3 px-10 rounded-md w-fit">Belajar
                Sekarang</button>
        </div>
        <div class="sm:basis-1/2 md:basis-1/2 xl:basis-2/5 relative max-sm:order-1">
            <img class="z-10 relative" src="{{ asset('assets/images/banner/head-1.png') }}" alt="">
        </div>
        <img class="absolute left-1/2 -translate-x-1/2 md:translate-x-0 md:left-[unset] z-0 top-14 w-[50rem] right-10"
            src="{{ asset('assets/images/banner/head-2.png') }}" alt="">
    </div>
    <div class="flex flex-col max-sm:text-center gap-3 py-10 px-5 md:px-20 items-center">
        <h1 class="text-2xl lg:text-5xl font-bold">Tahukah Kamu?</h1>
        <h1 class="text-base lg:text-xl font-medium md:w-1/2 text-center">Tiap Daerah yang ada di Indonesia memiliki budaya
            yang
            berbeda dan sangat keren lo?!Mau tahu apa saja? Pelajari Sekarang!</h1>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @foreach ($daerahs as $daerah)
                <div class="p-3 rounded-lg border shadow-md flex flex-col gap-2 relative overflow-hidden group">
                    @if ($daerah->status === 'draft')
                        <!-- Status draft menunjukkan "Coming Soon" dan mencegah interaksi -->
                        <span
                            class="coming absolute invisible translate-y-10 group-hover:-translate-y-0 group-hover:visible cursor-default transition-all ease-in-out top-0 left-0 flex justify-center items-center h-full w-full bg-green-300/20 text-3xl font-bold">
                            Coming Soon
                        </span>
                        <span class="py-1 px-2 bg-yellow-500 rounded-full text-xs font-semibold w-fit text-white">Coming
                            Soon</span>
                        <img class="w-3/4 mx-auto" src="{{ asset('storage/' . $daerah->cover_image) }}" alt="">
                        <p class="text-lg font-semibold">{{ $daerah->nama_daerah }}</p>
                        <button
                            class="ring-1 py-2 rounded-md ring-sky-400 hover:ring-2 transition-all ease-in-out font-semibold text-sm"
                            disabled>
                            Belajar Sekarang
                        </button>
                    @else
                        <!-- Jika status bukan draft, maka dapat diakses -->
                        <span class="py-1 px-2 bg-green-500 rounded-full text-xs font-semibold w-fit text-white">NEW</span>
                        <img class="w-3/4 mx-auto" src="{{ asset('storage/' . $daerah->cover_image) }}" alt="">
                        <p class="text-lg font-semibold">{{ $daerah->nama_daerah }}</p>
                        <a href="{{ route('flipbook', ['id' => $daerah->id]) }}"
                            class="text-center ring-1 py-2 rounded-md ring-sky-400 hover:ring-2 transition-all ease-in-out font-semibold text-sm">
                            Belajar Sekarang
                        </a>
                    @endif
                </div>
            @endforeach



            {{-- <div class="p-3 rounded-lg border shadow-md flex flex-col gap-2 relative overflow-hidden group">
                <span
                    class="coming absolute invisible translate-y-10 group-hover:-translate-y-0 group-hover:visible cursor-default transition-all ease-in-out top-0 left-0 flex justify-center items-center h-full w-full bg-green-300/20 text-3xl font-bold">Coming
                    Soon</span>

                <span class="py-1 px-2 bg-yellow-500 rounded-full text-xs font-semibold w-fit text-white">Coming
                    Soon</span>
                <img class="w-3/4 mx-auto" src="{{ asset('assets/images/daerah/kalimantan.png') }}" alt="">
                <p class="text-lg font-semibold">Pulau Kalimantan</p>
                <button
                    class="ring-1 py-2 rounded-md ring-sky-400 hover:ring-2 transition-all ease-in-out font-semibold text-sm">Belajar
                    Sekarang</button>
            </div>
            <div class="p-3 rounded-lg border shadow-md flex flex-col gap-2 relative overflow-hidden group">
                <span
                    class="coming absolute invisible translate-y-10 group-hover:-translate-y-0 group-hover:visible cursor-default transition-all ease-in-out top-0 left-0 flex justify-center items-center h-full w-full bg-green-300/20 text-3xl font-bold">Coming
                    Soon</span>

                <span class="py-1 px-2 bg-yellow-500 rounded-full text-xs font-semibold w-fit text-white">Coming
                    Soon</span>
                <img class="w-3/4 mx-auto" src="{{ asset('assets/images/daerah/sulawesi.png') }}" alt="">
                <p class="text-lg font-semibold">Pulau Sulawesi</p>
                <button
                    class="ring-1 py-2 rounded-md ring-sky-400 hover:ring-2 transition-all ease-in-out font-semibold text-sm">Belajar
                    Sekarang</button>
            </div> --}}
        </div>
    </div>
    <div class="flex flex-col max-sm:text-center gap-3 py-10 px-5 md:px-20">
        <h1 class="text-2xl lg:text-5xl font-bold text-center">Challenge Untuk Kamu</h1>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @foreach ($quest1s as $quest)
                @php
                    // Mendapatkan array data JSON
                    $jsonData = json_decode($quest->data, true);
                    // Mengambil data pertama dari array data JSON
                    $firstData = isset($jsonData[0]) ? $jsonData[0] : null;
                @endphp
                @if ($firstData)
                    <div
                        class="p-3 rounded-lg border shadow-md flex flex-col gap-2 relative overflow-hidden group hover:scale-95 hover:shadow-2xl transition-all ease-in-out">
                        <!-- Menggunakan gambar pertama dari data JSON -->
                        <img class="w-3/4 mx-auto min-h-56 max-h-5min-h-56 object-contain"
                            src="{{ asset('storage/' . $firstData['gambar']) }}" alt="">
                        <!-- Menggunakan properti nama_quest -->
                        <p class="text-lg font-semibold">{{ $quest->nama_quest }}</p>
                        <!-- Tautan menuju halaman detail quest -->
                        <a href="{{ route('quest_detail', ['id' => $quest->id]) }}"
                            class="ring-1 py-2 text-center rounded-md ring-sky-400 hover:ring-2 transition-all ease-in-out font-semibold text-sm">
                            Selesaikan Quest
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
