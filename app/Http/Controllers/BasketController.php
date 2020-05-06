<?php

namespace App\Http\Controllers;

use App\Basket;
use App\Product;
use App\product_basket;
use App\User;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(product_basket::where('user_id','=',$request->user()->id)->get());
    }

    public function add(Request $request,Product $product)
    {
        return $this->update($request,$product,1);
    }

    public function update(Request $request,Product $product, int $amount)
    {
        $basket_products = product_basket::where('user_id','=',$request->user()->id)->get();
        $product_basket = FALSE;
        $product_basket;
        if($basket_products->has($product->id))
        {
            $product_basket= $basket_products->get($product->id);
            $product_basket->amount += $amount;
            $product_basket->save();
        }
        else
        {
            $product_basket = product_basket::create([
                'product_id'=>$product->id,
                'user_id'=>$request->user()->id,
                'amount'=>$amount
            ])->save();
        }
        return response()->json([
            'status' => (bool) $product_basket,
            'data'   => $product_basket,
            'message' => $product_basket ? 'Product added to basket!' : 'Error adding Product to basket'
        ]);
    }

    public function delete(Request $request)
    {
        product_basket::where('user_id','=',$request->user()->id)->delete();
        return response()->json([
            'status'    => TRUE,
            'data'      => [],
            'message'   => 'Basket emptied'
        ]);
    }
}
