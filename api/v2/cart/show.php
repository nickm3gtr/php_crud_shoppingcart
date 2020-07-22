<?php

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once "../../../config/Database.php";
include_once "../../../models/Cart.php";

$cart = new Cart();

$res = array();
$res['error'] = false;
$res['id'] = $cart->show();
$res['message'] = 'Items fetched successfully';



echo json_encode($res);
