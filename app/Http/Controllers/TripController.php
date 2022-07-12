<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTripRequest;
use App\Http\Resources\TripCollection;
use App\Trip;

class TripController extends Controller
{
    public function index(): TripCollection
    {
        return new TripCollection(Trip::with(['car'])->get());
    }

    public function store(StoreTripRequest $request): void
    {
        Trip::create($request->validated());
    }
}
