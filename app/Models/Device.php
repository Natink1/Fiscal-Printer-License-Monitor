<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

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

    public function getRemainingDaysAttribute(): ?int
    {
        if ($this->licence_end) {
            $today = now()->startOfDay();
            $endDate = $this->licence_end->startOfDay();

            return $today->diffInDays($endDate, false);
        }

        return null;
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->licence_end ? $this->remaining_days < 0 : false;
    }
}
