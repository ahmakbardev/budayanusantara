<?php

namespace App\Livewire;

use App\Models\Daerah;
use Livewire\Component;

class DaerahList extends Component
{
    protected $listeners = ['statusUpdated' => 'refreshDaerahs'];
    public $daerahs;

    public function refreshDaerahs()
    {
        // Memuat ulang data daerahs setelah status diperbarui
        $this->daerahs = Daerah::all();
    }

    public function mount()
    {
        $this->daerahs = Daerah::all();
    }

    public function render()
    {
        return view('livewire.daerah-list');
    }
}
