<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once "../../../config/Database.php";
include_once "../../../models/Item.php";

$item = new Item();

$item->item_name = $_POST['item_name'];
$item->item_price = (float)$_POST['item_price'];

$res = array();

if($item->create()) {
    $res['error'] = false;
    $res['message'] = "Item added successfully";
} else {
    $res['error']   = true;
    $res['message'] = "Item insert failed!";
}

echo json_encode($res);