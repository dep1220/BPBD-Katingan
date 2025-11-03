<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisiMisi extends Model
{
    protected $table = 'visi_misi';

    protected $fillable = [
        'visi',
        'misi',
        'deskripsi_visi',
        'is_active'
    ];

    protected $casts = [
        'misi' => 'array',
        'is_active' => 'boolean'
    ];

    // Scope untuk data aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Method untuk mendapatkan visi misi aktif
    public static function getActive()
    {
        return self::active()->first();
    }

    // Route key name untuk binding
    public function getRouteKeyName()
    {
        return 'id';
    }
}
