<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

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
