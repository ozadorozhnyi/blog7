<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use Faker\Generator as Faker;

$themes = [
    'abstract', 'animals', 'business', 'cats',
    'city', 'food', 'nightlife', 'fashion',
    'people','nature', 'sports','technics',
    'transport'
];

$factory->define(Image::class, function (Faker $faker) use ($themes) {
    return [
        'article_id' => function (){
            return factory(App\Article::class)->create()->id;
        },
        'original' => $original = $faker->image(
            storage_path('app/images/articles'), 
            config('blog.image')->resolution->width, 
            config('blog.image')->resolution->height, 
            $themes[rand(0,(count($themes)-1))], false, true,
            config('app.name', 'Laravel7-Blog')
        ),
        'hashed' => $original
    ];
});
