<?php

use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(App\User::class,3)->create();
    
        echo "<< Generate a new user accounts:\n";
        $users->each(function($user) {
            echo sprintf ("-> Email: %s (%s)\n", $user->email, $user->name);
            factory(App\Article::class, 5)->create(['user_id'=>$user->id]);
        });
    }
}
