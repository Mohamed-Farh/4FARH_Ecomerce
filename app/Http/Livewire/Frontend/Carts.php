<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class Carts extends Component
{
    public $cartCount;
    public $wishlistCount;

    //القيم دي هيجيبها من FeatureProduct
    //مستخدم حاجه هناك اسمها emit دي كأن بقوله لو العمليه نجحت اعمل كذا
    // و اجي هنا اسمها استخدمع في listeners
    protected $listeners = [
        'updateCart'        => 'update_cart',
        'removeFromCart'    => 'remove_from_cart',
        'removeFromWishList'=> 'remove_from_wish_list',
        'moveToCart'        => 'move_to_cart',
    ];

    public function mount()
    {
        $this->cartCount        = Cart::instance('default')->count();
        $this->wishlistCount    = Cart::instance('wishlist')->count();
    }

    public function update_cart()
    {
        $this->cartCount = Cart::instance('default')->count();
        $this->wishlistCount = Cart::instance('wishlist')->count();
    }

    public function remove_from_cart($rowId)
    {
        Cart::instance('default')->remove($rowId);
        $this->emit('updateCart');
        $this->alert('success', 'Item Removed From Your Cart!');
        if (Cart::instance('default')->count() == 0){
            return redirect()->route('frontend.cart');
        }
    }

    public function remove_from_wish_list($rowId)
    {
        Cart::instance('wishlist')->remove($rowId);
        $this->emit('updateCart');
        $this->alert('success', 'Item Removed From Your Wish List!');
        if (Cart::instance('wishlist')->count() == 0){
            return redirect()->route('frontend.wishlist');
        }
    }

    public function move_to_cart($rowId)
    {
        $item = Cart::instance('wishlist')->get($rowId);
        $duplicate = Cart::instance('default')->search(function ($cartItem, $rId) use ($rowId) {
            return $rId === $rowId;
        });

        if ($duplicate->isNotEmpty()) {
            Cart::instance('wishlist')->remove($rowId);
            $this->alert('error', 'Product Already Exist.');
        } else {
            Cart::instance('default')->add($item->id, $item->name, 1, $item->price)->associate(Product::class);
            Cart::instance('wishlist')->remove($rowId);
            $this->alert('success', 'Product Added In Your Cart Successfully.');
        }

        $this->emit('updateCart');

        if (Cart::instance('wishlist')->count() == 0){
            return redirect()->route('frontend.wishlist');
        }

    }

    public function render()
    {
        return view('livewire.frontend.carts');
    }
}