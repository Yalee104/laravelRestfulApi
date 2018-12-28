<?php

use App\Model\Product;
use Faker\Generator as Faker;

$factory->define(App\Model\Review::class, function (Faker $faker) {
    return [
        /* Aaron
            NOTE:   Laravel already included the faker library (see https://github.com/fzaninotto/Faker for detail)
                    Faker library provides all kinds of data type/format generators.. 
                    In addition refer to https://laravel.com/docs/5.7/database-testing for more enhanced feature for
                    factory database testing such as the case 'product_id' below since its a reference of the id n product table
                    we will have to obtain the random of existing id in product table.
        */
        'product_id' => function(){
            return Product::all()->random();
        },
        'customer' => $faker->name,
        'review' => $faker->paragraph,
        'star' => $faker->numberBetween($min = 0, $max = 5)
    ];
});
