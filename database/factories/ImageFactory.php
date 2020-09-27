<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'article_id' => function (){
            return factory(App\Article::class)->create()->id;
        },
        'original' => $original = $faker->image(
            storage_path('app/images/articles'), 
            config('blog.image')->resolution->width, 
            config('blog.image')->resolution->height, 
            'cats', false, true,
            config('app.name', 'Laravel7-Blog')
        ),
        'hashed' => $original
    ];
});
