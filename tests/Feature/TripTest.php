<?php

namespace Tests\Feature;

use App\Car;
use App\Trip;
use Illuminate\Http\Response;
use Tests\TestCase;

class TripTest extends TestCase
{
    private const URL = 'api/trips/';

    public function testNotLoggedCantSeeTrips()
    {
        $this->json('get', url(static::URL))
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testUserCanSeeTrips()
    {
        $this->login()
            ->json('get', url(static::URL))
            ->assertOk();
    }

    public function testUserCanCreateTrip()
    {
        $trip = Trip::factory()->make();

        $this->login()
            ->json('post', url(static::URL), $trip->toArray())
            ->assertStatus(Response::HTTP_CREATED);
    }

    public function testUserCantCreateNotValidatedTrip()
    {
        $trip = [
            'date' => 'invalid date',
            'miles' => 123,
            'car_id' => 777,
        ];

        $this->login()
            ->json('post', url(static::URL), $trip)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testTripBelongsToCar()
    {
        $trip = Trip::factory()->create();

        $this->assertInstanceOf(Car::class, $trip->car);
    }

    public function testTripTotalIsCalculated()
    {
        $car = Car::factory()
            ->has(Trip::factory()->count(10))
            ->create();

        $firstTrip = Trip::where('car_id', $car->id)->first();
        $latestTrip = Trip::where('car_id', $car->id)->orderBy('id', 'DESC')->first();

        $car->loadSum('trips', 'miles');

        $this->assertEquals($firstTrip->miles, $firstTrip->total);
        $this->assertEquals($car->trips_sum_miles, $latestTrip->total);
    }
}
