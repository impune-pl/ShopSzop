<?php

namespace App\Http\Controllers;

use App\Basket;
use App\Order;
use App\Product;
use App\product_basket;
use App\Product_Order;
use App\Shipping_address;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->user()->id;
        return response()->json(Order::with(['products','products.product'])->where('user_id','=', $id)->get(),200);
    }

    public function indexAll(Request $request)
    {
        return response()->json(Order::with(['products','products.product'])->get(),200);
    }

    public function payOrder(int $id)
    {
        $order = Order::where('id','=',$id)->first();
        $order->payment_id=1;
        $status = $order->save();

        return response()->json([
            'status'    => $status,
            'data'      => $order,
            'message'   => $status ? 'Order delivered' : 'Error delivering order'
        ]);
    }

    public function deliverOrder(int $id)
    {
        $order = Order::where('id','=',$id)->first();
        $order->is_delivered=TRUE;
        $status = $order->save();

        return response()->json([
            'status'    => $status,
            'data'      => $order,
            'message'   => $status ? 'Order delivered' : 'Error delivering order'
        ]);
    }

    public function place(Request $request)
    {
        $shipping_address = Shipping_address::firstOrCreate([
            'first_line' => $request->post()['shipping_address']['first_line'],
            'second_line' => $request->post()['shipping_address']['second_line'],
            'postal_code'=> $request->post()['shipping_address']['postal_code'],
            'city'=> $request->post()['shipping_address']['city'],
            'country'=> $request->post()['shipping_address']['country']
        ]);
        $shipping_address->refresh();
        $order = Order::create([
            'user_id'=>Auth::id(),
            'shipping_address_id'=>$shipping_address->id,
            'payment_id' => 0,
            'is_delivered' => FALSE,
        ]);
        $order->refresh();
        $products_to_order = product_basket::where('user_id','=',$request->user()->id)->get();
        $error_not_in_stock = FALSE;
        $ordered_products = array();
        foreach ($products_to_order as $product_to_order)
        {
            array_push($ordered_products, Product_Order::create([
                'product_id'=>$product_to_order->product_id,
                'amount'=>$product_to_order->amount,
                'order_id'=>$order->id
            ]));
            $product = Product::where('id','=',$product_to_order->product_id)->first();
            if($product->stock < $product_to_order->amount)
            {
                $error_not_in_stock = "Error, not enough ".$product->name." in warehouse. Please try again later";
            }
        }
        $order->save();
        if($error_not_in_stock != FALSE)
        {
            $order->delete();
            foreach ($ordered_products as $op)
            {
                $op->delete();
            }
            return response()->json([
                'status' => FALSE,
                'data'   => $order,
                'message' => $error_not_in_stock
            ]);
        }
        product_basket::where('user_id','=',$request->user()->id)->delete();
        return response()->json([
            'status' => (bool) $order,
            'data'   => $order,
            'message' => $order ? 'Order placed' : 'Error placing order'
        ]);
    }

    public function show(Order $order, Request $request)
    {
        if($request->user()->id === $order->user_id)
            return response()->json($order,200);
        else
            return response()->json(['error'=>'Acess forbidden'],403);
    }
}
