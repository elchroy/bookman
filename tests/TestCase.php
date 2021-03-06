<?php

abstract class TestCase extends \Laravel\Lumen\Testing\TestCase
{
    protected $baseURL = 'http://localhost:5000';

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function setUp()
    {
        parent::setUp();
        $this->artisan('migrate:reset');
        $this->artisan('migrate');
        $this->artisan('db:seed');

        $this->anotherUser = App\Models\V1\User::create([
            'email' => 'current-user@email.com',
            'token' => '__CURRENT_USER_TOKEN__',
        ]);
    }

    public function tearDown()
    {
        $this->artisan('migrate:reset');
        parent::tearDown();
    }
}
