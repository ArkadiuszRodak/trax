<?php

namespace App\Http\Controllers;

use App\Trip;
use App\Http\Requests\StoreTripRequest;
use App\Http\Resources\TripCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TripController extends Controller
{
    public function index(): TripCollection
    {
        $this->authorize('viewAny', Trip::class);

        return new TripCollection(Trip::with(['car'])->get());
    }

    public function store(StoreTripRequest $request): JsonResponse
    {
        $this->authorize('create', Trip::class);

        $trip = Trip::create($request->validated());

        return response()->json(['data' => $trip], Response::HTTP_CREATED);
    }
}
