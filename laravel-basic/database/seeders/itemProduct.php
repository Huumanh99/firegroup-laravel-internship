<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class itemProduct extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $limit = 10;
        for ($i = 0; $i < $limit; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'username' => $faker->name,
                'email' => $faker->unique()->email,
                'password' => Str::random(10),
                'image' => 'fake.jpg',
                'role' => 'admin',
                'is_active' => $faker->boolean()
            ]);
        }
    }
}
