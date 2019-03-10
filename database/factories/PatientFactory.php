<?php

use App\Patient;
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

$factory->define(Patient::class, function (Faker $faker) {
    return [
    	'reg_no' => $faker->unique()->randomDigit,
        'first_name' => $faker->firstName,
        'middle_name' => $faker->lastName,
        'last_name' => $faker->lastName,
        'gender' => 'male',
        'age' => 21,
        'social_indicator' => 'garib',
        'is_new' => 1,
        'address' => $faker->word,
        'is_referred' => 1,
        'has_id' => 1,
        'group'  => 'asahaya',
        'admin' => 'admin'
    ];
});
