<?php


class Item_Cart extends Database
{
    public $id;
    public $item_id;
    public $cart_id;
    public $item_qty;

    public function create()
    {
        $sql = "INSERT INTO `item_cart` (`item_id`, `cart_id`, `item_qty`) VALUES($this->item_id, $this->cart_id, $this->item_qty)";

        if($this->connect()->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
}