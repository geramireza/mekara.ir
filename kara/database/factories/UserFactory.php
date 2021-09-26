<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        "phone" => $faker->phoneNumber(),
        "post_id_marked" => $faker->numberBetween(1,50)
    ];
});


$factory->define(Post::class, function (Faker $faker) {
    return [
        'category_id' => $faker->numberBetween(1,5),
        'post_token' =>$faker->regexify('[A-Za-z0-9]{30}'),
        'title' => $faker->sentence(8),
        'body' => $faker->paragraph(5),
        'fee' => $faker->numberBetween(0,6000000),
        'fee_type'=>$faker->numberBetween(0,2),
        'city' => $faker->city,
        'post_type' => $faker->numberBetween(0,1),
        'post_life'=> $faker->numberBetween(7,30),
        'view_count' =>$faker->numberBetween(0,100),
        'is_enable' =>$faker->boolean(80),
        'is_pay' =>$faker->boolean(80),
        'is_emergency' => $faker->boolean(40),
        'img1' =>$faker->imageUrl($width = 200,$height = 200),
        'img2' =>$faker->imageUrl($width = 200,$height = 200),
        'img3' =>$faker->imageUrl($width = 200,$height = 200),
         'created_at' => Carbon:: now(),
        'updated_at' => Carbon:: now()
    ];
});

