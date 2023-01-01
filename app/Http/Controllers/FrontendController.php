<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function index()
    {
        $products = Product::with(['galleries'])->latest()->get();

        return view('pages.frontend.index', compact('products'));
    }

    public function details($slug)
    {
        $product = Product::with(['galleries'])->where('slug', $slug)->firstOrFail();
        $recommendations = Product::with(['galleries'])->inRandomOrder()->limit(4)->get();

        return view('pages.frontend.details', compact('product', 'recommendations'));
    }

    public function cartAdd($id)
    {

        Cart::create([
            'users_id' => Auth::user()->id,
            'products_id' => $id,
        ]);

        return redirect('cart');
    }

    public function cart()
    {
        return view('pages.frontend.cart');
    }

    public function success()
    {
        return view('pages.frontend.success');
    }
}
