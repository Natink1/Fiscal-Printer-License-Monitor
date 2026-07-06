<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Company extends Model 
{
    use HasUuids;

    protected $keyType = 'string';

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

}
