<?php

namespace App\Http\Controllers;

use App\Basket;
use App\Product;
use App\product_basket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function foo\func;

class BasketController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(product_basket::with('product')->where('user_id','=',$request->user()->id)->get());
    }

    public function add(Request $request,Product $product)
    {
        $basket_product='';
        $basket_product = DB::transaction(
            function () use ($request,$product)
            {
                while(TRUE) {
                    $basket_product = product_basket::firstOrCreate([
                        'user_id' => $request->user()->id,
                        'product_id' => $product->id
                    ]);
                    $version=-1;
                    if($basket_product->wasRecentlyCreated)
                    {
                        $basket_product->save();
                        return $basket_product;
                    }
                    else
                        $version = $basket_product->version;
                    $basket_product->amount += 1;
                    if ($version === product_basket::where('id', '=', $basket_product->id)->first()->version) {
                        $basket_product->version += 1;
                        $basket_product->save();
                        return $basket_product;
                    } else {
                        sleep(1);
                        continue;
                    }
                }
            }
        );
        return response()->json([
            'status' => (bool) $basket_product,
            'data'   => $basket_product,
            'message' => $basket_product ? 'Product added to basket!' : 'Error adding product to basket'
        ]);
    }

    public function update(Request $request,int $id, int $amount)
    {
        $basket_product='';
        DB::transaction(
            function () use ($request,$id,$amount, $basket_product)
            {
                while(TRUE) {$basket_product;
                    if($amount <= 0)
                    {
                        $this->remove($request,$id);
                        $basket_product = TRUE;
                        return;
                    }
                    $basket_product = product_basket::firstWhere([
                        'user_id' => $request->user()->id,
                        'id' => $id
                    ]);
                    $version = $basket_product->version;
                    $basket_product->amount = $amount;
                    if ($version === product_basket::where('id', '=', $basket_product->id)->first()->version) {
                        $basket_product->version += 1;
                        $basket_product->save();
                        return;
                    } else {
                        sleep(1);
                    }
                }
            }
        );
        return response()->json([
            'status' => (bool) $basket_product,
            'data'   => $basket_product,
            'message' => $basket_product ? 'Product quantity changed in basket!' : 'Error no such product in the basket or quantity too low '
        ]);
    }

    public function remove(Request $request, int $id)
    {
        $product_basket = product_basket::where('user_id','=',$request->user()->id)->where('id','=',$id)->delete();
        return response()->json([
            'status' => (bool) $product_basket,
            'data'   => $product_basket,
            'message' => $product_basket ? 'Product removed from basket!' : 'Error no such product in the basket'
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
