<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unduhan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang dihubungkan dengan model ini.
     *
     * @var string
     */
    protected $table = 'unduhan';

    protected $fillable = [
        'title',
        'kategori',
        'file_path',
        'file_size',
        'is_active',
    ];
}
