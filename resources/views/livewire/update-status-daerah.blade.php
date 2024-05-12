<div>
    <div class="fixed flex flex-col top-20 right-8 gap-3">
        @if (count($messages) > 0)
            @foreach ($messages as $index => $message)
                <div x-data="{ open: true }" x-show="open" x-transition.duration.500ms.opacity>
                    <div @click="open = false"
                        class="relative p-3 hover:bg-green-700/95 transition-all ease-in-out rounded-md flex flex-col bg-green-700/75 custom-animation text-white cursor-pointer">
                        <strong class="mr-auto">Notification</strong>
                        {{ $message }}
                    </div>
                </div>
            @endforeach
        @endif
    </div>



    <table class="w-full whitespace-no-wrap">
        <thead>
            <tr
                class="text-xs font-semibold tracking-wide text-left uppercase border-b border-gray-700 text-gray-400 bg-gray-800">
                <th class="px-4 py-3">Nama Daerah</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Waktu Update</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-700 bg-gray-800">
            @foreach ($areas as $area)
                <tr class="text-gray-400">
                    <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                            <p class="font-semibold">{{ $area->nama_daerah }}</p>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-xs">
                        <select wire:change="updateStatus('{{ $area->id }}', $event.target.value)"
                            class="text-xs font-semibold leading-tight rounded-full w-fit px-2 py-0.5
                        @if ($area->status == 'draft') bg-red-700 text-red-100
                        @else bg-green-700 text-green-100 @endif
                        ">
                            <option value="draft" @if ($area->status == 'draft') selected @endif>Draft</option>
                            <option value="publish" @if ($area->status == 'publish') selected @endif>Publish</option>
                        </select>
                    </td>
                    <td class="px-4 py-3 text-sm">
                        {{ $area->updated_at->format('d/m/Y H:i:s') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
