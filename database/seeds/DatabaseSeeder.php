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
        $this->call(WorldSeeder::class);
        $this->call(WorldStatusSeeder::class);
        $this->call(EntrustSeeder::class);
        $this->call(UserAddressSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(TagSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductsTagsSeeder::class);
        $this->call(ProductsImagesSeeder::class);
        $this->call(ProductCoponSeeder::class);
        $this->call(ProductReviewSeeder::class);
        $this->call(ShippingCompanySeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(OrderSeeder::class);

    }
}
