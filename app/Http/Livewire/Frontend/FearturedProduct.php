<?php

namespace App\Http\Livewire\Frontend;
use Gloudemans\Shoppingcart\Facades\Cart;

use App\Models\Product;
use Livewire\Component;

class FearturedProduct extends Component
{
    public function render()
    {
        return view('livewire.frontend.feartured-product', [
            'featuredProducts'  => Product::with('firstMedia')
                                        ->inRandomOrder()->Featured()->Active()
                                        ->HasQuantity()->ActiveCategory()
                                        ->take(8)->get()
        ]);
    }

    public function addToCart($id)
    {
        $product = Product::whereId($id)->Active()->HasQuantity()->ActiveCategory()->firstOrFail();

        $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id === $product->id;
        });

        if ($duplicates->isNotEmpty()) {
            $this->alert('error', 'Product Already Exist!');
        } else {
            Cart::instance('default')->add($product->id, $product->name, 1, $product->price)->associate(Product::class);
            $this->emit('updateCart');
            $this->alert('success', 'Product Added In Your Cart Successfully.');
        }
    }

    public function addToWishList($id)
    {
        $product = Product::whereId($id)->Active()->HasQuantity()->ActiveCategory()->firstOrFail();
        $duplicates = Cart::instance('wishlist')->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id === $product->id;
        });
        if ($duplicates->isNotEmpty()) {
            $this->alert('error', 'Product Already Exist!');
        } else {
            Cart::instance('wishlist')->add($product->id, $product->name, 1, $product->price)->associate(Product::class);
            $this->emit('updateCart');
            $this->alert('success', 'Product Added In Your Wishlist Cart Successfully.');
        }
    }

}
