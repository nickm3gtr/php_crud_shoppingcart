<?php


class Transaction extends Database
{
    public $cart_id;

    public function read()
    {
        $sql = "SELECT `cart`.`id`, `cashier`.`cashier_name`, `cart`.`date_time` FROM `cashier` INNER JOIN `cart` ON `cashier`.`id`=`cart`.`cashier_id` ORDER BY `cart`.`id` DESC";

        $result = $this->connect()->query($sql);

        $transactions = array();

        while ($row = $result->fetch_assoc()) {
            array_push($transactions, $row);
        }
        return $transactions;
    }

    public function show()
    {
        $sql = "SELECT `cart`.`id`, `cashier`. `cashier_name`, `cart`.`date_time`, `item`.`item_name`, `item`.`item_price`, `item_cart`.`item_qty`
              FROM `cashier` RIGHT JOIN `cart` ON `cashier`.`id`=`cart`.`cashier_id` 
                RIGHT JOIN `item_cart` ON `cart`.`id`=`item_cart`.`cart_id`
                LEFT JOIN `item` ON `item_cart`.`item_id`=`item`.`id`
              WHERE `cart`.`id` = $this->cart_id";

        $transactions = array();
        $result = $this->connect()->query($sql);

        while ($row = $result->fetch_assoc()) {
            array_push($transactions, $row);
        }
        return $transactions;
    }

}