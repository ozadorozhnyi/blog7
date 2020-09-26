<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Article::class, function (Faker $faker) {
    
    $resolution = config('blog.image')->resolution;
    
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'title' => $faker->sentence(rand(8,11)),
        'description' => $description = $faker->realText(3800, 5),
        'preview' => Str::words($description, 120),
        'image' => $faker->imageUrl(
            $resolution->width,
            $resolution->height,
            'cats', true, 'Zadorozhnyi'
        )
    ];
});
