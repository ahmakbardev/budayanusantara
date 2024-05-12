<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questselesai extends Model
{
    use HasFactory;

    protected $table = 'questselesais'; // Sesuaikan dengan nama tabel

    protected $fillable = [
        'user_id',
        'nama_quest',
        'nilai',
    ];

    // Definisikan relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
