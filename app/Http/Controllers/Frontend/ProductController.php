<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Review;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $categories = Category::all();
        $min_price = 0;
        $max_price = Product::max('price');

        $products = Product::with('attributes')->where('status', 1)
            ->keyword($request)
            ->category($request)
            ->price($request)
            ->orderBy('id', 'desc')
            ->paginate(8);

        return view('frontend.product', compact(
            'user',
            'products',
            'categories',
            'min_price',
            'max_price',
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product = Product::findBySlug($product->slug);

        $relatedProducts = Product::where([
            ['category_id', $product->category_id],
            ['id', '!=', $product->id],
        ])
            ->orderBy('name', 'desc')
            ->select('id', 'name', 'slug', 'price', 'sale_price', 'image')
            ->take(10)->get();

        $productAttributes = $product->attributes;

        if ($productAttributes->isNotEmpty()) {
            $product->price = $productAttributes->first()->price;
            $product->sale_price = $productAttributes->first()->sale_price;
        }

        $latest_blog = Blog::orderBy('updated_at', 'desc')->paginate(6);

        $categories = Category::all();

        $user = auth()->user();

        if ($user) {
            $user->avatar = $user->avatar ? $user->avatar : 'assets/img/user2-160x160.jpg';
        }

        // dd($product->id);

        $reviews = Review::where([
            ['product_id', $product->id]
        ])->get();

        // dd($reviews);

        return view('frontend.product_detail', compact(
            'user',
            'product',
            'productAttributes',
            'relatedProducts',
            'latest_blog',
            'categories',
            'reviews',
        ));
    }

    public function quantity(ProductAttribute $productAttribute)
    {
        // dd($productAttribute);
        try {
            return response()->json([
                'success' => true,
                'msg' => 'L???y th??ng tin thu???c t??nh s???n ph???m th??nh c??ng',
                'quantity' => $productAttribute->quantity,
                'price' => $productAttribute->price,
                'sale_price' => $productAttribute->sale_price,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'C?? l???i x???y ra, vui l??ng th??? l???i',
            ]);
        }
    }
}
