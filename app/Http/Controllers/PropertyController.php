<?php

namespace App\Http\Controllers;

use App\Enums\PropertyType;
use App\Models\Property;
use App\Models\Address;
use App\Http\Requests\ListPropertyWithFilterRequest;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Http\Resources\PropertyCollection;
use App\Http\Resources\PropertyResource;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ListPropertyWithFilterRequest $request)
    {
        $filters = collect($request->validated());

        // Apply the filters if any
        $properties = Property::query()
            // Filter by type when available
            ->when($filters->has('type'), function ($query) use ($filters) {
                return $query->where('type', PropertyType::from($filters->get('type')));
            })
            // Filter by street when available
            ->when($filters->has('street'), function ($query) use ($filters) {
                return $query->whereHas('address', function ($query) use ($filters) {
                    $query->where('street', 'LIKE', '%' . $filters->get('street') . '%');
                });
            })
            // Filter by size when available
            ->when($filters->has('size'), function ($query) use ($filters) {
                $sizeWithCondition = explode(':', $filters->get('size'));
                return $query->where('size', $sizeWithCondition[0], $sizeWithCondition[1]);
            })
            // Filter by size unit when available
            ->when($filters->has('size_unit'), function ($query) use ($filters) {
                return $query->where('size_unit', $filters->get('size_unit'));
            })
            // Filter by bedrooms when available
            ->when($filters->has('bedrooms'), function ($query) use ($filters) {
                $bedroomsWithCondition = explode(':', $filters->get('bedrooms'));
                return $query->where('bedrooms', $bedroomsWithCondition[0], $bedroomsWithCondition[1]);
            })
            // Filter by price when available
            ->when($filters->has('price'), function ($query) use ($filters) {
                $priceWithCondition = explode(':', $filters->get('price'));
                return $query->where('price', $priceWithCondition[0], $priceWithCondition[1]);
            });

        $paginated = $properties->simplePaginate($filters->get('per_page', 15));

        return new PropertyCollection($paginated);
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

        $address = $data['address'];

        // Prepare the coordinates for the address
        $address['coordinates'] = [
            'latitude' => $address['latitude'],
            'longitude' => $address['longitude'],
        ];

        // Create & assign the address to the property
        $property->address()->create($address);

        return new PropertyResource($property);
    }
}
