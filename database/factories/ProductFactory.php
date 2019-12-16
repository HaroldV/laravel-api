<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class,  function (Faker $faker) {
    return [
        'name' => $faker->name,
        'detail' => $faker->sentence
    ];
});
