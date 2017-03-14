<?php

namespace Tests;

use App\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function actingAsAdmin()
    {
        Passport::actingAs(
            factory(User::class, 'admin')->create(),
            ['user', 'article']
        );

        return $this;
    }
}