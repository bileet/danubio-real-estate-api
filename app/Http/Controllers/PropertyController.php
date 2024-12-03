<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Address;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Http\Resources\PropertyCollection;
use App\Http\Resources\PropertyResource;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::all();
        return new PropertyCollection($properties);
    }

    /**
     * Store a newly created resource in the database.
     */
    public function store(StorePropertyRequest $request)
    {
        // Get the validated data from the request
        $data = $request->validated();

        // Create the property
        $property = Property::create($data);

        // Create & assign the address to the property
        $property->address()->create($data['address']);

        return new PropertyResource($property);
    }
}
