<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Product;
use App\Models\ProductReview;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProductModalShared extends Component
{
    public $productModalCount = false;   //علشان تبقي مخفية و اول لما اضغط عليها هتتحول الي true
    public $productModal = [];   //دي علشان اخزن فيه الصور بتاعه البرودكت بعد كده
    public $quantity = 1;  // علشان لما بفتح البرودكت في المودل بظهر رقم واحد

    //مرتبطة بالايفنت اللي بعته من الليفوير فيو
    protected $listeners = ['showProductModalAction'];

    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function increaseQuantity()
    {
        if ($this->productModal->quantity > $this->quantity) {
            $this->quantity++;
        } else {
            $this->alert('warning', 'This Is Maximum Quantity You Can Add !!');
        }
    }

    public function addToCart()
    {
        //علشان ابحث لو هذا المنتج موجود في قايمة مفضلاتي ولا لاء
        $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId) {
            return $cartItem->id === $this->productModal->id;
        });

        if ($duplicates->isNotEmpty()) {
            $this->alert('error', 'Product Already Exist !!');
        } else {
            //هنا هنضيف المعلومات الخاصة بالمنتج
            //في نوعين من الاضافة(default, wishing list)
            Cart::instance('default')->add($this->productModal->id,
                                            $this->productModal->name,
                                            $this->quantity,
                                            $this->productModal->price)
                                    ->associate(Product::class);
            $this->quantity = 1;
            $this->emit('updateCart');
            $this->alert('success', 'Product Added In Your Cart Successfully.');
        }
    }

    public function addToWishList()
    {
        $duplicates = Cart::instance('wishlist')->search(function ($cartItem, $rowId) {
            return $cartItem->id === $this->productModal->id;
        });
        if ($duplicates->isNotEmpty()) {
            $this->alert('error', 'Product Already Exist!');
        } else {
            Cart::instance('wishlist')->add($this->productModal->id, $this->productModal->name, 1, $this->productModal->price)->associate(Product::class);
            $this->emit('updateCart');
            $this->alert('success', 'Product Added In Your Wishlist Cart Successfully.');
        }
    }

    public function showProductModalAction($slug)
    {
        $this->productModalCount = true;
        $this->productModal = Product::with('reviews')
                                    ->whereSlug($slug)
                                    ->Active()
                                    ->HasQuantity()
                                    ->ActiveCategory()
                                    ->firstOrFail();

        $this->reviews_avg_ratings = ProductReview::where('product_id', $this->productModal->id)->pluck('rating')->avg();

        // dd($reviews_avg_ratings);
    }

    public function render()
    {
        return view('livewire.frontend.product-modal-shared');
    }
}
