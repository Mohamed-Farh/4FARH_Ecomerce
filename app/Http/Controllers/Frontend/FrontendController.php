<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class FrontendController extends Controller
{

    public function index()
    {
        $categories  = Category::whereStatus(1)->whereNull('parent_id')->get();

        return view('frontend.index', compact('categories'));
    }

    public function shop($slug = null)
    {
        return view('frontend.shop', compact('slug'));
    }

    public function shop_tag($slug = null)
    {
        return view('frontend.shop_tag', compact('slug'));
    }

    public function product($slug)
    {
        $product = Product::with('media', 'category', 'tags', 'reviews')
                            ->with('reviews')
                            ->whereSlug($slug)
                            ->Active()
                            ->HasQuantity()
                            ->ActiveCategory()
                            ->firstOrFail();

        $reviews_avg_ratings = ProductReview::where('product_id', $product->id)->pluck('rating')->avg();

        $relatedProducts = Product::with('firstMedia')->whereHas('category', function ($query) use ($product) {
            $query->whereId($product->category_id);
            $query->whereStatus(true);
        })->inRandomOrder()->Active()->HasQuantity()->take(4)->get();
        return view('frontend.product', compact('product', 'relatedProducts', 'reviews_avg_ratings'));
    }


    public function cart()
    {
        return view('frontend.cart');
    }

    public function wishlist()
    {
        return view('frontend.wishlist');
    }

    public function checkout()
    {
        return view('frontend.checkout');
    }


}
