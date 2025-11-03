<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PanduanBencana extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'items',
        'sequence',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'items' => 'array', // Otomatis mengubah JSON -> array dan sebaliknya
    ];
}
