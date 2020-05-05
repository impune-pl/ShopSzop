<?php

namespace App;

class Basket
{
    private array $products;

    public function __construct()
    {
        $this->products = array();
    }

    /*
     * If product is not already in basket, add it with count of 1, else increment its count
     */
    public function addProduct(Product $product)
    {
        $key = array_search($product, $this->products, TRUE);
        if($key === FALSE)
        {
            array_push($this->products, [0 => $product, 1 => 1]);
        }
        else
        {
            $this->products[$key][1]++;
        }
    }

    /*
     * if product is in basket, remove it, else do nothing
     */
    public function removeProduct(Product $product)
    {
        $key = array_search($product, $this->products, TRUE);
        if($key)
        {
            array_splice($this->products, $key, 1);
        }
    }

    /*
     * if product is in basket,
     */
    public function changeProductCount(Product $product, int $count)
    {
        $key = array_search($product, $this->products, TRUE);
        if($key === FALSE)
        {
            array_push($this->products, [0 => $product, 1 => $count]);
        }
        else
        {
            if($count !== 0)
                $this->products[$key][1]=$count;
            else
                $this->removeProduct($product);
        }
    }

    public function toProductOrderArray(Order $order)
    {
        $productOrders = array();
        foreach ($this->products as $product)
        {
            array_push($productOrders,
                new Product_Order([
                    'product_id'=>$product[0],
                    'order_id'=>$order->id,
                    'amount'=>$product[1]
                ]));
        }
        return $productOrders;
    }

    public function checkAvailability(callable $callback)
    {
        foreach ($this->products as $item)
        {
            $callback($item[0], $item[1]);
        }
    }
}
