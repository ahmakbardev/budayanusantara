<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Flip Book sin Librerias</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body id="flipbook">
    <div class="container" id="container">
        <div class="book-content">
            @foreach ($konten as $index => $page)
                <!-- Tambahkan indeks untuk mengidentifikasi iterasi pertama -->
                <div class="book">
                    @if ($index === 0)
                        <!-- Hanya pada iterasi pertama -->
                        <div class="face-front" id="portada">
                            @if (isset($page['page_front']['judul']))
                                <h1>{{ $page['page_front']['judul'] }}</h1>
                            @endif
                            @if (isset($page['page_front']['konten']))
                                <p>{{ $page['page_front']['konten'] }}</p>
                            @endif
                            @if (isset($page['page_front']['gambar']))
                                <img class="pointer-events-none"
                                    src="{{ asset('storage/' . $page['page_front']['gambar']) }}" alt="Front Image" />
                            @endif
                        </div>
                        <div class="face-back" id="trsf">
                            @if (isset($page['page_front']['judul']))
                                <h1>{{ $page['page_front']['judul'] }}</h1>
                            @endif
                            @if (isset($page['page_front']['konten']))
                                <p>{{ $page['page_front']['konten'] }}</p>
                            @endif
                            @if (isset($page['page_front']['gambar']))
                                <img class="pointer-events-none"
                                    src="{{ asset('storage/' . $page['page_front']['gambar']) }}" alt="Front Image" />
                            @endif
                        </div>
                    @else
                        <!-- Untuk semua iterasi lainnya -->
                        <div class="face-front">
                            @if (isset($page['page_front']['judul']))
                                <h1>{{ $page['page_front']['judul'] }}</h1>
                            @endif
                            @if (isset($page['page_front']['konten']))
                                <p>{{ $page['page_front']['konten'] }}</p>
                            @endif
                            @if (isset($page['page_front']['gambar']))
                                <img class="pointer-events-none"
                                    src="{{ asset('storage/' . $page['page_front']['gambar']) }}" alt="Front Image" />
                            @endif
                        </div>

                        <div class="face-back">
                            @if (isset($page['page_back']['judul']))
                                <h1>{{ $page['page_back']['judul'] }}</h1>
                            @endif
                            @if (isset($page['page_back']['konten']))
                                <p>{{ $page['page_back']['konten'] }}</p>
                            @endif
                            @if (isset($page['page_back']['gambar']))
                                <img class="pointer-events-none"
                                    src="{{ asset('storage/' . $page['page_back']['gambar']) }}" alt="Back Image" />
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div id="modal"
        class="modal hidden fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <div class="modal-content bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Congratulations!</h2>
            <p class="mb-4">You have reached the last page.</p>
            <a href="#" id="finish-btn"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded inline-block">Finish</a>
        </div>
    </div>

    <script>
        // Function to handle finishing the flipbook
        function finishFlipbook() {
            // Simpan data yang selesai ke dalam database
            const namaFlipbook = '{{ session('nama_flipbook') }}';
            const userId = '{{ session('user_id') }}';

            // Buat permintaan POST
            fetch('/flipbookselesai', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Tambahkan token CSRF
                    },
                    body: JSON.stringify({
                        user_id: userId,
                        nama_flipbook: namaFlipbook
                    })
                })
                .then(response => {
                    if (response.ok) {
                        // Redirect ke halaman utama setelah berhasil
                        window.location.href = "/";
                    } else {
                        throw new Error('Failed to finish flipbook.');
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Ambil tombol "Finish" berdasarkan ID
            const finishBtn = document.getElementById("finish-btn");

            // Tambahkan event listener untuk tombol "Finish"
            finishBtn.addEventListener("click", function() {
                // Panggil fungsi finishFlipbook() saat tombol "Finish" diklik
                finishFlipbook();
            });

            var front = document.querySelector(".face-front");
            var back = document.querySelector(".face-back");
            var flip = document.querySelector(".book-content");
            var uno = document.querySelectorAll(".book");
            var portada = document.querySelectorAll("#portada");

            var contZindex = 2;
            var customZindex = 1;

            for (var i = 0; i < uno.length; i++) {
                uno[i].style.zIndex = customZindex;
                customZindex--;

                uno[i].addEventListener("click", function(e) {
                    var tgt = e.target;
                    var unoThis = this;

                    unoThis.style.zIndex = contZindex;
                    contZindex++;

                    if (tgt.getAttribute("class") == "face-front") {
                        unoThis.style.zIndex = contZindex;
                        contZindex += 10;
                        setTimeout(function() {
                            unoThis.style.transform = "rotateY(-180deg)";
                        }, 500);
                    }
                    if (tgt.getAttribute("class") == "face-back") {
                        unoThis.style.zIndex = contZindex;
                        contZindex += 10;

                        setTimeout(function() {
                            unoThis.style.transform = "rotateY(0deg)";
                        }, 500);
                    }

                    if (tgt.getAttribute("id") == "portada") {
                        flip.classList.remove("trnsf-reset");
                        flip.classList.add("trnsf");
                    }
                    if (tgt.getAttribute("id") == "trsf") {
                        flip.classList.remove("trnsf");
                        flip.classList.add("trnsf-reset");
                    }
                });
            }

            // Cek jika halaman terakhir sudah dicapai
            var lastPage = uno[uno.length - 1];
            lastPage.addEventListener("click", function() {
                // Tampilkan modal jika halaman terakhir diklik
                var modal = document.getElementById("modal");
                modal.classList.remove("hidden");
            });
        });
    </script>
</body>

</html>
