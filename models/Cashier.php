<?php


class Cashier extends Database
{
    public $id;
    public $cashier_name;


    public function read()
    {
        $sql = "SELECT * FROM `cashier` ORDER BY `id` DESC";
        $result = $this->connect()->query($sql);

        $cashiers = array();

        while ($row = $result->fetch_assoc()) {
            array_push($cashiers, $row);
        }
        return $cashiers;
    }

    public function create()
    {
        $this->cashier_name = htmlspecialchars(strip_tags($this->cashier_name));

        $sql = "INSERT INTO `cashier` (`cashier_name`) VALUES('$this->cashier_name')";
        if($this->connect()->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function update()
    {
        $this->cashier_name = htmlspecialchars(strip_tags($this->cashier_name));

        $sql = "UPDATE `cashier` SET `cashier_name`='$this->cashier_name' WHERE `id`=$this->id";
        if($this->connect()->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
}