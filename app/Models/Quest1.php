<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quest1 extends Model
{
    use HasFactory;

    protected $fillable = ['nama_quest', 'data']; // Tambahkan kolom 'nama_quest' ke dalam $fillable

    protected $casts = [
        'data' => 'array',
    ];
}
