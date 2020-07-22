<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once "../../../config/Database.php";
include_once "../../../models/Item.php";

$item = new Item();

$item->id = (int)$_POST['id'];

$res = array();

if($item->delete()) {
    $res['error'] = false;
    $res['message'] = "Item deleted successfully";
} else {
    $res['error']   = true;
    $res['message'] = "Item deletion failed!";
}

echo json_encode($res);