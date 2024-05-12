<div class="mt-8 px-6 h-fit overflow-y-auto text-white">
    <h1 class="text-2xl font-bold mb-4">Tambah Daerah Baru</h1>
    <form wire:submit.prevent="tambahDaerah" method="POST">
        @csrf
        <div class="mb-4">
            <label for="nama_daerah" class="block text-sm font-medium text-gray-700">Nama Daerah</label>
            <input wire:model="nama_daerah" type="text" id="nama_daerah" name="nama_daerah"
                class="block w-full mt-1 py-3 px-2 rounded-md text-sm border-gray-600 bg-gray-700 focus:border focus:border-purple-400 focus:outline-none focus:shadow-outline-purple text-gray-300"
                required>
        </div>
        <div class="mb-4">
            <label for="cover_image" class="block text-sm font-medium text-gray-700">Cover Image</label>
            <input type="file" wire:model="cover_image" accept="image/*"> <!-- Tambahkan input untuk cover image -->
        </div>

        <!-- Dropdown dengan Alpine.js -->
        <div x-data="selectmenu({ 'draft': 'Draft', 'publish': 'Published' })" class="relative" @click.away="close()">
            <label for="" class="block text-sm font-medium text-gray-700">Status</label>
            <!-- Input tersembunyi untuk menangkap perubahan status -->
            <input type="hidden" name="status" wire:change="statusChanged($event.target.value)" x-model="selectedkey">

            <!-- Button untuk membuka dropdown -->
            <span class="inline-block text-black w-full rounded-md shadow-sm"
                @click="toggle(); $nextTick(() => $refs.filterinput.focus());">
                <button type="button"
                    class="relative z-0 w-full py-2 pl-3 pr-10 text-left transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                    <span class="block truncate" x-text="selectedlabel ?? 'Please Select'"></span>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                            <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </span>
                </button>
            </span>

            <!-- Dropdown dan pencarian -->
            <div x-show="state" class="absolute z-10 mt-1 bg-white rounded-md shadow-lg p-2">
                <input type="text" class="w-full rounded-md py-1 px-2 mb-1 border border-gray-400" x-model="filter"
                    x-ref="filterinput">
                <ul
                    class="py-1 overflow-auto text-base leading-6 rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                    <template x-for="(value, key) in getlist()" :key="key">
                        <li @click="select(value, key)" :class="{ 'bg-gray-100': isselected(key) }"
                            class="relative py-1 pl-3 mb-1 text-gray-900 select-none pr-9 hover:bg-gray-100 cursor-pointer rounded-md">
                            <span x-text="value" class="block font-normal truncate"></span>
                            <span x-show="isselected(key)"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-700">
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </li>
                    </template>
                </ul>
            </div>
        </div>


        <!-- Loop melalui array pages untuk membuat input dinamis -->
        <!-- Loop untuk pages -->
        <div wire:ignore.self>
            @foreach ($pages as $index => $page)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Page Front</label>
                    <div class="flex gap-5 mb-2">
                        <label>
                            <input type="radio" class="peer hidden" name="content_type_front_{{ $index }}"
                                value="text" wire:click="setContentType({{ $index }}, 'text', 'front')"
                                {{ $page['content_type'] === 'text' ? 'checked' : '' }}>

                            <div
                                class="hover:bg-blue-500/40 text-white flex items-center justify-between gap-5 px-2 py-2 border-2 rounded-lg cursor-pointer text-sm border-gray-200 group peer-checked:border-blue-500">
                                <h2 class="font-medium">Text</h2>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-5 h-5 text-blue-600 invisible group-[.peer:checked+&]:visible">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </label>
                        <label>
                            <input type="radio" class="peer hidden" name="content_type_front_{{ $index }}"
                                value="image" wire:click="setContentType({{ $index }}, 'image', 'front')"
                                {{ $page['content_type'] === 'image' ? 'checked' : '' }}>

                            <div
                                class="hover:bg-blue-500/40 text-white flex items-center justify-between gap-5 px-2 py-2 border-2 rounded-lg cursor-pointer text-sm border-gray-200 group peer-checked:border-blue-500">
                                <h2 class="font-medium">Image</h2>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-5 h-5 text-blue-600 invisible group-[.peer:checked+&]:visible">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </label>
                    </div>

                    <!-- Input untuk Teks -->
                    @if ($page['content_type'] === 'text')
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label>Judul:</label>
                                <input type="text" wire:model="pages.{{ $index }}.page_front_judul"
                                    class="block w-full mt-1 py-3 px-2 rounded-md text-sm border-gray-600 bg-gray-700 focus:border focus:border-purple-400 focus:outline-none focus:shadow-outline-purple text-gray-300">
                            </div>
                            <div>
                                <label>Konten:</label>
                                <textarea wire:model="pages.{{ $index }}.page_front" rows="2"
                                    class="block w-full mt-1 py-3 px-2 rounded-md text-sm border-gray-600 bg-gray-700 focus:border focus:border-purple-400 focus:outline-none focus:shadow-outline-purple text-gray-300"></textarea>
                            </div>
                        </div>
                    @else
                        <!-- Input untuk Gambar -->
                        <input type="file"
                            class="file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100"
                            wire:model="pages.{{ $index }}.page_front" accept="image/*">
                    @endif
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Page Back</label>
                    <div class="flex gap-5 mb-2">
                        <label>
                            <input type="radio" class="peer hidden" name="content_type_back_{{ $index }}"
                                value="text" wire:click="setContentType({{ $index }}, 'text', 'back')"
                                {{ $page['content_type_back'] === 'text' ? 'checked' : '' }}>

                            <div
                                class="hover:bg-blue-500/40 text-white flex items-center justify-between gap-5 px-2 py-2 border-2 rounded-lg cursor-pointer text-sm border-gray-200 group peer-checked:border-blue-500">
                                <h2 class="font-medium">Text</h2>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-5 h-5 text-blue-600 invisible group-[.peer:checked+&]:visible">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </label>
                        <label>
                            <input type="radio" class="peer hidden" name="content_type_back_{{ $index }}"
                                value="image" wire:click="setContentType({{ $index }}, 'image', 'back')"
                                {{ $page['content_type_back'] === 'image' ? 'checked' : '' }}>

                            <div
                                class="hover:bg-blue-500/40 text-white flex items-center justify-between gap-5 px-2 py-2 border-2 rounded-lg cursor-pointer text-sm border-gray-200 group peer-checked:border-blue-500">
                                <h2 class="font-medium">Image</h2>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-5 h-5 text-blue-600 invisible group-[.peer:checked+&]:visible">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </label>
                    </div>

                    <!-- Input untuk Teks -->
                    @if ($page['content_type_back'] === 'text')
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label>Judul:</label>
                                <input type="text" wire:model="pages.{{ $index }}.page_back_judul"
                                    class="block w-full mt-1 py-3 px-2 rounded-md text-sm border-gray-600 bg-gray-700 focus:border focus:border-purple-400 focus:outline-none focus:shadow-outline-purple text-gray-300">
                            </div>
                            <div>
                                <label>Konten:</label>
                                <textarea wire:model="pages.{{ $index }}.page_back" rows="2"
                                    class="block w-full mt-1 py-3 px-2 rounded-md text-sm border-gray-600 bg-gray-700 focus:border focus:border-purple-400 focus:outline-none focus:shadow-outline-purple text-gray-300"></textarea>
                            </div>
                        </div>
                    @else
                        <!-- Input untuk Gambar -->
                        <input type="file"
                            class="file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100"
                            wire:model="pages.{{ $index }}.page_back" accept="image/*">
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mb-4">
            <button type="button" wire:click="tambahKonten"
                class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">Tambah Konten</button>
        </div>


        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Simpan</button>
        </div>
    </form>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        function selectmenu(datalist) {
            if (typeof datalist !== 'object') {
                throw new Error('Data list must be an object or array');
            }

            return {
                state: false,
                filter: '',
                list: datalist,
                selectedkey: null,
                selectedlabel: null,

                toggle() {
                    this.state = !this.state;
                },

                close() {
                    this.state = false;
                },

                select(value, key) {
                    this.selectedlabel = value;
                    this.selectedkey = key;

                    // Mengirim perubahan ke Livewire menggunakan wire:change
                    const input = document.querySelector('input[name="status"]');
                    input.value = key; // Mengatur nilai input tersembunyi
                    input.dispatchEvent(new Event('change', {
                        bubbles: true
                    })); // Mengirim event 'change'

                    this.state = false;
                },

                isselected(key) {
                    return this.selectedkey === key;
                },

                getlist() {
                    if (this.filter === '') {
                        return this.list;
                    }

                    const filtered = Object.entries(this.list).filter(([k, v]) =>
                        v.toLowerCase().includes(this.filter.toLowerCase())
                    );

                    return Object.fromEntries(filtered);
                },
            };
        }
    </script>



</div>
