<?php

use App\City;
use App\Country;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Faker\Factory;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        // DB::table('customer_addresses');
        $faker = Factory::create();

        $mohamed  = User::whereUsername('Mohamed Farh')->first();
        $eg    = Country::with('states')->whereId(65)->first();
        $state = $eg->states->random()->id;
        $city  = City::whereStateId($state)->inRandomOrder()->first()->id;

        $mohamed->addresses()->create([
            'default_address'=> true,
            'address_title'  => 'Home',
            'first_name'     => 'Mohamed',
            'last_name'      => 'Farh',
            'email'          => $faker->email,
            'mobile'         => $faker->phoneNumber,
            'address'        => $faker->address,
            'address2'       => $faker->secondaryAddress,
            'country_id'     => $eg->id,
            'state_id'       => $state,
            'city_id'        => $city,
            'zip_code'       => $faker->randomNumber(5),
            'po_box'         => $faker->randomNumber(4),
        ]);

        $mohamed->addresses()->create([
            'default_address'=> false,
            'address_title'  => 'Work',
            'first_name'     => 'Mohamed',
            'last_name'      => 'Farh',
            'email'          => $faker->email,
            'mobile'         => $faker->phoneNumber,
            'address'        => $faker->address,
            'address2'       => $faker->secondaryAddress,
            'country_id'     => $eg->id,
            'state_id'       => $state,
            'city_id'        => $city,
            'zip_code'       => $faker->randomNumber(5),
            'po_box'         => $faker->randomNumber(4),
        ]);


        $ahmed  = User::whereUsername('Ahmed Farh')->first();
        $ahmed->addresses()->create([
            'default_address'=> false,
            'address_title'  => 'Home',
            'first_name'     => 'Ahmed',
            'last_name'      => 'Farh',
            'email'          => $faker->email,
            'mobile'         => $faker->phoneNumber,
            'address'        => $faker->address,
            'address2'       => $faker->secondaryAddress,
            'country_id'     => $eg->id,
            'state_id'       => $state,
            'city_id'        => $city,
            'zip_code'       => $faker->randomNumber(5),
            'po_box'         => $faker->randomNumber(4),
        ]);

        $customer  = User::whereUsername('Customer Customer')->first();
        $customer->addresses()->create([
            'default_address'=> false,
            'address_title'  => 'Home',
            'first_name'     => 'Customer',
            'last_name'      => 'Customer',
            'email'          => $faker->email,
            'mobile'         => $faker->phoneNumber,
            'address'        => $faker->address,
            'address2'       => $faker->secondaryAddress,
            'country_id'     => $eg->id,
            'state_id'       => $state,
            'city_id'        => $city,
            'zip_code'       => $faker->randomNumber(5),
            'po_box'         => $faker->randomNumber(4),
        ]);

        Schema::enableForeignKeyConstraints();

    }
}
