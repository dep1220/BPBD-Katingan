<?php

namespace App\Enums;

enum KategoriBerita: string
{
    case PERINGATAN_DINI = 'peringatan_dini';
    case KEGIATAN = 'kegiatan';
    case PENGUMUMAN = 'pengumuman';
    case BERITA_UMUM = 'berita_umum';
    case LAPORAN = 'laporan';
    case EDUKASI = 'edukasi';

    public function label(): string
    {
        return match($this) {
            self::PERINGATAN_DINI => 'Peringatan Dini',
            self::KEGIATAN => 'Kegiatan',
            self::PENGUMUMAN => 'Pengumuman',
            self::BERITA_UMUM => 'Berita Umum',
            self::LAPORAN => 'Laporan',
            self::EDUKASI => 'Edukasi',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PERINGATAN_DINI => 'bg-red-100 text-red-800',
            self::KEGIATAN => 'bg-blue-100 text-blue-800',
            self::PENGUMUMAN => 'bg-yellow-100 text-yellow-800',
            self::BERITA_UMUM => 'bg-gray-100 text-gray-800',
            self::LAPORAN => 'bg-green-100 text-green-800',
            self::EDUKASI => 'bg-purple-100 text-purple-800',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::PERINGATAN_DINI => '⚠️',
            self::KEGIATAN => '📅',
            self::PENGUMUMAN => '📢',
            self::BERITA_UMUM => '📰',
            self::LAPORAN => '📊',
            self::EDUKASI => '📚',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn($case) => [
                'value' => $case->value,
                'label' => $case->label(),
                'color' => $case->color(),
                'icon' => $case->icon(),
            ],
            self::cases()
        );
    }

    public static function getLabels(): array
    {
        $labels = [];
        foreach (self::cases() as $case) {
            $labels[$case->value] = $case->label();
        }
        return $labels;
    }
}
