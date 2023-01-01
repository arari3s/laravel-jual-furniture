<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Product::query()->orderBy('updated_at', 'desc');

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a class="inline-block bg-indigo-500 text-white rounded-md px-4 py-1 m-1 font-semibold transition duration-500 ease select-none hover:bg-indigo-700 focus:outline-none focus:shadow-outline" href="' . route('dashboard.product.gallery.index', $item->id) .
                        '">
                            Gallery
                        </a>

                        <a class="inline-block bg-sky-500 text-white rounded-md px-4 py-1 m-1 font-semibold transition duration-500 ease select-none hover:bg-sky-700 focus:outline-none focus:shadow-outline" href="' . route('dashboard.product.edit', $item->id) .
                        '">
                            Edit
                        </a>

                        <form class="inline-block" action="' .
                        route('dashboard.product.destroy', $item->id) .
                        '" method="POST">
                            <button class="border bg-red-500 text-white rounded-md px-2 py-1 m-1 font-semibold transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline" >
                                Delete
                            </button>
                            ' .
                        method_field('delete') .
                        csrf_field() .
                        '
                        </form>
                    ';
                })
                ->editColumn('price', function ($item) {
                    return number_format($item->price);
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.dashboard.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        Product::create($data);

        return redirect()->route('dashboard.product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('pages.dashboard.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $product->update($data);

        return redirect()->route('dashboard.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('dashboard.product.index');
    }
}
