<?php

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once "../../../config/Database.php";
include_once "../../../models/Cart.php";

$cart = new Cart();

$cart->cashier_id = (int)$_POST['cashier_id'];
$cart->date_time = date("Y-m-d H:i:s");

$res = array();

if($cart->create()) {
    $res['error'] = false;
    $res['message'] = "Cart added successfully";
} else {
    $res['error']   = true;
    $res['message'] = "Cart insert failed!";
}



echo json_encode($res);