<?php

use App\Models\Order;
use App\Models\Product;
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();


        $farhUser = User::find(4);
        $products = Product::active()->hasQuantity()->activeCategory()->inRandomOrder()->take(3)->get();
        $subTotalValue = $products->sum('price');
        $discountValue = $subTotalValue / 2;
        $shippingValue = 15.00;
        $taxValue = ($subTotalValue - $discountValue) * 0.15;
        $totalValue = $subTotalValue - $discountValue + $shippingValue + $taxValue;

        // Create Order
        $order = $farhUser->orders()->create([
            'ref_id' => Str::random(15),
            'user_address_id' => 1,
            'shipping_company_id' => 1,
            'payment_method_id' => 1,
            'subtotal' => $subTotalValue,
            'discount_code' => 'FARH_200',
            'discount' => $discountValue,
            'shipping' => $shippingValue,
            'tax' => $taxValue,
            'total' => $totalValue,
            'currency' => 'USD',
            'order_status' => Order::PAYMENT_COMPLETED,
        ]);

        // Create Order Products
        $order->products()->attach($products->pluck('id')->toArray());

        // Create Order Transactions
        $order->transactions()->createMany([
            [
                'transaction' => Order::NEW_ORDER,
                'transaction_number' => null,
                'payment_result' => null,
            ],
            [
                'transaction' => Order::PAYMENT_COMPLETED,
                'transaction_number' => '9NW10162ME419262L',
                'payment_result' => 'success',
            ],
        ]);

        /*
         * Create fake order for each user
         */
        User::where('id', '>', 4)->each(function ($user) use ($faker) {
            foreach(range(4, 7) as $index) {
                $products = Product::active()->hasQuantity()->activeCategory()->inRandomOrder()->take(3)->get();
                $subTotalValue = $products->sum('price');
                $discountValue = $subTotalValue / 2;
                $shippingValue = 15.00;
                $taxValue = ($subTotalValue - $discountValue) * 0.15;
                $totalValue = $subTotalValue - $discountValue + $shippingValue + $taxValue;
                $order_status = rand(0, 8);
                // Create Order
                $order = $user->orders()->create([
                    'ref_id' => Str::random(15),
                    'user_address_id' => $user->addresses()->first()->id,
                    'shipping_company_id' => 1,
                    'payment_method_id' => 1,
                    'subtotal' => $subTotalValue,
                    'discount_code' => 'FARH_200',
                    'discount' => $discountValue,
                    'shipping' => $shippingValue,
                    'tax' => $taxValue,
                    'total' => $totalValue,
                    'currency' => 'USD',
                    'order_status' => $order_status,
                    'created_at' => $faker->dateTimeBetween('-7 months', 'now'),
                    'updated_at' => $faker->dateTimeBetween('-7 months', 'now'),
                ]);

                // Create Order Products
                $order->products()->attach($products->pluck('id')->toArray());

                // Create Order Transactions
                $order->transactions()->createMany([
                    [
                        'transaction' => Order::NEW_ORDER,
                        'transaction_number' => null,
                        'payment_result' => null,
                    ],
                    [
                        'transaction' => $order_status,
                        'transaction_number' => '9NW10162ME419262L',
                        'payment_result' => 'success',
                    ],
                ]);

            }

        });

    }
}
