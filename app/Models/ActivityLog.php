<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model',
        'description',
        'ip_address',
        'user_agent',
    ];

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper method untuk log activity
     */
    public static function log(string $action, string $description, ?string $model = null): void
    {
        if (auth()->check()) {
            self::create([
                'user_id' => auth()->id(),
                'action' => $action,
                'model' => $model,
                'description' => $description,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }
}
