<?php

use App\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Role;
use App\User;
use App\Models\UserAddress;
use Carbon\Carbon;

class EntrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     *
     * @return void
     */
    public function run()
    {

        $superAdminRole     = Role::create(['name' => 'superAdmin',  'display_name' => 'Administrator',  'description' => 'System Administrator', 'allowed_route' => 'admin']);
        $adminRole          = Role::create(['name' => 'admin',       'display_name' => 'admin',          'description' => 'System Admin',         'allowed_route' => 'admin']);
        $userRole           = Role::create(['name' => 'user',        'display_name' => 'User',           'description' => 'System User',          'allowed_route' => 'admin']);
        $customerRole       = Role::create(['name' => 'customer',    'display_name' => 'Customer',       'description' => 'Normal User',          'allowed_route' => null]);

        $superAdmin = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'username' => 'System Administrator',
            'email' => 'superAdmin@superAdmin.com',
            'mobile' => '01234567890',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ]);
        $superAdmin->attachRole($superAdminRole);


        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'System',
            'username' => 'System Admin',
            'email' => 'admin@admin.com',
            'mobile' => '01234567880',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ]);
        $admin->attachRole($adminRole);


        $user = User::create([
            'first_name' => 'User',
            'last_name' => 'System',
            'username' => 'System User',
            'email' => 'user@user.com',
            'mobile' => '01234567800',
            'password' => bcrypt('password'),
            'email_verified_at' => Carbon::now(),
            'remember_token' => Str::random(10),
        ]);
        $user->attachRole($userRole);



        $user1 = User::create(['first_name' => 'Mohamed',   'last_name' => 'Farh',     'username' => 'Mohamed Farh',     'email' => 'mohamed@yahoo.com', 'mobile' => '01234567799','status'=> 1, 'password' => bcrypt('password'),'email_verified_at' => Carbon::now(), 'remember_token' => Str::random(10), ]);
        $user1->attachRole($customerRole);

        $user2 = User::create(['first_name' => 'Ahmed',     'last_name' => 'Farh',     'username' => 'Ahmed Farh',       'email' => 'ahmed@yahoo.com',       'mobile' => '01234567699','status'=> 1, 'password' => bcrypt('password'),'email_verified_at' => Carbon::now(), 'remember_token' => Str::random(10), ]);
        $user2->attachRole($customerRole);

        $user3 = User::create([ 'first_name' => 'Customer', 'last_name' => 'Customer', 'username' => 'Customer Customer', 'email' => 'customer@customer.com',  'mobile' => '01234567999','status'=> 1, 'password' => bcrypt('password'),'email_verified_at' => Carbon::now(), 'remember_token' => Str::random(10), ]);
        $user3->attachRole($customerRole);


        // MAIN
        $manageMain = Permission::create([
            'name' => 'main',                           //?????? ???????????????? ???????? ????????????
            'display_name' => 'Main',                   //?????????? ???????? ?????????? ?????? ????????????????
            'description' => 'Administrator Dashboard', //?????? ???????? ????????????????
            'route' => 'index',                         //???????????? ???????? ???????????????? ??????
            'module' => 'index',                        //?????????? ???????????? ?????????? ???? ???????????? ????????????
            'as' => 'index',                            //
            'icon' => 'fa fa-home',                     //???????? ?????????? ??????????
            'parent' => '0',                            //
            'parent_original' => '0',                   //
            'sidebar_link' => '1',                      //?????????? ?????????? ???? ??????????????????
            'appear' => '1',                            //?????????? ???????? ?? ???? ????????
            'ordering' => '1',                          //?????? ???????? ?????????? ???? ??????????????????
        ]);
        $manageMain->parent_show = $manageMain->id;     //?????? ?????? ???????????? ???????? ???????????? ???? ?????????? ?????????????????? ?????? ??????
        $manageMain->save();


        /*
         * Create 1000 fake users with their addresses.
         */
        //factory(User::class, 1000)->hasAddresses(1)->create();

        // factory(App\User::class, 10)->create();

        // $users = factory(App\User::class, 10)
        //                 ->create()
        //                 ->each(function ($user) {
        //                     $user->addresses(1)->make();
        //                 });

        factory(App\User::class, 1000)->create()->each(function($user){

            $addresses = factory(App\Models\UserAddress::class)->make();

            $user->addresses()->save($addresses);
        });


        //Categories
        $manageCategories = Permission::create([ 'name' => 'manage_categories', 'display_name' => 'categories', 'route' => 'categories', 'module' => 'categories', 'as' => 'categories.index', 'icon' => 'fab fa-cuttlefish', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '5', ]);
        $manageCategories->parent_show = $manageCategories->id;
        $manageCategories->save();
        $showCategories    = Permission::create([ 'name' => 'show_categories',          'display_name' => 'Show All Categories',     'route' => 'categories.index',         'module' => 'categories', 'as' => 'categories.index',       'icon' => 'fab fa-cuttlefish', 'parent' => $manageCategories->id, 'parent_show' => $manageCategories->id, 'parent_original' => $manageCategories->id,'sidebar_link' => '1', 'appear' => '1', ]);
        $createCategories  = Permission::create([ 'name' => 'create_categories',        'display_name' => 'Create Categories',       'route' => 'categories.create',        'module' => 'categories', 'as' => 'categories.create',      'icon' => null,                  'parent' => $manageCategories->id, 'parent_show' => $manageCategories->id, 'parent_original' => $manageCategories->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $displayCategories = Permission::create([ 'name' => 'display_categories',       'display_name' => 'Display Categories',      'route' => 'categories.show',          'module' => 'categories', 'as' => 'categories.show',        'icon' => null,                  'parent' => $manageCategories->id, 'parent_show' => $manageCategories->id, 'parent_original' => $manageCategories->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $updateCategories  = Permission::create([ 'name' => 'update_categories',        'display_name' => 'Update Categories',       'route' => 'categories.edit',          'module' => 'categories', 'as' => 'categories.edit',        'icon' => null,                  'parent' => $manageCategories->id, 'parent_show' => $manageCategories->id, 'parent_original' => $manageCategories->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $destroyCategories = Permission::create([ 'name' => 'delete_categories',        'display_name' => 'Delete Categories',       'route' => 'categories.destroy',       'module' => 'categories', 'as' => 'categories.destroy',     'icon' => null,                  'parent' => $manageCategories->id, 'parent_show' => $manageCategories->id, 'parent_original' => $manageCategories->id,'sidebar_link' => '1', 'appear' => '0', ]);
        // $frontCategories   = Permission::create([ 'name' => 'frontDisplay_categories',  'display_name' => 'Front Display Categories','route' => 'categories.frontDisplay',  'module' => 'categories', 'as' => 'categories.frontDisplay','icon' => null,                  'parent' => $manageCategories->id, 'parent_show' => $manageCategories->id, 'parent_original' => $manageCategories->id,'sidebar_link' => '1', 'appear' => '0', ]);

        //Tags
        $manageTags = Permission::create([ 'name' => 'manage_tags', 'display_name' => 'Tags', 'route' => 'tags', 'module' => 'tags', 'as' => 'tags.index', 'icon' => 'fas fa-tags', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '11', ]);
        $manageTags->parent_show = $manageTags->id;
        $manageTags->save();
        $showTags     = Permission::create([ 'name' => 'show_tags',         'display_name' => 'Show All Tags',      'route' => 'tags.index',        'module' => 'tags', 'as' => 'tags.index',       'icon' => 'fas fa-tags', 'parent' => $manageTags->id, 'parent_show' => $manageTags->id, 'parent_original' => $manageTags->id,'sidebar_link' => '1', 'appear' => '1', ]);
        $createTags   = Permission::create([ 'name' => 'create_tags',       'display_name' => 'Create Tags',        'route' => 'tags.create',       'module' => 'tags', 'as' => 'tags.create',      'icon' => null,                  'parent' => $manageTags->id, 'parent_show' => $manageTags->id, 'parent_original' => $manageTags->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $displayTags  = Permission::create([ 'name' => 'display_tags',      'display_name' => 'Display Tags',       'route' => 'tags.show',         'module' => 'tags', 'as' => 'tags.show',        'icon' => null,                  'parent' => $manageTags->id, 'parent_show' => $manageTags->id, 'parent_original' => $manageTags->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $updateTags   = Permission::create([ 'name' => 'update_tags',       'display_name' => 'Update Tags',        'route' => 'tags.edit',         'module' => 'tags', 'as' => 'tags.edit',        'icon' => null,                  'parent' => $manageTags->id, 'parent_show' => $manageTags->id, 'parent_original' => $manageTags->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $destroyTags  = Permission::create([ 'name' => 'delete_tags',       'display_name' => 'Delete Tags',        'route' => 'tags.destroy',      'module' => 'tags', 'as' => 'tags.destroy',     'icon' => null,                  'parent' => $manageTags->id, 'parent_show' => $manageTags->id, 'parent_original' => $manageTags->id,'sidebar_link' => '1', 'appear' => '0', ]);
        // $frontTags    = Permission::create([ 'name' => 'frontDisplay_tags', 'display_name' => 'Front Display Tags', 'route' => 'tags.frontDisplay', 'module' => 'tags', 'as' => 'tags.frontDisplay','icon' => null,                  'parent' => $manageTags->id, 'parent_show' => $manageTags->id, 'parent_original' => $manageTags->id,'sidebar_link' => '1', 'appear' => '0', ]);

        //Products
        $manageProducts = Permission::create([ 'name' => 'manage_products', 'display_name' => 'Products', 'route' => 'products', 'module' => 'products', 'as' => 'products.index', 'icon' => 'fab fa-product-hunt', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '17', ]);
        $manageProducts->parent_show = $manageProducts->id;
        $manageProducts->save();
        $showProducts    = Permission::create([ 'name' => 'show_products',          'display_name' => 'Show All Products',    'route' => 'products.index',          'module' => 'products', 'as' => 'products.index',       'icon' => 'fab fa-product-hunt', 'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '1', ]);
        $createProducts  = Permission::create([ 'name' => 'create_products',        'display_name' => 'Create Products',      'route' => 'products.create',         'module' => 'products', 'as' => 'products.create',      'icon' => null,                  'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $displayProducts = Permission::create([ 'name' => 'display_products',       'display_name' => 'Display Products',     'route' => 'products.show',           'module' => 'products', 'as' => 'products.show',        'icon' => null,                  'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $updateProducts  = Permission::create([ 'name' => 'update_products',        'display_name' => 'Update Products',      'route' => 'products.edit',           'module' => 'products', 'as' => 'products.edit',        'icon' => null,                  'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $destroyProducts = Permission::create([ 'name' => 'delete_products',        'display_name' => 'Delete Products',      'route' => 'products.destroy',        'module' => 'products', 'as' => 'products.destroy',     'icon' => null,                  'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '0', ]);
        // $frontProducts   = Permission::create([ 'name' => 'frontDisplay_products',  'display_name' => 'Front Display Product','route' => 'products.frontDisplay',   'module' => 'products', 'as' => 'products.frontDisplay','icon' => null,                  'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '0', ]);

        //Product Copons
        $manageProductCopons = Permission::create([ 'name' => 'manage_productCopons', 'display_name' => 'Product Copons', 'route' => 'productCopons', 'module' => 'productCopons', 'as' => 'productCopons.index', 'icon' => 'fas fa-hand-holding-usd', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '23', ]);
        $manageProductCopons->parent_show = $manageProductCopons->id;
        $manageProductCopons->save();
        $showProductCopons    = Permission::create([ 'name' => 'show_productCopons',          'display_name' => 'Show All Product Copons',     'route' => 'productCopons.index',          'module' => 'productCopons', 'as' => 'productCopons.index',       'icon' => 'fas fa-hand-holding-usd', 'parent' => $manageProductCopons->id, 'parent_show' => $manageProductCopons->id, 'parent_original' => $manageProductCopons->id,'sidebar_link' => '1', 'appear' => '1', ]);
        $createProductCopons  = Permission::create([ 'name' => 'create_productCopons',        'display_name' => 'Create Product Copons',       'route' => 'productCopons.create',         'module' => 'productCopons', 'as' => 'productCopons.create',      'icon' => null,                  'parent' => $manageProductCopons->id, 'parent_show' => $manageProductCopons->id, 'parent_original' => $manageProductCopons->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $displayProductCopons = Permission::create([ 'name' => 'display_productCopons',       'display_name' => 'Display Product Copons',      'route' => 'productCopons.show',           'module' => 'productCopons', 'as' => 'productCopons.show',        'icon' => null,                  'parent' => $manageProductCopons->id, 'parent_show' => $manageProductCopons->id, 'parent_original' => $manageProductCopons->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $updateProductCopons  = Permission::create([ 'name' => 'update_productCopons',        'display_name' => 'Update Product Copons',       'route' => 'productCopons.edit',           'module' => 'productCopons', 'as' => 'productCopons.edit',        'icon' => null,                  'parent' => $manageProductCopons->id, 'parent_show' => $manageProductCopons->id, 'parent_original' => $manageProductCopons->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $destroyProductCopons = Permission::create([ 'name' => 'delete_productCopons',        'display_name' => 'Delete Product Copons',       'route' => 'productCopons.destroy',        'module' => 'productCopons', 'as' => 'productCopons.destroy',     'icon' => null,                  'parent' => $manageProductCopons->id, 'parent_show' => $manageProductCopons->id, 'parent_original' => $manageProductCopons->id,'sidebar_link' => '1', 'appear' => '0', ]);
        // $frontProductCopons   = Permission::create([ 'name' => 'frontDisplay_productCopons',  'display_name' => 'Front Display Product Copons','route' => 'productCopons.frontDisplay',   'module' => 'productCopons', 'as' => 'productCopons.frontDisplay','icon' => null,                  'parent' => $manageProductCopons->id, 'parent_show' => $manageProductCopons->id, 'parent_original' => $manageProductCopons->id,'sidebar_link' => '1', 'appear' => '0', ]);

        //Product Reviews
        $manageProductReviews = Permission::create([ 'name' => 'manage_productReviews', 'display_name' => 'Product Reviews', 'route' => 'productReviews', 'module' => 'productReviews', 'as' => 'productReviews.index', 'icon' => 'fas fa-search-dollar', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '29', ]);
        $manageProductReviews->parent_show = $manageProductReviews->id;
        $manageProductReviews->save();
        $showProductReviews    = Permission::create([ 'name' => 'show_productReviews',          'display_name' => 'Show All Product Reviews',     'route' => 'productReviews.index',          'module' => 'productReviews', 'as' => 'productReviews.index',       'icon' => 'fas fa-search-dollar','parent' => $manageProductReviews->id, 'parent_show' => $manageProductReviews->id, 'parent_original' => $manageProductReviews->id,'sidebar_link' => '1', 'appear' => '1', ]);
        $createProductReviews  = Permission::create([ 'name' => 'create_productReviews',        'display_name' => 'Create Product Reviews',       'route' => 'productReviews.create',         'module' => 'productReviews', 'as' => 'productReviews.create',      'icon' => null,                  'parent' => $manageProductReviews->id, 'parent_show' => $manageProductReviews->id, 'parent_original' => $manageProductReviews->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $displayProductReviews = Permission::create([ 'name' => 'display_productReviews',       'display_name' => 'Display Product Reviews',      'route' => 'productReviews.show',           'module' => 'productReviews', 'as' => 'productReviews.show',        'icon' => null,                  'parent' => $manageProductReviews->id, 'parent_show' => $manageProductReviews->id, 'parent_original' => $manageProductReviews->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $updateProductReviews  = Permission::create([ 'name' => 'update_productReviews',        'display_name' => 'Update Product Reviews',       'route' => 'productReviews.edit',           'module' => 'productReviews', 'as' => 'productReviews.edit',        'icon' => null,                  'parent' => $manageProductReviews->id, 'parent_show' => $manageProductReviews->id, 'parent_original' => $manageProductReviews->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $destroyProductReviews = Permission::create([ 'name' => 'delete_productReviews',        'display_name' => 'Delete Product Reviews',       'route' => 'productReviews.destroy',        'module' => 'productReviews', 'as' => 'productReviews.destroy',     'icon' => null,                  'parent' => $manageProductReviews->id, 'parent_show' => $manageProductReviews->id, 'parent_original' => $manageProductReviews->id,'sidebar_link' => '1', 'appear' => '0', ]);
        // $frontProductReviews   = Permission::create([ 'name' => 'frontDisplay_productReviews',  'display_name' => 'Front Display Product Reviews','route' => 'productReviews.frontDisplay',   'module' => 'productReviews', 'as' => 'productReviews.frontDisplay','icon' => null,                  'parent' => $manageProductReviews->id, 'parent_show' => $manageProductReviews->id, 'parent_original' => $manageProductReviews->id,'sidebar_link' => '1', 'appear' => '0', ]);


        //Customers
        $manageCustomers = Permission::create([ 'name' => 'manage_customers', 'display_name' => 'Customers', 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.index', 'icon' => 'fas fa-user', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '35', ]);
        $manageCustomers->parent_show = $manageCustomers->id;
        $manageCustomers->save();
        $showCustomers    = Permission::create([ 'name' => 'show_customers',          'display_name' => 'Show All Customers',     'route' => 'customers.index',          'module' => 'customers', 'as' => 'customers.index',       'icon' => 'fas fa-user','parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '1', ]);
        $createCustomers  = Permission::create([ 'name' => 'create_customers',        'display_name' => 'Create Customers',       'route' => 'customers.create',         'module' => 'customers', 'as' => 'customers.create',      'icon' => null,                  'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $displayCustomers = Permission::create([ 'name' => 'display_customers',       'display_name' => 'Display Customers',      'route' => 'customers.show',           'module' => 'customers', 'as' => 'customers.show',        'icon' => null,                  'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $updateCustomers  = Permission::create([ 'name' => 'update_customers',        'display_name' => 'Update Customers',       'route' => 'customers.edit',           'module' => 'customers', 'as' => 'customers.edit',        'icon' => null,                  'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $destroyCustomers = Permission::create([ 'name' => 'delete_customers',        'display_name' => 'Delete Customers',       'route' => 'customers.destroy',        'module' => 'customers', 'as' => 'customers.destroy',     'icon' => null,                  'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '0', ]);
        // $frontCustomers   = Permission::create([ 'name' => 'frontDisplay_customers',  'display_name' => 'Front Display Customers','route' => 'customers.frontDisplay',   'module' => 'customers', 'as' => 'customers.frontDisplay','icon' => null,                  'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '0', ]);

            //Customer Addresses
            $manageCustomerAddresses = Permission::create([ 'name' => 'manage_customer_addresses', 'display_name' => 'Customer Addresses', 'route' => 'customer_addresses', 'module' => 'customer_addresses', 'as' => 'customer_addresses.index', 'icon' => 'fas fa-street-view', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '40', ]);
            $manageCustomerAddresses->parent_show = $manageCustomerAddresses->id;
            $manageCustomerAddresses->save();
            $showCustomerAddresses    = Permission::create([ 'name' => 'show_customer_addresses',          'display_name' => 'Show Customer Addresses',     'route' => 'customer_addresses.index',          'module' => 'customer_addresses', 'as' => 'customer_addresses.index',       'icon' => 'fas fa-street-view','parent' => $manageCustomerAddresses->id, 'parent_show' => $manageCustomerAddresses->id, 'parent_original' => $manageCustomerAddresses->id,'sidebar_link' => '1', 'appear' => '1', ]);
            $createCustomerAddresses  = Permission::create([ 'name' => 'create_customer_addresses',        'display_name' => 'Create CustomerAddresses',       'route' => 'customer_addresses.create',         'module' => 'customer_addresses', 'as' => 'customer_addresses.create',      'icon' => null,                  'parent' => $manageCustomerAddresses->id, 'parent_show' => $manageCustomerAddresses->id, 'parent_original' => $manageCustomerAddresses->id,'sidebar_link' => '1', 'appear' => '0', ]);
            $displayCustomerAddresses = Permission::create([ 'name' => 'display_customer_addresses',       'display_name' => 'Display CustomerAddresses',      'route' => 'customer_addresses.show',           'module' => 'customer_addresses', 'as' => 'customer_addresses.show',        'icon' => null,                  'parent' => $manageCustomerAddresses->id, 'parent_show' => $manageCustomerAddresses->id, 'parent_original' => $manageCustomerAddresses->id,'sidebar_link' => '1', 'appear' => '0', ]);
            $updateCustomerAddresses  = Permission::create([ 'name' => 'update_customer_addresses',        'display_name' => 'Update CustomerAddresses',       'route' => 'customer_addresses.edit',           'module' => 'customer_addresses', 'as' => 'customer_addresses.edit',        'icon' => null,                  'parent' => $manageCustomerAddresses->id, 'parent_show' => $manageCustomerAddresses->id, 'parent_original' => $manageCustomerAddresses->id,'sidebar_link' => '1', 'appear' => '0', ]);
            $destroyCustomerAddresses = Permission::create([ 'name' => 'delete_customer_addresses',        'display_name' => 'Delete CustomerAddresses',       'route' => 'customer_addresses.destroy',        'module' => 'customer_addresses', 'as' => 'customer_addresses.destroy',     'icon' => null,                  'parent' => $manageCustomerAddresses->id, 'parent_show' => $manageCustomerAddresses->id, 'parent_original' => $manageCustomerAddresses->id,'sidebar_link' => '1', 'appear' => '0', ]);
            // $frontCustomers   = Permission::create([ 'name' => 'frontDisplay_customers',  'display_name' => 'Front Display Customers','route' => 'customers.frontDisplay',   'module' => 'customers', 'as' => 'customers.frontDisplay','icon' => null,                  'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '0', ]);

            //Orders
            $manageOrders = Permission::create([ 'name' => 'manage_orders', 'display_name' => 'Orders', 'route' => 'orders', 'module' => 'orders', 'as' => 'orders.index', 'icon' => 'fas fa-shopping-basket', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '45', ]);
            $manageOrders->parent_show = $manageOrders->id;
            $manageOrders->save();
            $showOrders    = Permission::create([ 'name' => 'show_orders',          'display_name' => 'Show All Orders',     'route' => 'orders.index',          'module' => 'orders', 'as' => 'orders.index',       'icon' => 'fas fa-globe',        'parent' => $manageOrders->id, 'parent_show' => $manageOrders->id, 'parent_original' => $manageOrders->id,'sidebar_link' => '1', 'appear' => '1', ]);
            $createOrders  = Permission::create([ 'name' => 'create_orders',        'display_name' => 'Create Orders',       'route' => 'orders.create',         'module' => 'orders', 'as' => 'orders.create',      'icon' => null,                  'parent' => $manageOrders->id, 'parent_show' => $manageOrders->id, 'parent_original' => $manageOrders->id,'sidebar_link' => '1', 'appear' => '0', ]);
            $displayOrders = Permission::create([ 'name' => 'display_orders',       'display_name' => 'Display Orders',      'route' => 'orders.show',           'module' => 'orders', 'as' => 'orders.show',        'icon' => null,                  'parent' => $manageOrders->id, 'parent_show' => $manageOrders->id, 'parent_original' => $manageOrders->id,'sidebar_link' => '1', 'appear' => '0', ]);
            $updateOrders  = Permission::create([ 'name' => 'update_orders',        'display_name' => 'Update Orders',       'route' => 'orders.edit',           'module' => 'orders', 'as' => 'orders.edit',        'icon' => null,                  'parent' => $manageOrders->id, 'parent_show' => $manageOrders->id, 'parent_original' => $manageOrders->id,'sidebar_link' => '1', 'appear' => '0', ]);
            $destroyOrders = Permission::create([ 'name' => 'delete_orders',        'display_name' => 'Delete Orders',       'route' => 'orders.destroy',        'module' => 'orders', 'as' => 'orders.destroy',     'icon' => null,                  'parent' => $manageOrders->id, 'parent_show' => $manageOrders->id, 'parent_original' => $manageOrders->id,'sidebar_link' => '1', 'appear' => '0', ]);

            //Countries
            $manageCountries = Permission::create([ 'name' => 'manage_countries', 'display_name' => 'Countries', 'route' => 'countries', 'module' => 'countries', 'as' => 'countries.index', 'icon' => 'fas fa-globe', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '50', ]);
            $manageCountries->parent_show = $manageCountries->id;
            $manageCountries->save();
            $showCountries    = Permission::create([ 'name' => 'show_countries',          'display_name' => 'Show All Countries',     'route' => 'countries.index',          'module' => 'countries', 'as' => 'countries.index',       'icon' => 'fas fa-globe',        'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '1', ]);
            $createCountries  = Permission::create([ 'name' => 'create_countries',        'display_name' => 'Create Countries',       'route' => 'countries.create',         'module' => 'countries', 'as' => 'countries.create',      'icon' => null,                  'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '0', ]);
            $displayCountries = Permission::create([ 'name' => 'display_countries',       'display_name' => 'Display Countries',      'route' => 'countries.show',           'module' => 'countries', 'as' => 'countries.show',        'icon' => null,                  'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '0', ]);
            $updateCountries  = Permission::create([ 'name' => 'update_countries',        'display_name' => 'Update Countries',       'route' => 'countries.edit',           'module' => 'countries', 'as' => 'countries.edit',        'icon' => null,                  'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '0', ]);
            $destroyCountries = Permission::create([ 'name' => 'delete_countries',        'display_name' => 'Delete Countries',       'route' => 'countries.destroy',        'module' => 'countries', 'as' => 'countries.destroy',     'icon' => null,                  'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '0', ]);

            //States
            $manageStates = Permission::create([ 'name' => 'manage_states', 'display_name' => 'States', 'route' => 'states', 'module' => 'states', 'as' => 'states.index', 'icon' => 'fas fa-map-marker-alt', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '55', ]);
            $manageStates->parent_show = $manageStates->id;
            $manageStates->save();
            $showStates    = Permission::create([ 'name' => 'show_states',          'display_name' => 'Show All States',     'route' => 'states.index',          'module' => 'states', 'as' => 'states.index',       'icon' => 'fas fa-map-marker-alt', 'parent' => $manageStates->id, 'parent_show' => $manageStates->id, 'parent_original' => $manageStates->id,'sidebar_link' => '1', 'appear' => '1', ]);
            $createStates  = Permission::create([ 'name' => 'create_states',        'display_name' => 'Create States',       'route' => 'states.create',         'module' => 'states', 'as' => 'states.create',      'icon' => null,                    'parent' => $manageStates->id, 'parent_show' => $manageStates->id, 'parent_original' => $manageStates->id,'sidebar_link' => '1', 'appear' => '0', ]);
            $displayStates = Permission::create([ 'name' => 'display_states',       'display_name' => 'Display States',      'route' => 'states.show',           'module' => 'states', 'as' => 'states.show',        'icon' => null,                    'parent' => $manageStates->id, 'parent_show' => $manageStates->id, 'parent_original' => $manageStates->id,'sidebar_link' => '1', 'appear' => '0', ]);
            $updateStates  = Permission::create([ 'name' => 'update_states',        'display_name' => 'Update States',       'route' => 'states.edit',           'module' => 'states', 'as' => 'states.edit',        'icon' => null,                    'parent' => $manageStates->id, 'parent_show' => $manageStates->id, 'parent_original' => $manageStates->id,'sidebar_link' => '1', 'appear' => '0', ]);
            $destroyStates = Permission::create([ 'name' => 'delete_states',        'display_name' => 'Delete States',       'route' => 'states.destroy',        'module' => 'states', 'as' => 'states.destroy',     'icon' => null,                    'parent' => $manageStates->id, 'parent_show' => $manageStates->id, 'parent_original' => $manageStates->id,'sidebar_link' => '1', 'appear' => '0', ]);

            //Cities
            $manageCities = Permission::create([ 'name' => 'manage_cities', 'display_name' => 'Cities', 'route' => 'cities', 'module' => 'cities', 'as' => 'cities.index', 'icon' => 'fas fa-university', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '60', ]);
            $manageCities->parent_show = $manageCities->id;
            $manageCities->save();
            $showCities    = Permission::create([ 'name' => 'show_cities',          'display_name' => 'Show All Cities',     'route' => 'cities.index',          'module' => 'cities', 'as' => 'cities.index',       'icon' => 'fas fa-university',   'parent' => $manageCities->id, 'parent_show' => $manageCities->id, 'parent_original' => $manageCities->id,'sidebar_link' => '1', 'appear' => '1', ]);
            $createCities  = Permission::create([ 'name' => 'create_cities',        'display_name' => 'Create Cities',       'route' => 'cities.create',         'module' => 'cities', 'as' => 'cities.create',      'icon' => null,                  'parent' => $manageCities->id, 'parent_show' => $manageCities->id, 'parent_original' => $manageCities->id,'sidebar_link' => '1', 'appear' => '0', ]);
            $displayCities = Permission::create([ 'name' => 'display_cities',       'display_name' => 'Display Cities',      'route' => 'cities.show',           'module' => 'cities', 'as' => 'cities.show',        'icon' => null,                  'parent' => $manageCities->id, 'parent_show' => $manageCities->id, 'parent_original' => $manageCities->id,'sidebar_link' => '1', 'appear' => '0', ]);
            $updateCities  = Permission::create([ 'name' => 'update_cities',        'display_name' => 'Update Cities',       'route' => 'cities.edit',           'module' => 'cities', 'as' => 'cities.edit',        'icon' => null,                  'parent' => $manageCities->id, 'parent_show' => $manageCities->id, 'parent_original' => $manageCities->id,'sidebar_link' => '1', 'appear' => '0', ]);
            $destroyCities = Permission::create([ 'name' => 'delete_cities',        'display_name' => 'Delete Cities',       'route' => 'cities.destroy',        'module' => 'cities', 'as' => 'cities.destroy',     'icon' => null,                  'parent' => $manageCities->id, 'parent_show' => $manageCities->id, 'parent_original' => $manageCities->id,'sidebar_link' => '1', 'appear' => '0', ]);

        //Shipping Companies
        $manageShippingCompanies = Permission::create([ 'name' => 'manage_shipping_companies', 'display_name' => 'Shipping Companies', 'route' => 'shipping_companies', 'module' => 'shipping_companies', 'as' => 'shipping_companies.index', 'icon' => 'fas fa-truck', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '65', ]);
        $manageShippingCompanies->parent_show = $manageShippingCompanies->id;
        $manageShippingCompanies->save();
        $showShippingCompanies    = Permission::create([ 'name' => 'show_shipping_companies',          'display_name' => 'All Shipping Companies',          'route' => 'shipping_companies.index',          'module' => 'shipping_companies', 'as' => 'shipping_companies.index',       'icon' => 'fas fa-truck',          'parent' => $manageShippingCompanies->id, 'parent_show' => $manageShippingCompanies->id, 'parent_original' => $manageShippingCompanies->id,'sidebar_link' => '1', 'appear' => '1', ]);
        $createShippingCompanies  = Permission::create([ 'name' => 'create_shipping_companies',        'display_name' => 'Create Shipping Companies',       'route' => 'shipping_companies.create',         'module' => 'shipping_companies', 'as' => 'shipping_companies.create',      'icon' => null,                    'parent' => $manageShippingCompanies->id, 'parent_show' => $manageShippingCompanies->id, 'parent_original' => $manageShippingCompanies->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $displayShippingCompanies = Permission::create([ 'name' => 'display_shipping_companies',       'display_name' => 'Display Shipping Companies',      'route' => 'shipping_companies.show',           'module' => 'shipping_companies', 'as' => 'shipping_companies.show',        'icon' => null,                    'parent' => $manageShippingCompanies->id, 'parent_show' => $manageShippingCompanies->id, 'parent_original' => $manageShippingCompanies->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $updateShippingCompanies  = Permission::create([ 'name' => 'update_shipping_companies',        'display_name' => 'Update Shipping Companies',       'route' => 'shipping_companies.edit',           'module' => 'shipping_companies', 'as' => 'shipping_companies.edit',        'icon' => null,                    'parent' => $manageShippingCompanies->id, 'parent_show' => $manageShippingCompanies->id, 'parent_original' => $manageShippingCompanies->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $destroyShippingCompanies = Permission::create([ 'name' => 'delete_shipping_companies',        'display_name' => 'Delete Shipping Companies',       'route' => 'shipping_companies.destroy',        'module' => 'shipping_companies', 'as' => 'shipping_companies.destroy',     'icon' => null,                    'parent' => $manageShippingCompanies->id, 'parent_show' => $manageShippingCompanies->id, 'parent_original' => $manageShippingCompanies->id,'sidebar_link' => '1', 'appear' => '0', ]);

        // PAYMENT METHODS
        $managePaymentMethods   = Permission::create([ 'name' => 'manage_payment_methods',  'display_name' => 'Payment Methods',        'route' => 'payment_methods', 'module' => 'payment_methods', 'as' => 'payment_methods.index', 'icon' => 'fas fa-dollar-sign', 'parent' => '0', 'parent_original' => '0', 'appear' => '1', 'ordering' => '70', ]);
        $managePaymentMethods->parent_show = $managePaymentMethods->id; $managePaymentMethods->save();
        $showPaymentMethods     = Permission::create([ 'name' => 'show_payment_methods',    'display_name' => 'Payment Methods',        'route' => 'payment_methods',                       'module' => 'payment_methods', 'as' => 'payment_methods.index', 'icon' => 'fas fa-dollar-sign', 'parent' => $managePaymentMethods->id, 'parent_show' => $managePaymentMethods->id, 'parent_original' => $managePaymentMethods->id, 'appear' => '1', 'ordering' => '0', ]);
        $createPaymentMethods   = Permission::create([ 'name' => 'create_payment_methods',  'display_name' => 'Create Payment Method',  'route' => 'payment_methods/create',                'module' => 'payment_methods', 'as' => 'payment_methods.create','icon' => null, 'parent' => $managePaymentMethods->id, 'parent_show' => $managePaymentMethods->id, 'parent_original' => $managePaymentMethods->id, 'appear' => '0', 'ordering' => '0',]);
        $displayPaymentMethods  = Permission::create([ 'name' => 'display_payment_methods', 'display_name' => 'Show Payment Method',    'route' => 'payment_methods/{payment_methods}',     'module' => 'payment_methods', 'as' => 'payment_methods.show',  'icon' => null, 'parent' => $managePaymentMethods->id, 'parent_show' => $managePaymentMethods->id, 'parent_original' => $managePaymentMethods->id, 'appear' => '0', 'ordering' => '0',]);
        $updatePaymentMethods   = Permission::create([ 'name' => 'update_payment_methods',  'display_name' => 'Update Payment Method',  'route' => 'payment_methods/{payment_methods}/edit','module' => 'payment_methods', 'as' => 'payment_methods.edit',  'icon' => null, 'parent' => $managePaymentMethods->id, 'parent_show' => $managePaymentMethods->id, 'parent_original' => $managePaymentMethods->id, 'appear' => '0', 'ordering' => '0', ]);
        $destroyPaymentMethods  = Permission::create([ 'name' => 'delete_payment_methods',  'display_name' => 'Delete Payment Method',  'route' => 'payment_methods/{payment_methods}',     'module' => 'payment_methods', 'as' => 'payment_methods.delete','icon' => null, 'parent' => $managePaymentMethods->id, 'parent_show' => $managePaymentMethods->id, 'parent_original' => $managePaymentMethods->id, 'appear' => '0', 'ordering' => '0', ]);


        //Admins
        $manageAdmins = Permission::create([ 'name' => 'manage_admins', 'display_name' => 'Admins', 'route' => 'admins', 'module' => 'admins', 'as' => 'admins.index', 'icon' => 'fas fa-user-shield', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '0', 'appear' => '1', 'ordering' => '200', ]);
        $manageAdmins->parent_show = $manageAdmins->id;
        $manageAdmins->save();
        $showAdmins    = Permission::create([ 'name' => 'show_admins',          'display_name' => 'Show All Admins',     'route' => 'admins.index',          'module' => 'admins', 'as' => 'admins.index',       'icon' => 'fas fa-user-shield',  'parent' => $manageAdmins->id, 'parent_show' => $manageAdmins->id, 'parent_original' => $manageAdmins->id,'sidebar_link' => '1', 'appear' => '1', ]);
        $createAdmins  = Permission::create([ 'name' => 'create_admins',        'display_name' => 'Create Admins',       'route' => 'admins.create',         'module' => 'admins', 'as' => 'admins.create',      'icon' => null,                  'parent' => $manageAdmins->id, 'parent_show' => $manageAdmins->id, 'parent_original' => $manageAdmins->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $displayAdmins = Permission::create([ 'name' => 'display_admins',       'display_name' => 'Display Admins',      'route' => 'admins.show',           'module' => 'admins', 'as' => 'admins.show',        'icon' => null,                  'parent' => $manageAdmins->id, 'parent_show' => $manageAdmins->id, 'parent_original' => $manageAdmins->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $updateAdmins  = Permission::create([ 'name' => 'update_admins',        'display_name' => 'Update Admins',       'route' => 'admins.edit',           'module' => 'admins', 'as' => 'admins.edit',        'icon' => null,                  'parent' => $manageAdmins->id, 'parent_show' => $manageAdmins->id, 'parent_original' => $manageAdmins->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $destroyAdmins = Permission::create([ 'name' => 'delete_admins',        'display_name' => 'Delete Admins',       'route' => 'admins.destroy',        'module' => 'admins', 'as' => 'admins.destroy',     'icon' => null,                  'parent' => $manageAdmins->id, 'parent_show' => $manageAdmins->id, 'parent_original' => $manageAdmins->id,'sidebar_link' => '1', 'appear' => '0', ]);
        // $frontAdmins   = Permission::create([ 'name' => 'frontDisplay_admins',  'display_name' => 'Front Display Admins','route' => 'admins.frontDisplay',   'module' => 'admins', 'as' => 'admins.frontDisplay','icon' => null,                  'parent' => $manageAdmins->id, 'parent_show' => $manageAdmins->id, 'parent_original' => $manageAdmins->id,'sidebar_link' => '1', 'appear' => '0', ]);

        //Users
        $manageUsers = Permission::create([ 'name' => 'manage_users', 'display_name' => 'Users', 'route' => 'admins', 'module' => 'users', 'as' => 'users.index', 'icon' => 'fas fa-users', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '0', 'appear' => '1', 'ordering' => '210', ]);
        $manageUsers->parent_show = $manageUsers->id;
        $manageUsers->save();
        $showUsers    = Permission::create([ 'name' => 'show_users',          'display_name' => 'Show All Users',     'route' => 'users.index',          'module' => 'users', 'as' => 'users.index',       'icon' => 'fas fa-users','parent' => $manageUsers->id, 'parent_show' => $manageUsers->id, 'parent_original' => $manageUsers->id,'sidebar_link' => '1', 'appear' => '1', ]);
        $createUsers  = Permission::create([ 'name' => 'create_users',        'display_name' => 'Create Users',       'route' => 'users.create',         'module' => 'users', 'as' => 'users.create',      'icon' => null,                  'parent' => $manageUsers->id, 'parent_show' => $manageUsers->id, 'parent_original' => $manageUsers->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $displayUsers = Permission::create([ 'name' => 'display_users',       'display_name' => 'Display Users',      'route' => 'users.show',           'module' => 'users', 'as' => 'users.show',        'icon' => null,                  'parent' => $manageUsers->id, 'parent_show' => $manageUsers->id, 'parent_original' => $manageUsers->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $updateUsers  = Permission::create([ 'name' => 'update_users',        'display_name' => 'Update Users',       'route' => 'users.edit',           'module' => 'users', 'as' => 'users.edit',        'icon' => null,                  'parent' => $manageUsers->id, 'parent_show' => $manageUsers->id, 'parent_original' => $manageUsers->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $destroyUsers = Permission::create([ 'name' => 'delete_users',        'display_name' => 'Delete Users',       'route' => 'users.destroy',        'module' => 'users', 'as' => 'users.destroy',     'icon' => null,                  'parent' => $manageUsers->id, 'parent_show' => $manageUsers->id, 'parent_original' => $manageUsers->id,'sidebar_link' => '1', 'appear' => '0', ]);
        // $frontUsers   = Permission::create([ 'name' => 'frontDisplay_users',  'display_name' => 'Front Display Users','route' => 'users.frontDisplay',   'module' => 'users', 'as' => 'users.frontDisplay','icon' => null,                  'parent' => $manageUsers->id, 'parent_show' => $manageUsers->id, 'parent_original' => $manageUsers->id,'sidebar_link' => '1', 'appear' => '0', ]);




























    }
}
