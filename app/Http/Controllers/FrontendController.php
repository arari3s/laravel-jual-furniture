<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $products = Product::with(['galleries'])->latest()->get();

        return view('pages.frontend.index', compact('products'));
    }

    public function details($slug)
    {
        return view('pages.frontend.details');
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
