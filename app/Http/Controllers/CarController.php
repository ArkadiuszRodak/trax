<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Http\Resources\CarResource;
use App\Car;

class CarController extends Controller
{
    public function index()
    {
        return CarResource::collection(Car::all());
    }

    public function store(StoreCarRequest $request)
    {
        Car::create($request->validated());
    }

    public function show(Car $car)
    {
        $car->loadCount('trips as trip_count')->loadSum('trips as trip_miles', 'miles');

        return new CarResource($car);
    }

    public function destroy(Car $car)
    {
        $car->delete();
    }
}
