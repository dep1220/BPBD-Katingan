<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiKontak extends Model
{
    use HasFactory;

    protected $fillable = [
        'alamat',
        'telepon',
        'email',
        'jam_operasional',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'whatsapp',
    ];
}

