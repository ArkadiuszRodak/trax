<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Http\Resources\CarCollection;
use App\Http\Resources\CarResource;
use App\Car;

class CarController extends Controller
{
    public function index(): CarCollection
    {
        $this->authorize('viewAny', Car::class);

        return new CarCollection(Car::all());
    }

    public function store(StoreCarRequest $request): void
    {
        $this->authorize('create', Car::class);

        Car::create($request->validated());
    }

    public function show(Car $car): CarResource
    {
        $this->authorize('view', $car);

        $car->loadCount('trips')->loadSum('trips', 'miles');

        return new CarResource($car);
    }

    public function destroy(Car $car): void
    {
        $this->authorize('delete', $car);

        $car->delete();
    }
}
