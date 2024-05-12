<?php

namespace App\Livewire;

use App\Models\Daerah;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class UpdateStatusDaerah extends Component
{
    public $areas;
    public $messages = [];

    public function mount()
    {
        // Mengambil semua data Daerah
        $this->areas = Daerah::all();
    }

    public function updateStatus($areaId, $status)
    {
        $area = Daerah::find($areaId);
        if ($area) {
            $area->status = $status;
            $area->save();
            // Memperbarui $areas setelah perubahan status
            $this->areas = Daerah::all();
            $this->dispatch('statusUpdated');

            // Menyimpan pesan di session
            $this->messages[] = 'Status berhasil diperbarui';
        }
    }

    public function render()
    {
        return view('livewire.update-status-daerah');
    }
}
