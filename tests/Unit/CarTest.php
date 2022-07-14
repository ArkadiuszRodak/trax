<?php

namespace Tests\Unit;

use App\Car;
use App\Trip;
use App\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class CarTest extends TestCase
{
    private const URL = 'api/cars/';

    public function testNotLoggedCantSeeCars()
    {
        $this->json('get', url(static::URL))
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testUserCanSeeCars()
    {
        $this->login()
            ->json('get', url(static::URL))
            ->assertOk();
    }

    public function testUserCantSeeNotOwnedCar()
    {
        $car = Car::factory()->create();

        $this->login()
            ->json('get', url(static::URL . $car->id))
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testUserCanSeeOwnedCar()
    {
        $car = Car::factory()
            ->has(Trip::factory()->count(3))
            ->create([
                'user_id' => $this->user->id,
            ]);

        $response = $this->login()
            ->json('get', url(static::URL . $car->id))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'make',
                    'model',
                    'year',
                    'trip_count',
                    'trip_miles',
                ]
            ]);
    }

    public function testUserCanCreateCar()
    {
        $car = Car::factory()->make();

        $this->login()
            ->json('post', url(static::URL), $car->toArray())
            ->assertStatus(Response::HTTP_CREATED);
    }

    public function testUserCantCreateNotValidatedCar()
    {
        $car = [
            'make' => 'VW',
            'model' => 'Golf',
            'year' => 'invalid year',
        ];

        $this->login()
            ->json('post', url(static::URL), $car)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testUserCantDeleteNotOwnedCar()
    {
        $car = Car::factory()->create();

        $this->login()
            ->json('delete', url(static::URL . $car->id))
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testUserCanDeleteOwnedCar()
    {
        $car = Car::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $this->login()
            ->json('delete', url(static::URL . $car->id))
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testCarHasTrips()
    {
        $car = Car::factory()
            ->has(Trip::factory())
            ->create();

        $this->assertInstanceOf(Trip::class, $car->trips?->first());
    }

    public function testCarHasLatestTrip()
    {
        $car = Car::factory()
            ->has(Trip::factory()->count(3))
            ->create();

        $this->assertInstanceOf(Trip::class, $car->latestTrip);
    }

    public function testCarBelongsToUser()
    {
        $car = Car::factory()->create();

        $this->assertInstanceOf(User::class, $car->user);
    }

    public function testCarShowsTripsNumberAndMileage()
    {
        $car = Car::factory()
            ->has(Trip::factory()->count(10))
            ->create([
                'user_id' => $this->user->id,
            ]);

        $car->loadCount('trips');
        $car->loadSum('trips', 'miles');

        $response = $this->login()
            ->json('get', url(static::URL . $car->id))
            ->assertOk();

        $data = $response->getData()->data;

        $this->assertEquals($data->trip_count, $car->trips_count);
        $this->assertEquals($data->trip_miles, $car->trips_sum_miles);
    }
}
