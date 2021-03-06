<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Story::class, function (Faker $faker) {
    return [
        'title' => $faker->text(100),
        'slug' => $faker->slug,
        'summary' => $faker->paragraph(5),
    ];
});

$factory->afterCreating(App\Models\Story::class, function ($story, $faker) {
    $categories = App\Models\Meta::where('type', 'category')
        ->inRandomOrder()
        ->limit(rand(1, 3))
        ->get();
    $story->categories()->saveMany($categories);
    $story->chapters()->save(factory(App\Models\Chapter::class, rand(10, 20))->make());
});
