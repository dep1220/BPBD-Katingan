<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@bpbd.com',
            'password' => bcrypt('password'),
            'role' => 'super_admin',
        ]);

        // Create Regular Admin
        User::create([
            'name' => 'Admin BPBD',
            'email' => 'admin@bpbd.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->call([
            PanduanBencanaSeeder::class,
            AgendaSeeder::class,
        ]);
    }
}
