<?php

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            'name'                      => 'PayPal',
            'code'                      => 'PPEX',
            'driver_name'               => 'PayPal_Express',
            'merchant_email'            => null,
            'client_id'                 => null,
            'client_secret'             => null,
            'username'                  => null,
            'password'                  => null,
            'secret'                    => null,

            'sandbox_merchant_email'    => 'sb-skvh58426250@business.example.com',
            'sandbox_client_id'         => 'Abx4l7ZEswvPugLYaL_L1jcR0QroZTtXikz7GDWR8hQ1T_3SUwCdOMiJ4Fc72z68HNCk-0knYx5C8dUz',
            'sandbox_client_secret'     => 'EDnqHCiWB54ZspETi9r53E1TjIqvZA_WDPBTNF-W5ZDaGTKPUDLo93Zq6PInHi8ec5FSFzWuPHBx8ldf',
            'sandbox_username'          => null,
            'sandbox_password'          => null,
            'sandbox_secret'            => null,
            'sandbox'                   => true,
            'status'                    => true,
        ]);
    }
}
