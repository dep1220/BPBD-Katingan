<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VisiMisi;

class VisiMisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VisiMisi::create([
            'visi' => 'Terwujudnya Penyelenggaraan Penanggulangan Bencana yang Handal dan Profesional dalam Melindungi Masyarakat di Kabupaten Katingan.',
            'deskripsi_visi' => 'Landasan dan arah gerak Badan Penanggulangan Bencana Daerah Kabupaten Katingan dalam menjalankan tugas dan fungsinya.',
            'misi' => [
                'Membangun Sistem Penanggulangan Bencana yang Handal - Mengembangkan sistem informasi, komunikasi, dan peringatan dini yang terintegrasi untuk mendukung pengambilan keputusan yang cepat dan tepat.',
                'Meningkatkan Kapasitas Sumber Daya - Menyelenggarakan pelatihan dan pendidikan secara berkala bagi aparat dan relawan untuk meningkatkan kompetensi dalam setiap fase penanggulangan bencana.',
                'Meningkatkan Kesiapsiagaan Masyarakat - Melaksanakan program sosialisasi dan edukasi secara masif untuk membangun budaya sadar bencana di seluruh lapisan masyarakat.',
                'Mengoptimalkan Upaya Mitigasi Bencana - Bekerja sama dengan instansi terkait untuk melakukan kajian risiko dan mendorong implementasi kebijakan pengurangan risiko bencana dalam rencana pembangunan daerah.'
            ],
            'is_active' => true
        ]);
    }
}
