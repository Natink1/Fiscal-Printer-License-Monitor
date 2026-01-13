<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class DeviceCategory extends Model
{
    use HasUuids;

    protected $fillable = ['name'];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];


    public function devices()
    {
        return $this->hasMany(Device::class, 'device_category_id');
    }
}
