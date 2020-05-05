<?php

namespace App\Http\Controllers;

use App\Basket;
use App\Product;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function index(Request $request)
    {

        return response()->json($this->getBasket($request));
    }

    public function add(Request $request,Product $product)
    {
        $basket = $this->getBasket($request);
        $success = TRUE;
        If($product->stock>=1) {
            $basket->addProduct($product);
        }
        else
            $success=FALSE;
        return response()->json([
            'status'=>$success,
            'message' => $success ? 'Item added to basket' : 'Not enough items in stock'
        ]);
    }

    public function update(Request $request,Product $product, int $amount)
    {
        if($amount >= 0 && $amount <= $product->stock) {
            $basket = $this->getBasket($request);
            $basket->changeProductCount($product,$amount);
            return response()->json([
                'status'=>TRUE,
                'message' => 'Changes saved'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>FALSE,
                'message' => 'Incorrect amount'
            ]);
        }
    }

    public function delete(Request $request)
    {
        $request->session()->get('basket');
    }

    private function getBasket($request)
    {
        $basket = $request->session()->get('basket');
        if($basket == NULL)
        {
            $basket = new Basket();
            Session::put('basket', $basket);
        }
        return $basket;
    }
}
