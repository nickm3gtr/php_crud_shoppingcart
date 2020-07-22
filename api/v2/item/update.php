<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once "../../../config/Database.php";
include_once "../../../models/Item.php";

$item = new Item();

$item->id = (int)$_POST['id'];
$item->item_name = $_POST['item_name'];
$item->item_price = (float)$_POST['item_price'];

$res = array();

if($item->update()) {
    $res['error'] = false;
    $res['message'] = "Item updated successfully";
} else {
    $res['error']   = true;
    $res['message'] = "Item update failed!";
}

echo json_encode($res);