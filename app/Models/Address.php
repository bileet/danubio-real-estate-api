<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
    protected $fillable = [
        'addressable_type',
        'addressable_id',
        'street',
    ];

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
