<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Property extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'price',
        'bedrooms',
    ];

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
