<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agenda;
use Carbon\Carbon;

class AgendaSeeder extends Seeder
{
    public function run()
    {
        // Agenda yang sudah selesai
        Agenda::create([
            'title' => 'Workshop Kesiapsiagaan Bencana',
            'description' => 'Workshop peningkatan kapasitas masyarakat dalam menghadapi bencana alam.',
            'location' => 'Aula Kantor BPBD Katingan',
            'start_date' => Carbon::now()->subDays(3),
            'start_time' => '08:00:00',
            'end_time' => '16:00:00',
            'is_active' => true,
            'sequence' => 4,
        ]);

        // Agenda yang sedang berlangsung (hari ini)
        Agenda::create([
            'title' => 'Simulasi Bencana Tingkat Kabupaten',
            'description' => 'Kegiatan simulasi gabungan untuk meningkatkan kesiapan seluruh elemen masyarakat dan instansi terkait.',
            'location' => 'Lapangan Sport Center, Kasongan',
            'start_date' => Carbon::today(),
            'start_time' => '08:00:00',
            'end_time' => '17:00:00',
            'is_active' => true,
            'sequence' => 1,
        ]);

        // Agenda yang akan datang
        Agenda::create([
            'title' => 'Pelatihan Relawan Tanggap Bencana',
            'description' => 'Perekrutan dan pelatihan bagi masyarakat yang ingin bergabung menjadi relawan BPBD Katingan.',
            'location' => 'Aula Kantor BPBD Katingan',
            'start_date' => Carbon::now()->addDays(15),
            'start_time' => '09:00:00',
            'end_time' => '15:00:00',
            'is_active' => true,
            'sequence' => 2,
        ]);

        Agenda::create([
            'title' => 'Sosialisasi Mitigasi Bencana di Sekolah',
            'description' => 'Program edukasi ke sekolah-sekolah di wilayah rawan bencana untuk meningkatkan pemahaman siswa.',
            'location' => 'SMAN 1 Katingan Hilir',
            'start_date' => Carbon::now()->addDays(35),
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
            'is_active' => true,
            'sequence' => 3,
        ]);

        // Agenda multi-hari
        Agenda::create([
            'title' => 'Pelatihan Tim SAR Tingkat Provinsi',
            'description' => 'Pelatihan intensif untuk tim Search and Rescue selama 3 hari dengan instruktur berpengalaman.',
            'location' => 'Base Camp SAR Katingan',
            'start_date' => Carbon::now()->addDays(50),
            'end_date' => Carbon::now()->addDays(52),
            'start_time' => '07:00:00',
            'end_time' => '18:00:00',
            'is_active' => true,
            'sequence' => 5,
        ]);
    }
}
