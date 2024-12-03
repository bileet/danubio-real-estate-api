<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CoordinateCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (! is_string(value: $value)) {
            return [
                'latitude' => 0.0,
                'longitude' => 0.0,
            ];
        }

        // Unpack the coordinates as it's stored in the database as a binary string
        $coordinates = unpack(format: 'x4/corder/Ltype/dlng/dlat', string: $value);

        if ($coordinates === false) {
            return [
                'latitude' => 0.0,
                'longitude' => 0.0,
            ];
        }

        return [
            'latitude' => $coordinates['lat'],
            'longitude' => $coordinates['lng'],
        ];
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (! is_array(value: $value)) {
            $value = [
                'latitude' => 0.0,
                'longitude' => 0.0,
            ];
        }

        $latitude = $value['latitude'] ?? 0.0;
        $longitude = $value['longitude'] ?? 0.0;

        // Use raw SQL to create the coordinates
        return DB::raw("ST_SRID(Point({$latitude}, {$longitude}), 4326)");
    }
}
