<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ActivityLog;
use App\Models\User;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        
        if (!$user) {
            $this->command->warn('No user found. Please create a user first.');
            return;
        }

        $activities = [
            ['action' => 'login', 'description' => 'Login ke sistem', 'model' => null],
            ['action' => 'create', 'description' => 'Menambahkan Berita: Pelatihan Kesiapsiagaan Bencana', 'model' => 'Berita'],
            ['action' => 'create', 'description' => 'Menambahkan Slider: Slide Informasi Banjir', 'model' => 'Slider'],
            ['action' => 'update', 'description' => 'Mengubah Galeri: Dokumentasi Evakuasi', 'model' => 'Galeri'],
            ['action' => 'create', 'description' => 'Menambahkan Unduhan: SOP Penanganan Kebakaran', 'model' => 'Unduhan'],
            ['action' => 'update', 'description' => 'Mengubah Agenda: Rapat Koordinasi BPBD', 'model' => 'Agenda'],
            ['action' => 'delete', 'description' => 'Menghapus Berita: Berita Kadaluarsa', 'model' => 'Berita'],
            ['action' => 'create', 'description' => 'Menambahkan Berita: Sosialisasi Mitigasi Bencana', 'model' => 'Berita'],
            ['action' => 'update', 'description' => 'Mengubah Slider: Update Banner Utama', 'model' => 'Slider'],
            ['action' => 'logout', 'description' => 'Logout dari sistem', 'model' => null],
        ];

        foreach ($activities as $activity) {
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => $activity['action'],
                'model' => $activity['model'],
                'description' => $activity['description'],
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'created_at' => now()->subMinutes(rand(5, 60)),
            ]);
        }

        $this->command->info('Activity logs seeded successfully!');
    }
}
