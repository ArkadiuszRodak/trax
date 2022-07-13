<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setup();

        $this->user = User::factory()->create();
    }

    protected function login(): static
    {
        Passport::actingAs($this->user);

        return $this;
    }
}
