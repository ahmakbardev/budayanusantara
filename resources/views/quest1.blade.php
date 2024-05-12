@extends('layouts.layout')

@section('content')
    <section class="score">
        <span class="correct">0</span>/<span class="total">0</span>
        <button id="play-again-btn">Play Again</button>
    </section>
    <section class="draggable-items">
        <!-- Will be dynamically populated -->
    </section>
    <section class="matching-pairs">
        <!-- Will be dynamically populated -->
    </section>

    <!-- Modal -->
    <div id="modal"
        class="modal hidden fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <div class="modal-content bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Congratulations!</h2>
            <p class="mb-4">You have completed the game.</p>
            <a href="#" id="finish-btn"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded inline-block">Selesai</a>
        </div>
    </div>

    <script>
        let correct = 0;
        let total = 0;
        let totalDraggableItems = {{ $totalDraggableItems }};
        let totalMatchingPairs = {{ $totalMatchingPairs }};

        const scoreSection = document.querySelector(".score");
        const correctSpan = scoreSection.querySelector(".correct");
        const totalSpan = scoreSection.querySelector(".total");
        const playAgainBtn = scoreSection.querySelector("#play-again-btn");

        const draggableItems = document.querySelector(".draggable-items");
        const matchingPairs = document.querySelector(".matching-pairs");
        let draggableElements;
        let droppableElements;
        let parsedBrands;

        initiateGame();

        function initiateGame() {
            // Parse string JSON menjadi objek JavaScript
            const jsonString = `{!! addslashes($quest->data) !!}`;
            parsedBrands = JSON.parse(jsonString);

            // Inisialisasi jumlah pasangan pencocokan yang benar
            totalMatchingPairs = parsedBrands.length;
            console.log("Total Matching Pairs:", totalMatchingPairs);

            // Menghasilkan item draggable secara acak
            const randomDraggableBrands = generateRandomItemsArray(totalDraggableItems, parsedBrands);
            // Menghasilkan item droppable secara acak
            const randomDroppableBrands = totalMatchingPairs < totalDraggableItems ? generateRandomItemsArray(
                totalMatchingPairs, randomDraggableBrands) : randomDraggableBrands;
            // Mengurutkan item droppable secara alfabetis
            const alphabeticallySortedRandomDroppableBrands = [...randomDroppableBrands].sort((a, b) => a.nama.toLowerCase()
                .localeCompare(b.nama.toLowerCase()));

            // Menambahkan elemen "draggable-items" ke DOM
            for (let i = 0; i < randomDraggableBrands.length; i++) {
                draggableItems.insertAdjacentHTML("beforeend",
                    `<img class="draggable" draggable="true" style="background-color: white !important; background-size: cover;" src="{{ asset('storage') }}/${randomDraggableBrands[i].gambar}" id="${randomDraggableBrands[i].nama}">`
                );
            }

            // Menambahkan elemen "matching-pairs" ke DOM
            for (let i = 0; i < alphabeticallySortedRandomDroppableBrands.length; i++) {
                matchingPairs.insertAdjacentHTML("beforeend",
                    `<div class="matching-pair"><span id="text-clue" class="label text-start text-lg">${alphabeticallySortedRandomDroppableBrands[i].clue}</span><span class="droppable" data-brand="${alphabeticallySortedRandomDroppableBrands[i].nama}" style="background-image: url('{{ asset('storage') }}/${alphabeticallySortedRandomDroppableBrands[i].background}')"></span></div>`
                );

            }

            // Menambahkan kelas droppable ke semua elemen droppable
            droppableElements = document.querySelectorAll(".droppable");
            droppableElements.forEach(elem => {
                elem.classList.add("droppable");
            });

            // Menambahkan event listeners untuk drop events ke semua elemen droppable
            droppableElements.forEach(elem => {
                elem.addEventListener("dragenter", dragEnter);
                elem.addEventListener("dragover", dragOver);
                elem.addEventListener("dragleave", dragLeave);
                elem.addEventListener("drop", drop);
            });

            // Menambahkan event listeners untuk drag start events ke semua elemen draggable
            draggableElements = document.querySelectorAll(".draggable");
            draggableElements.forEach(elem => {
                elem.addEventListener("dragstart", dragStart);
            });
        }

        // Drag and Drop Functions

        //Events fired on the drag target

        function dragStart(event) {
            event.dataTransfer.setData("text", event.target.id); // or "text/plain"
        }

        //Events fired on the drop target

        function dragEnter(event) {
            if (event.target.classList && event.target.classList.contains("droppable") && !event.target.classList.contains(
                    "dropped")) {
                event.target.classList.add("droppable-hover");
            }
        }

        function dragOver(event) {
            if (event.target.classList && event.target.classList.contains("droppable") && !event.target.classList.contains(
                    "dropped")) {
                event.preventDefault();
            }
        }

        function dragLeave(event) {
            if (event.target.classList && event.target.classList.contains("droppable") && !event.target.classList.contains(
                    "dropped")) {
                event.target.classList.remove("droppable-hover");
            }
        }

        let correctPairs = 0;

        function drop(event) {
            event.preventDefault();
            event.target.classList.remove("droppable-hover");
            const draggableElementBrand = event.dataTransfer.getData("text");
            const droppableElementBrand = event.target.getAttribute("data-brand");
            const isCorrectMatching = draggableElementBrand === droppableElementBrand;
            total++;
            if (isCorrectMatching) {
                const draggableElement = document.getElementById(draggableElementBrand);
                event.target.classList.add("dropped");
                draggableElement.classList.add("dragged");
                draggableElement.setAttribute("draggable", "false");
                event.target.innerHTML =
                    `<img class="matched-img" src="${draggableElement.src}" alt="${draggableElementBrand}">`;
                correct++;
                correctPairs++; // Increment correctPairs when a pair is matched correctly
                console.log("Correct Pairs:", correctPairs);

                const percentage = Math.round((correct / total) * 100);
                sessionStorage.setItem('completionPercentage', percentage);
                scoreSection.style.opacity = 0;
                setTimeout(() => {
                    correctSpan.textContent = correct;
                    totalSpan.textContent = total;
                    scoreSection.style.opacity = 1;
                }, 200);

                if (correctPairs === totalMatchingPairs) { // Check if correctPairs equals totalMatchingPairs
                    console.log("All pairs matched!");
                    const modal = document.getElementById("modal");
                    modal.classList.remove("hidden");
                    const finishBtn = document.getElementById("finish-btn");
                    finishBtn.addEventListener("click", finishGame);
                }
            }
        }

        // Function to handle finishing the game
        function finishGame() {
            // Simpan data permainan yang selesai
            const namaQuest = '{{ $quest->nama_quest }}'; // Dapatkan nama_quest dari blade template
            const completionPercentage = sessionStorage.getItem('completionPercentage');
            const userId = '{{ auth()->user()->id }}'; // Dapatkan user_id dari auth
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Ambil token CSRF

            // Buat formulir dengan JavaScript
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('questselesai.store') }}'; // Sesuaikan dengan rute yang tepat

            // Tambahkan input ke dalam formulir
            const userIdInput = document.createElement('input');
            userIdInput.type = 'hidden';
            userIdInput.name = 'user_id';
            userIdInput.value = userId;
            form.appendChild(userIdInput);

            const namaQuestInput = document.createElement('input');
            namaQuestInput.type = 'hidden';
            namaQuestInput.name = 'nama_quest';
            namaQuestInput.value = namaQuest;
            form.appendChild(namaQuestInput);

            const nilaiInput = document.createElement('input');
            nilaiInput.type = 'hidden';
            nilaiInput.name = 'nilai';
            nilaiInput.value = completionPercentage;
            form.appendChild(nilaiInput);

            const csrfTokenInput = document.createElement('input');
            csrfTokenInput.type = 'hidden';
            csrfTokenInput.name = '_token';
            csrfTokenInput.value = csrfToken;
            form.appendChild(csrfTokenInput);

            // Tambahkan formulir ke dalam dokumen dan submit
            document.body.appendChild(form);
            form.submit();
        }

        // Other Event Listeners
        playAgainBtn.addEventListener("click", playAgainBtnClick);

        function playAgainBtnClick() {
            playAgainBtn.classList.remove("play-again-btn-entrance");
            correct = 0;
            total = 0;
            correctPairs = 0; // Reset correctPairs
            percentage = 0;
            draggableItems.style.opacity = 0;
            matchingPairs.style.opacity = 0;
            setTimeout(() => {
                scoreSection.style.opacity = 0;
            }, 100);
            setTimeout(() => {
                while (draggableItems.firstChild) draggableItems.removeChild(draggableItems.firstChild);
                while (matchingPairs.firstChild) matchingPairs.removeChild(matchingPairs.firstChild);
                initiateGame();
                correctSpan.textContent = correct;
                totalSpan.textContent = total;
                draggableItems.style.opacity = 1;
                matchingPairs.style.opacity = 1;
                scoreSection.style.opacity = 1;
            }, 500);
        }

        // Auxiliary functions
        function generateRandomItemsArray(n, originalArray) {
            let res = [];
            let clonedArray = [...originalArray];
            if (n > clonedArray.length) n = clonedArray.length;
            for (let i = 1; i <= n; i++) {
                const randomIndex = Math.floor(Math.random() * clonedArray.length);
                res.push(clonedArray[randomIndex]);
                clonedArray.splice(randomIndex, 1);
            }
            return res;
        }
    </script>
@endsection
