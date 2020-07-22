<?php

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once "../../../config/Database.php";
include_once "../../../models/Item_Cart.php";

$item_cart = new Item_Cart();

$item_cart->item_id = (int)$_POST['item_id'];
$item_cart->cart_id = (int)$_POST['cart_id'];
$item_cart->item_qty = (int)$_POST['item_qty'];

$res = array();

if($item_cart->create()) {
    $res['error'] = false;
    $res['message'] = "Item_Cart added successfully";
} else {
    $res['error']   = true;
    $res['message'] = "Item_Cart insert failed!";
}



echo json_encode($res);
