<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Product::class, function (Faker $faker) {
    return [

        /* Aaron
            NOTE:   Laravel already included the faker library (see https://github.com/fzaninotto/Faker for detail)
                    Faker library provides all kinds of data type/format generators, for example, word for any kind of text,
                    paragraph for random paragraph and numberBetween for random number between the specified range.
                    Please check the Faker git link for more options!
        */
        'name' => $faker->word,
        'detail' => $faker->paragraph,
        'price' => $faker->numberBetween($min = 100, $max = 1000),
        'stock' => $faker->randomDigit,
        'discount' => $faker->numberBetween($min = 0, $max = 30),
        'user_id' => function(){
            return App\User::all()->random();
        }
    ];
});
