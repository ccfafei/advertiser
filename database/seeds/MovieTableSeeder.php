<?php

use Illuminate\Database\Seeder;

class MovieTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
    
            for($i = 0; $i < 1000; $i++) {
                App\Models\Movie::create([
                    'name' => $faker->name
                ]);
            }
        }
}
