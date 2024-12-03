<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Casts\CoordinateCast;

class Address extends Model
{
    protected $fillable = [
        'addressable_type',
        'addressable_id',
        'street',
        'coordinates',
    ];

    protected $casts = [
        'coordinates' => CoordinateCast::class,
    ];

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
