<?php

namespace App\Livewire;

use App\Models\Daerah;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class DaerahManagement extends Component
{
    use WithFileUploads;

    public $nama_daerah;
    public $status;
    public $pages = [];
    public $cover_image;

    public function mount()
    {
        $this->pages = [
            [
                'content_type' => 'text', // default ke text
                'page_front' => '',
                'content_type_back' => 'text', // default ke text
                'page_back' => '',
            ],
        ];
    }

    public function tambahKonten()
    {
        $this->pages[] = [
            'content_type' => 'text', // default ke text
            'page_front' => '',
            'content_type_back' => 'text', // default ke text
            'page_back' => '',
        ];
    }

    public function setContentType($index, $type, $part)
    {
        if ($part === 'front') {
            $this->pages[$index]['content_type'] = $type;
        } else {
            $this->pages[$index]['content_type_back'] = $type;
        }
    }

    public function tambahDaerah()
    {
        $konten = array_map(function ($page) {
            $frontContent = ($page['content_type'] === 'text') ?
                ['judul' => $page['page_front_judul'], 'konten' => $page['page_front']] :
                ['gambar' => $this->uploadPageFile($page['page_front'])];

            $backContent = ($page['content_type_back'] === 'text') ?
                ['judul' => $page['page_back_judul'], 'konten' => $page['page_back']] :
                ['gambar' => $this->uploadPageFile($page['page_back'])];

            return [
                'page_front' => $frontContent,
                'page_back' => $backContent,
            ];
        }, $this->pages);

        // dd([
        //     'nama_daerah' => $this->nama_daerah,
        //     'konten' => json_encode($konten),
        //     'status' => $this->status,
        //     'cover_image' => $this->cover_image ? $this->uploadCoverFile($this->cover_image) : null,
        // ]);
        Daerah::create([
            'nama_daerah' => $this->nama_daerah,
            'konten' => json_encode($konten),
            'status' => $this->status,
            'cover_image' => $this->cover_image ? $this->uploadCoverFile($this->cover_image) : null,
        ]);

        $this->resetInput();
    }

    public function uploadCoverFile($file)
    {
        return $file->store('cover_images', 'public');
    }

    public function uploadPageFile($file)
    {
        return $file->store('page_content', 'public');
    }

    private function resetInput()
    {
        $this->nama_daerah = '';
        $this->status = '';
        $this->pages = [
            [
                'content_type' => 'text', // default ke text
                'page_front' => '',
                'content_type_back' => 'text', // default ke text
                'page_back' => '',
            ],
        ];
    }

    public function statusChanged($status)
    {
        $this->status = $status;
    }

    public function render()
    {
        return view('livewire.daerah-management');
    }
}
