<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query('search') || $request->query('size') >= 0 && $request->query('page') >= 0) {
            $product = Product::where('name', 'like', '%' . $request->query('search') . '%')->orWhere('category', 'like', '%' . $request->query('search') . '%')->orWhere('status', 'like', $request->query('search') . '%');
            $count = $product->count();
            $productGet = $product->skip($request->query('page') * $request->query('size'))->take($request->query('size'))->get();
            return response()->json(
                [
                    'totalProduct' => $count,
                    'totalPages' => ceil($count / $request->query('size')),
                    'data' => $productGet,
                ]
            );
        } else {
            return response()->json(Product::latest()->get());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */

    public function show(Product $product)
    {
        if (!$product) {
            Log::info('product not found');
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }
        Log::info('get product by id');
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
