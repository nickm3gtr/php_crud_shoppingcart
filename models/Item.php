<?php


class Item extends Database
{
    private $table = 'item';

    private $item_name;
    private $item_price;


    public function read()
    {
        $sql = "SELECT * FROM $this->table ORDER BY 'id' DESC";
        $result = $this->connect()->query($sql);

        $items = array();

        while ($row = $result->fetch_assoc()) {
            array_push($items, $row);
        }
        return $items;
    }
}