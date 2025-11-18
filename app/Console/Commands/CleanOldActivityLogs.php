<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ActivityLog;
use Carbon\Carbon;

class CleanOldActivityLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activitylog:clean {--days=30 : Number of days to keep}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete activity logs older than specified days (default: 30 days)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $date = Carbon::now()->subDays($days);

        $count = ActivityLog::where('created_at', '<', $date)->count();

        if ($count === 0) {
            $this->info('No old activity logs to delete.');
            return 0;
        }

        if ($this->confirm("Are you sure you want to delete {$count} activity logs older than {$days} days?", true)) {
            ActivityLog::where('created_at', '<', $date)->delete();
            $this->info("{$count} activity logs deleted successfully!");
        } else {
            $this->info('Operation cancelled.');
        }

        return 0;
    }
}
