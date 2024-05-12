<div class="overflow-y-auto">
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <form wire:submit.prevent="tambahQuest1" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="nama_quest" class="block text-gray-700 text-sm font-bold mb-2">Nama Quest:</label>
            <input type="text"
                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                wire:model.defer="nama_quest" id="nama_quest">
            @error('nama_quest')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        @foreach ($quests as $key => $quest)
            <div class="mb-4 p-4 border rounded shadow">
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                    <input type="text"
                        class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        wire:model.defer="quests.{{ $key }}.nama" id="nama">
                    @error("quests.{$key}.nama")
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="gambar" class="block text-gray-700 text-sm font-bold mb-2">Gambar:</label>
                    <input type="file"
                        class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        wire:model.defer="quests.{{ $key }}.gambar" id="gambar">
                    @error("quests.{$key}.gambar")
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="background" class="block text-gray-700 text-sm font-bold mb-2">Background:</label>
                    <input type="file"
                        class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        wire:model.defer="quests.{{ $key }}.background" id="background">
                    @error("quests.{$key}.background")
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="clue" class="block text-gray-700 text-sm font-bold mb-2">Clue:</label>
                    <textarea
                        class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        wire:model.defer="quests.{{ $key }}.clue" id="clue"></textarea>
                    @error("quests.{$key}.clue")
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                    wire:click="hapusQuest({{ $quest['id'] }})">Hapus</button>
            </div>
        @endforeach

        <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            wire:click="tambahQuest">Tambah Data</button>
        <button type="submit"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
    </form>
</div>
