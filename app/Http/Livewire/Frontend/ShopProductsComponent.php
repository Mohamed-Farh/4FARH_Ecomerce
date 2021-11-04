<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Product;
use App\Models\Category;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Livewire\WithPagination;

class ShopProductsComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginationLimit = 12;  //علشان يعرض 12 منتج في كل صفحة
    public $slug;   //علشان استخدمها في اللينك
    public $sortingBy = 'default';

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

    public function render()
    {
        // دي علشان عملية الترتيب او الفلترة في صفحة عرض المنتجات
        switch ($this->sortingBy) {
            case 'popularity':
                $sort_field = 'id';
                $sort_type = 'asc';
                break;
            case 'low-high':
                $sort_field = 'price';
                $sort_type = 'asc';
                break;
            case 'high-low':
                $sort_field = 'price';
                $sort_type = 'desc';
                break;
            default:
                $sort_field = 'id';
                $sort_type = 'asc';
        }

        $products = Product::with('firstMedia');

        if ($this->slug == '') {
            $products = $products->ActiveCategory();
        } else {
            $category = Category::whereSlug($this->slug)->whereStatus(true)->first();

            if (is_null($category->parent_id)) {
                //هات كل الكاتيجرس اللي تحتها
                $categoriesIds = Category::whereParentId($category->id)
                    ->whereStatus(true)->pluck('id')->toArray();

                $products = $products->whereHas('category', function ($query) use ($categoriesIds) {
                    $query->whereIn('id', $categoriesIds);
                });

            } else {

                $products = $products->with('category')->whereHas('category', function ($query) {
                    $query->where([
                        'slug'      => $this->slug,
                        'status'    => true
                    ]);
                });

            }
        }

        $products = $products->Active()
            ->HasQuantity()
            ->orderBy($sort_field, $sort_type)
            ->paginate($this->paginationLimit);

        return view('livewire.frontend.shop-products-component', [
            'products' => $products
        ]);
    }

}
