<?php

namespace App\Livewire;

use App\Models\Quest1;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class AddQuest1 extends Component
{
    use WithFileUploads;

    public $quests = [];
    public $counter = 0;
    public $nama_quest;

    public function render()
    {
        return view('livewire.add-quest1');
    }

    public function tambahQuest()
    {
        $this->counter++;
        $this->quests[] = [
            'id' => $this->counter,
            'nama' => '',
            'gambar' => null,
            'background' => null,
            'clue' => '',
        ];
    }

    public function hapusQuest($id)
    {
        foreach ($this->quests as $key => $quest) {
            if ($quest['id'] == $id) {
                unset($this->quests[$key]);
            }
        }
    }

    public function tambahQuest1()
    {
        $validatedData = $this->validate([
            'nama_quest' => 'required|string',
            'quests.*.nama' => 'required|string',
            'quests.*.gambar' => 'nullable|image|max:1024',
            'quests.*.background' => 'nullable|image|max:1024',
            'quests.*.clue' => 'nullable|string',
        ]);

        // Array untuk menyimpan data JSON
        $jsonDataArray = [];

        foreach ($this->quests as $key => $quest) {
            $gambarPath = $quest['gambar'] ? $quest['gambar']->store('quest1', 'public') : null;
            $backgroundPath = $quest['background'] ? $quest['background']->store('quest1', 'public') : null;

            // Menambahkan data quest ke dalam array JSON
            $jsonDataArray[] = [
                'nama' => $quest['nama'],
                'gambar' => $gambarPath,
                'background' => $backgroundPath,
                'clue' => $quest['clue'],
            ];
        }

        // Menyimpan semua data quest dalam bentuk JSON array
        $jsonData = json_encode($jsonDataArray);

        // Simpan data JSON ke dalam database
        Quest1::create([
            'nama_quest' => $this->nama_quest,
            'data' => $jsonData,
        ]);

        session()->flash('message', 'Quest1 berhasil ditambahkan.');

        $this->reset();
    }
}
