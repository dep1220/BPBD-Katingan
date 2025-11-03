<?php

namespace App\Enums;

enum TipeJabatan: string
{
    case KEPALA = 'kepala';
    case SEKRETARIS = 'sekretaris';
    case KEPALA_BIDANG = 'kepala_bidang';
    case KEPALA_SEKSI = 'kepala_seksi';
    case KASUBAG = 'kasubag';

    public function label(): string
    {
        return match($this) {
            self::KEPALA => 'Kepala',
            self::SEKRETARIS => 'Sekretaris',
            self::KEPALA_BIDANG => 'Kepala Bidang',
            self::KEPALA_SEKSI => 'Kepala Seksi',
            self::KASUBAG => 'Kepala Sub Bagian',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::KEPALA => 'danger',
            self::SEKRETARIS => 'info',
            self::KEPALA_BIDANG => 'primary',
            self::KEPALA_SEKSI => 'success',
            self::KASUBAG => 'secondary',
        };
    }

    public function tailwindColor(): string
    {
        return match($this) {
            self::KEPALA => 'bg-red-100 text-red-800',
            self::SEKRETARIS => 'bg-blue-100 text-blue-800',
            self::KEPALA_BIDANG => 'bg-indigo-100 text-indigo-800',
            self::KEPALA_SEKSI => 'bg-green-100 text-green-800',
            self::KASUBAG => 'bg-gray-100 text-gray-800',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::KEPALA => 'fas fa-crown',

            self::SEKRETARIS => 'fas fa-clipboard-user',
            self::KEPALA_BIDANG => 'fas fa-users-gear',
            self::KEPALA_SEKSI => 'fas fa-user-cog',
            self::KASUBAG => 'fas fa-user-check',
        };
    }

    public function urutan(): int
    {
        return match($this) {
            self::KEPALA => 1,
            self::SEKRETARIS => 2,
            self::KEPALA_BIDANG => 3,
            self::KEPALA_SEKSI => 4,
            self::KASUBAG => 5,
        };
    }

    public function isKepala(): bool
    {
        return $this === self::KEPALA;
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }

    public static function optionsWithIcons(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [
                $case->value => [
                    'label' => $case->label(),
                    'icon' => $case->icon(),
                    'color' => $case->color(),
                    'urutan' => $case->urutan()
                ]
            ])
            ->toArray();
    }
}
