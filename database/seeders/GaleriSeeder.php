<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Galeri;

class GaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galeris = [
            [
                'judul' => 'Simulasi Bencana Gempa Bumi',
                'deskripsi' => 'Kegiatan simulasi bencana gempa bumi yang melibatkan masyarakat dan petugas BPBD untuk meningkatkan kesiapsiagaan dalam menghadapi bencana.',
                'gambar' => 'galeri/simulasi-gempa.jpg',
                'is_active' => true
            ],
            [
                'judul' => 'Penyerahan Bantuan Korban Banjir',
                'deskripsi' => 'Kegiatan penyerahan bantuan logistik kepada korban bencana banjir di wilayah Katingan.',
                'gambar' => 'galeri/bantuan-banjir.jpg',
                'is_active' => true
            ],
            [
                'judul' => 'Sosialisasi Mitigasi Bencana di Sekolah',
                'deskripsi' => 'Program edukasi dan sosialisasi mitigasi bencana kepada siswa-siswi sekolah dasar untuk meningkatkan kesadaran akan pentingnya kesiapsiagaan bencana.',
                'gambar' => 'galeri/sosialisasi-sekolah.jpg',
                'is_active' => true
            ],
            [
                'judul' => 'Pelatihan Relawan Tanggap Bencana',
                'deskripsi' => 'Kegiatan pelatihan dan pembekalan untuk relawan tanggap bencana guna meningkatkan kapasitas dalam penanganan darurat.',
                'gambar' => 'galeri/pelatihan-relawan.jpg',
                'is_active' => true
            ],
            [
                'judul' => 'Distribusi Air Bersih',
                'deskripsi' => 'Kegiatan distribusi air bersih kepada masyarakat yang terdampak kekeringan di wilayah Katingan.',
                'gambar' => 'galeri/distribusi-air.jpg',
                'is_active' => true
            ],
            [
                'judul' => 'Apel Kesiapsiagaan Karhutla',
                'deskripsi' => 'Apel kesiapsiagaan menghadapi kebakaran hutan dan lahan yang melibatkan seluruh personel BPBD dan instansi terkait.',
                'gambar' => 'galeri/apel-karhutla.jpg',
                'is_active' => true
            ]
        ];

        foreach ($galeris as $galeri) {
            Galeri::create($galeri);
        }
    }
}
