@extends('layouts.layout')

@section('content')
    <div class="flex flex-col max-sm:text-center gap-3 py-10 px-5 md:px-20 items-center">
        <h1 class="text-2xl lg:text-5xl font-bold">Proses Pembelajaran kamu</h1>
        <div class="grid grid-cols-4 gap-5 w-full mb-10">
            <div class="flex flex-col">
                <h1 class="text-2xl">Flipbook</h1>
                <div class="p-3 rounded-md bg-white" style="">
                    <canvas id="flipbookChart" width="100" height="100"></canvas>
                </div>
            </div>
            <div class="flex flex-col">
                <h1 class="text-2xl">Challenge</h1>
                <div class="p-3 rounded-md bg-white" style="">
                    <canvas id="questChart" width="100" height="100"></canvas>
                </div>
            </div>


            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Ambil data flipbook dan quest dari blade template
                var flipbooks = @json($flipbooks);
                var quests = @json($quests);

                // Ambil konteks untuk chart flipbook
                var flipbookCtx = document.getElementById('flipbookChart').getContext('2d');

                // Ambil nama flipbook yang sudah diselesaikan
                var flipbookLabels = flipbooks.map(function(flipbook) {
                    return flipbook.nama_flipbook;
                });

                // Ambil data flipbook yang sudah diselesaikan
                var flipbookData = flipbooks.map(function(flipbook) {
                    return flipbook.status ? 1 : 0;
                });

                // Buat chart donut untuk flipbook
                var flipbookChart = new Chart(flipbookCtx, {
                    type: 'doughnut',
                    data: {
                        labels: flipbookLabels,
                        datasets: [{
                            data: flipbookData,
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(255, 99, 132, 0.6)',
                                // Tambahkan warna tambahan jika diperlukan
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 99, 132, 1)',
                                // Tambahkan warna tambahan jika diperlukan
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });

                // Ambil konteks untuk chart quest
                var questCtx = document.getElementById('questChart').getContext('2d');

                // Ambil nama quest yang sudah diselesaikan
                var questLabels = quests.map(function(quest) {
                    return quest.nama_quest;
                });

                // Ambil data quest yang sudah diselesaikan
                var questData = quests.map(function(quest) {
                    return quest.nilai;
                });

                // Buat chart donut untuk quest
                var questChart = new Chart(questCtx, {
                    type: 'doughnut',
                    data: {
                        labels: questLabels,
                        datasets: [{
                            data: questData,
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(255, 99, 132, 0.6)',
                                // Tambahkan warna tambahan jika diperlukan
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 99, 132, 1)',
                                // Tambahkan warna tambahan jika diperlukan
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            </script>

        </div>
        <h1 class="text-2xl lg:text-5xl font-bold">Belajar Budaya Indonesia disini</h1>
        <h1 class="text-base lg:text-xl font-medium md:w-1/2 text-center">Tiap Daerah yang ada di Indonesia memiliki budaya
            yang
            berbeda dan sangat keren lo?! Mau tahu apa saja? Pelajari Sekarang!</h1>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @foreach ($daerahs as $daerah)
                <div
                    class="p-3 rounded-lg bg-white border shadow-md flex flex-col gap-2 relative overflow-hidden group hover:scale-95 hover:shadow-2xl transition-all ease-in-out">
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
                        <img class="w-3/4 mx-auto min-h-48 max-h-48" src="{{ asset('storage/' . $daerah->cover_image) }}"
                            alt="">
                        <p class="text-lg font-semibold">{{ $daerah->nama_daerah }}</p>
                        <a href="{{ route('flipbook', ['id' => $daerah->id]) }}"
                            class="text-center ring-1 py-2 rounded-md ring-sky-400 hover:ring-2 transition-all ease-in-out font-semibold text-sm">
                            Belajar Sekarang
                        </a>
                    @endif
                </div>
            @endforeach
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
                        class="p-3 rounded-lg bg-white border shadow-md flex flex-col gap-2 relative overflow-hidden group hover:scale-95 hover:shadow-2xl transition-all ease-in-out">
                        <!-- Menggunakan gambar pertama dari data JSON -->
                        <img class="w-3/4 mx-auto min-h-56 max-h-56 object-contain"
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
