<?php

namespace App\Models;

use App\Enums\PropertyType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Property extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'size',
        'size_unit',
        'price',
        'bedrooms',
    ];

    protected $casts = [
        'type' => PropertyType::class,
    ];

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
