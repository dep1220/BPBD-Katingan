<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    /**
     * Log aktivitas user
     */
    protected function logActivity(string $action, string $description, ?string $model = null): void
    {
        ActivityLog::log($action, $description, $model);
    }

    /**
     * Log aktivitas create
     */
    protected function logCreate(string $modelName, string $itemName): void
    {
        $this->logActivity('create', "Menambahkan {$modelName}: {$itemName}", $modelName);
    }

    /**
     * Log aktivitas update
     */
    protected function logUpdate(string $modelName, string $itemName): void
    {
        $this->logActivity('update', "Mengubah {$modelName}: {$itemName}", $modelName);
    }

    /**
     * Log aktivitas delete
     */
    protected function logDelete(string $modelName, string $itemName): void
    {
        $this->logActivity('delete', "Menghapus {$modelName}: {$itemName}", $modelName);
    }
}
