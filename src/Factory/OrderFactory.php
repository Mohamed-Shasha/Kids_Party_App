<?php


namespace App\Factory;


use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Cake;

/**
 * Class OrderFactory
 * @package App\Factory
 */
class OrderFactory
{

    public function create(): Order
    {
        $order = new Order();
        $order
            ->setStatus(Order::STATUS_CART)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        return $order;
    }


    public function createItem(Cake $cake): OrderItem
    {
        $item = new OrderItem();
        $item->setCake($cake);
        $item->setQuantity(1);

        return $item;
    }
}