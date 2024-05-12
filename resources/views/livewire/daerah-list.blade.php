<div class="grid grid-cols-4 gap-5">
    @foreach ($daerahs as $daerah)
        <a href="{{ route('flipbook', ['id' => $daerah->id]) }}" wire:key="{{ $daerah->id }}"
            class="p-3 rounded-md hover:scale-95 relative transition-all ease-in-out bg-gray-800 text-white"
            target="_blank">

            <!-- Gambar daerah -->
            <img class="max-h-48 min-h-48 object-contain mx-auto" src="{{ asset('storage/' . $daerah->cover_image) }}"
                alt="">

            <!-- Nama daerah -->
            <h1 class="text-2xl">{{ $daerah->nama_daerah }}</h1>
            <span
                class="text-xs absolute top-3 right-3 py-0.5 px-2 rounded-full
            @if ($daerah->status == 'draft') bg-red-500
            @else bg-green-700 @endif
            ">
                {{ $daerah->status }}
            </span>
        </a>
    @endforeach
</div>
