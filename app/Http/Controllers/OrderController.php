<?php

namespace App\Http\Controllers;

use App\Basket;
use App\Order;
use App\Shipping_address;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->user()->id;
        return response()->json(Order::with(['product'])->where('user_id', $id)->get(),200);
    }

    public function deliverOrder(Order $order)
    {
        $order->is_delivered = true;
        $status = $order->save();

        return response()->json([
            'status'    => $status,
            'data'      => $order,
            'message'   => $status ? 'Order delivered' : 'Error delivering order'
        ]);
    }

    public function place(Request $request)
    {
        $basket = $request->session()->get('basket');
        $errors = array();
        if($basket != NULL)
        {
            $basket->checkAvailability( function($product, $quantity) use ($errors) {
                if($product->refresh()->stock >= $quantity) {
                    $product->stock -= $quantity;
                    $product->save();
                }
                else
                {
                    array_push($errors,[$product,'Not enough units in stock']);
                }
            });

            if(count($errors)>0)
            {
                return response()->json([
                    'status' => FALSE,
                    'data'   => $errors,
                    'message' => 'Error placing order'
                ]);
            }

            $order = Order::create([
                'user_id'=>Auth::id(),
                'shipping_address_id'=>$request->address,
                // not implemented 'payment_id' => ,
                //default from database 'order_date' =>
                'is_delivered' => FALSE,
            ]);
            $order->products()->saveMany($basket->toProductOrderArray($order));
            $order->save();

            return response()->json([
                'status' => (bool) $order,
                'data'   => $order,
                'message' => $order ? 'Order placed' : 'Error placing order'
            ]);
        }
        return response()->json([
            'status' => FALSE,
            'data'   => '',
            'message' => 'Error placing order - basket does not exist or is empty'
        ]);
    }

    public function show(Order $order, Request $request)
    {
        if($request->user()->id === $order->user()->id)
            return response()->json($order,200);
        else
            return response()->json(['error'=>'Acess forbidden'],403);
    }
}
