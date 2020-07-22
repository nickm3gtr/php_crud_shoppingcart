<?php

header("Access-Control-Allow-Origin: *");
//header("Content-type: application/json");

include_once "../../../config/Database.php";
include_once "../../../models/Item.php";

$item = new Item();

$res = array();
$res['error'] = false;
$res['items'] = $item->read();
$res['message'] = 'Items fetched successfully';

echo json_encode($res);


