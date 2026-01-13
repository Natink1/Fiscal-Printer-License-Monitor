<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Device extends Model
{
    use HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
        'licence_end' => 'date',
    ];

    protected $appends = ['remaining_days'];

    public function category()
    {
        return $this->belongsTo(DeviceCategory::class, 'device_category_id');
    }

    public function getRemainingDaysAttribute(): ?int
    {
        if (!$this->licence_end) return null;

        // Positive = days left, Negative = expired days ago, 0 = expires today
        return Carbon::today()->diffInDays($this->licence_end, false);
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->licence_end ? $this->remaining_days < 0 : false;
    }
    protected static function booted()
    {
        static::updating(function ($device) {
            if ($device->isDirty('licence_end')) {
                // license date changed (renewed) -> allow new notifications
                $device->notified_7_at = null;
            }
        });
    }
}
