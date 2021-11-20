<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\City;
use App\Country;
use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\UserAddress::class, function (Faker $faker) {

    $eg    = Country::with('states')->whereId(65)->first();
    $state = $eg->states->random()->id;
    $city  = City::whereStateId($state)->inRandomOrder()->first()->id;

    return [
        // 'user_id' => factory(User::class),
        'user_id' => $faker->numberBetween(5, 1004),
        'address_title' => $faker->randomElement(['Home', 'Work', 'Father', 'Mother']),
        'default_address' => rand(0, 1),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->safeEmail,
        'mobile' => $faker->phoneNumber,
        'address' => $faker->streetAddress,
        'address2' => $faker->address,
        'country_id' => $eg->id,
        'state_id' => $state,
        'city_id' => $city,
        'zip_code' => $faker->postcode,
        'po_box' => $faker->numberBetween(1000, 9999),
    ];
});
