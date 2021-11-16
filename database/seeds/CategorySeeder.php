<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clothes = Category::create(['name' => 'Clothes', 'cover' => 'clothes.jpg', 'status' => true, 'visible' => true, 'parent_id' => null, 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women T-shirt', 'cover' => 'womenclothes.jpg', 'status' => true, 'visible' => true, 'parent_id' => $clothes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women2 T-shirt', 'cover' => 'womenclothes2.jpg', 'status' => true, 'visible' => true, 'parent_id' => $clothes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'man T-shirt', 'cover' => 'manclothes.jpg', 'status' =>true, 'visible' => true, 'parent_id' => $clothes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'man2 T-shirt', 'cover' => 'manclothes2.jpg', 'status' => true, 'visible' => true, 'parent_id' => $clothes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);


        $shoes = Category::create(['name' => 'shoes', 'cover' => 'shoes.jpg', 'status' => true, 'visible' => true, 'parent_id' => null, 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women shoes', 'cover' => 'womenshoes.jpg', 'status' => true, 'visible' => true, 'parent_id' => $shoes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women2 shoes', 'cover' => 'womenshoes2.jpg', 'status' => true, 'visible' => true, 'parent_id' => $shoes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Man shoes', 'cover' => 'manshoes.jpg', 'status' => true, 'visible' => true, 'parent_id' => $shoes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Man2 shoes', 'cover' => 'manshoes2.jpg', 'status' => true, 'visible' => true, 'parent_id' => $shoes->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);


        $watches = Category::create(['name' => 'Watches', 'cover' => 'watches.jpg', 'status' => true, 'visible' => true, 'parent_id' => null, 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women Watch', 'cover' => 'womenwatches.jpg', 'status' => true, 'visible' => true, 'parent_id' => $watches->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women2 Watch', 'cover' => 'womenwatches2.jpg', 'status' => true, 'visible' => true, 'parent_id' => $watches->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'man Watch', 'cover' => 'manwatches.jpg', 'status' => true, 'visible' => true, 'parent_id' => $watches->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'man2 Watch', 'cover' => 'manwatches2.jpg', 'status' => true, 'visible' => true, 'parent_id' => $watches->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);

        $electronics = Category::create(['name' => 'electronics', 'cover' => 'electronics.jpg', 'status' => true, 'visible' => true, 'parent_id' => null, 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women Electronics', 'cover' => 'electronics.jpg', 'status' => true, 'visible' => true, 'parent_id' => $electronics->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'Women2 Electronics', 'cover' => 'electronics.jpg', 'status' => true, 'visible' => true, 'parent_id' => $electronics->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'man Electronics', 'cover' => 'electronics.jpg', 'status' => true, 'visible' => true, 'parent_id' => $electronics->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);
        Category::create(['name' => 'man2 Electronics', 'cover' => 'electronics.jpg', 'status' => true, 'visible' => true, 'parent_id' => $electronics->id , 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.']);


    }
}
