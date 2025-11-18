<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetAutoIncrement extends Command
{
    protected $signature = 'db:reset-auto-increment {--except=}';
    protected $description = 'Reset auto increment untuk semua tabel kecuali yang dikecualikan';

    public function handle()
    {
        $except = $this->option('except') 
            ? explode(',', $this->option('except')) 
            : ['informasi_kontaks', 'galeris'];

        $tables = DB::select('SHOW TABLES');
        $dbName = config('database.connections.mysql.database');
        
        $this->info('Mereset auto increment untuk tabel-tabel...');
        $this->newLine();

        foreach ($tables as $table) {
            $tableKey = "Tables_in_{$dbName}";
            $tableName = $table->{$tableKey};
            
            // Skip tabel yang dikecualikan
            if (in_array($tableName, $except)) {
                $this->warn("⏭️  Melewati tabel: {$tableName}");
                continue;
            }

            // Skip tabel sistem
            if (in_array($tableName, ['migrations', 'cache', 'cache_locks', 'jobs', 'job_batches', 'failed_jobs', 'password_reset_tokens', 'sessions'])) {
                continue;
            }

            try {
                // Ambil ID tertinggi
                $maxId = DB::table($tableName)->max('id');
                $nextId = $maxId ? $maxId + 1 : 1;
                
                // Reset auto increment
                DB::statement("ALTER TABLE `{$tableName}` AUTO_INCREMENT = {$nextId}");
                
                $this->info("✅ {$tableName}: AUTO_INCREMENT direset ke {$nextId}");
            } catch (\Exception $e) {
                $this->error("❌ Error pada {$tableName}: " . $e->getMessage());
            }
        }

        $this->newLine();
        $this->info('🎉 Selesai!');
        
        return Command::SUCCESS;
    }
}
