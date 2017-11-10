<?php

use \App\Models\V1\Book;
use \App\Models\V1\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$user = factory(User::class)->create([
    		'email' => "test-account@email.com",
    		'token' => "___TEST_TOKEN___"
    	]);

        $user->books()->create([
            'title' => "Lengend of the Seeder"
        ]);

    	factory(Book::class, 50)->create();
    	factory(User::class, 5)->create();
    	
    	// $this->call('UsersTableSeeder');
    }
}
