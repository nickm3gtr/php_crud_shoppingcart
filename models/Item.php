<?php


class Item extends Database
{
    public $id;
    public $item_name;
    public $item_price;

    private $connect;

    public function __construct()
    {
        $this->connect = parent::__construct();
    }

    public function read()
    {
        $sql = "SELECT * FROM `item` ORDER BY `id` DESC";
        $result = $this->connect->query($sql);

        $items = array();

        while ($row = $result->fetch_assoc()) {
            array_push($items, $row);
        }
        return $items;
    }

    public function create()
    {
        $this->item_name = htmlspecialchars(strip_tags($this->item_name));
        $this->item_price = htmlspecialchars(strip_tags($this->item_price));

        $sql = "INSERT INTO `item` (`item_name`, `item_price`) VALUES('$this->item_name', $this->item_price)";
        if($this->connect->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete()
    {
        $sql = "DELETE FROM `item` WHERE `id`='$this->id'";
        if($this->connect->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function update()
    {
        $this->item_name = htmlspecialchars(strip_tags($this->item_name));
        $this->item_price = htmlspecialchars(strip_tags($this->item_price));

        $sql = "UPDATE `item` SET `item_name`='$this->item_name', `item_price`=$this->item_price WHERE `id`=$this->id";
        if($this->connect->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
}