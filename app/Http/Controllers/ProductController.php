<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all(),200);
    }

    public function indexCategories()
    {
        return response()->json(Category::all(),200);
    }

    public function store(Request $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'stock' => $request->stock,
            'price' => $request->price,
            'image_path' => $request->image_path,
            'category_id0' => $request->category_id
        ]);

        return response()->json([
            'status' => (bool) $product,
            'data'   => $product,
            'message' => $product ? 'Product Created!' : 'Error Creating Product'
        ]);
    }

    public function show(Product $product)
    {
        return response()->json($product,200);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $product = Product::where('id','=',$id)->first();

        $status = $product->update(
            $request->only(['name', 'description', 'stock', 'price', 'image','category_id'])
        );

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Product Updated!' : 'Error Updating Product'
        ]);
    }

    public function create(Request $request)
    {
        $status = Product::create([
            'name' => $request->post()['name'],
            'price' => $request->post()['price'],
            'stock' => $request->post()['stock'],
            'description' => $request->post()['description'],
            'image_path' => $request->post()['image_path'],
            'category_id' => $request->post()['category_id']
        ]);

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Product Created!' : 'Error Creating Product'
        ]);
    }

    public function updateStock(Request $request, Product $product)
    {
        $product->units = $product->units + $request->get('units');
        $status = $product->save();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Units Added!' : 'Error Adding Product Units'
        ]);
    }

    public function destroy(int $id)
    {
        $status = $product = Product::where('id','=',$id)->first()->delete();;

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Product Deleted!' : 'Error Deleting Product'
        ]);
    }
}
