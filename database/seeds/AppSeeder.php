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
        $users = factory(App\User::class, config('blog.seed')->users)->create();
    
        echo "<< Generate a new user accounts:\n";
        $users->each(function($user) {
            echo sprintf ("-> Email: %s (%s)\n", $user->email, $user->name);
            factory(App\Article::class, config('blog.seed')->articles)->create(['user_id'=>$user->id]);
        });
    }
}
