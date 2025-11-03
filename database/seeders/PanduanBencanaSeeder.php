<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PanduanBencana;

class PanduanBencanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PanduanBencana::create([
            'title' => 'Sebelum Bencana',
            'description' => 'Persiapan adalah kunci keselamatan. Pastikan Anda memiliki:',
            'items' => [
                'Tas Siaga Bencana (TSB).',
                'Rencana evakuasi keluarga.',
                'Dokumen penting di tempat aman.',
                'Kenali jalur evakuasi & shelter.'
            ],
            'sequence' => 1
        ]);

        PanduanBencana::create([
            'title' => 'Saat Bencana',
            'description' => 'Tetap tenang dan lakukan langkah berikut:',
            'items' => [
                'Berlindung di tempat yang aman.',
                'Ikuti arahan petugas di lapangan.',
                'Pantau informasi dari sumber resmi.',
                'Jauhi area berbahaya (sungai, lereng).'
            ],
            'sequence' => 2
        ]);

        PanduanBencana::create([
            'title' => 'Setelah Bencana',
            'description' => 'Langkah pemulihan yang perlu diperhatikan:',
            'items' => [
                'Pastikan keamanan lingkungan sekitar.',
                'Laporkan kerusakan & cari informasi.',
                'Ikut serta dalam program pemulihan.',
                'Jaga kesehatan & kebersihan lingkungan.'
            ],
            'sequence' => 3
        ]);
    }
}