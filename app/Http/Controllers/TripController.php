<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTripRequest;
use App\Http\Resources\TripCollection;
use App\Trip;

class TripController extends Controller
{
    public function index(): TripCollection
    {
        $this->authorize('viewAny', Trip::class);

        return new TripCollection(Trip::with(['car'])->get());
    }

    public function store(StoreTripRequest $request): void
    {
        $this->authorize('create', Trip::class);

        Trip::create($request->validated());
    }
}
