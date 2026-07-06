<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    public $guarded = [];

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

}
