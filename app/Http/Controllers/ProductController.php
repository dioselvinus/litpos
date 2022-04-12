<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (empty($request->all())) {
            return response()->json(Product::latest()->get());
        } else if (!empty($request->query('search')) || is_int($request->query('size')) >= 0 && is_int($request->query('page')) >= 0) {
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
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // save to storage laravel
            $photo = $request->file('photo');
            $path = Storage::putFileAs(
                'images/products', $photo, $photo->hashName()
            );
        } else if ($request->photo) {
            $path = $request->photo;
        }

        $product = Product::create([
            'id' => Uuid::uuid5(Uuid::NAMESPACE_DNS, $request['name']),
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'status' => $request->status,
            'image' => $path,
        ]);

        return redirect()->route('product');
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
    public function update(Request $request, Product $product)
    {
        if ($request->hasFile('photo')) {
            // save to storage laravel
            Storage::delete($product->image);
            $photo = $request->file('photo');
            $path = Storage::putFileAs(
                'images/products', $request->file('photo'), $photo->hashName()
            );
            $product->image = $path;
        } else if ($request->photo) {
            Storage::delete($product->image);
            $product->image = $request->photo;
        }
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category = Str::lower($request->category);
        $product->status = Str::lower($request->status);
        $product->save();
        return redirect()->route('product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
    }
}
