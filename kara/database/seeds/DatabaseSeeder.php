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
         $this->call([
             ReportTitleSeeder::class,
             CitySeeder::class,
             CategorySeeder::class,
             BlogCategorySeeder::class,
             PriceSeeder::class
         ]);

//        factory(\App\User::class, 50 )->create()->each(function ($user) {
//            factory(\App\Post::class, rand(0, 1))
//                ->create(['user_id' => $user->id]);
//            }
//        );
    }
}
