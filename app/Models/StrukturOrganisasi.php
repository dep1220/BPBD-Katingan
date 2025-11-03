<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use App\Enums\TipeJabatan;

class StrukturOrganisasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'tipe_jabatan',
        'tipe_jabatan_custom',
        'foto',
        'sambutan_kepala',
        'sambutan_judul',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
        'tipe_jabatan' => TipeJabatan::class,
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeKepala($query)
    {
        return $query->where('tipe_jabatan', TipeJabatan::KEPALA);
    }

    public function scopeBawahan($query)
    {
        return $query->where('tipe_jabatan', '!=', TipeJabatan::KEPALA);
    }

    public function scopeOrdered($query)
    {
        return $query->orderByRaw("
            CASE tipe_jabatan
                WHEN 'kepala' THEN 1
                WHEN 'wakil_kepala' THEN 2
                WHEN 'sekretaris' THEN 3
                WHEN 'kepala_bidang' THEN 4
                WHEN 'kepala_seksi' THEN 5
                WHEN 'kasubag' THEN 6
                WHEN 'staff' THEN 7
                ELSE 999
            END
        ")->orderBy('urutan')->orderBy('created_at');
    }

    // Accessors
    public function getTipeJabatanLabelAttribute()
    {
        // Jika ada tipe jabatan custom, gunakan itu
        if (!empty($this->tipe_jabatan_custom)) {
            return $this->tipe_jabatan_custom;
        }
        
        return $this->tipe_jabatan?->label() ?? '-';
    }

    public function getTipeJabatanColorAttribute()
    {
        // Jika ada tipe jabatan custom, gunakan warna default
        if (!empty($this->tipe_jabatan_custom)) {
            return 'warning';
        }
        
        return $this->tipe_jabatan?->color() ?? 'secondary';
    }

    public function getTipeJabatanTailwindColorAttribute()
    {
        // Jika ada tipe jabatan custom, gunakan warna default
        if (!empty($this->tipe_jabatan_custom)) {
            return 'bg-yellow-100 text-yellow-800';
        }
        
        return $this->tipe_jabatan?->tailwindColor() ?? 'bg-gray-100 text-gray-800';
    }

    public function getTipeJabatanIconAttribute()
    {
        // Jika ada tipe jabatan custom, gunakan icon default
        if (!empty($this->tipe_jabatan_custom)) {
            return 'fas fa-user-tag';
        }
        
        return $this->tipe_jabatan?->icon() ?? 'fas fa-user';
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return asset('storage/' . $this->foto);
        }
        
        return null;
    }

    public function getIsKepalaAttribute()
    {
        return $this->tipe_jabatan === TipeJabatan::KEPALA;
    }

    public function getDefaultUrutanAttribute()
    {
        return $this->tipe_jabatan?->urutan() ?? 999;
    }
}
