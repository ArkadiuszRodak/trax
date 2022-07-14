<?php

namespace App\Http\Controllers;

use App\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Resources\CarCollection;
use App\Http\Resources\CarResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CarController extends Controller
{
    public function index(): CarCollection
    {
        $this->authorize('viewAny', Car::class);

        return new CarCollection(Car::all());
    }

    public function store(StoreCarRequest $request): JsonResponse
    {
        $this->authorize('create', Car::class);

        $car = Car::create($request->validated());

        return response()->json(['data' => $car], Response::HTTP_CREATED);
    }

    public function show(Car $car): CarResource
    {
        $this->authorize('view', $car);

        $car->loadCount('trips');
        $car->total = $car->latestTrip?->total ?? 0;

        return new CarResource($car);
    }

    public function destroy(Car $car): JsonResponse
    {
        $this->authorize('delete', $car);

        $car->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
