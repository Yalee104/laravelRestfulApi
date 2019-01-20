<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        /*  Aaron
            Creating fake data using the factory we have build (check ProductFactory.php & ReviewFactory.php)
            related method can be found in https://laravel.com/docs/5.7/database-testing 
        */
        factory(App\Admin::class, 1)->create();
        factory(App\User::class, 5)->create();
        factory(App\Model\Product::class, 50)->create();
        factory(App\Model\Review::class, 300)->create();

    }
}
