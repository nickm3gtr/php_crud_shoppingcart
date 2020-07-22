<?php


class Cart extends Database
{
    public $id;
    public $cashier_id;
    public $date_time;

    private $connect;

    public function __construct()
    {
        $this->connect = parent::__construct();
    }

    public function show()
    {
        $sql = "SELECT `id` FROM `cart` ORDER BY `id` DESC LIMIT 1";
        $result = $this->connect->query($sql);

        $res = array();

        if ($result->num_rows == 0) {
            $res = [1];
        } else {
            $res = $result->fetch_row();
        }

        return $res;
    }

    public function create()
    {
        $sql = "INSERT INTO `cart` (`cashier_id`, `date_time`) VALUES('$this->cashier_id', '$this->date_time')";

        if($this->connect->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
}