<?php

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once "../../../config/Database.php";
include_once "../../../models/Cashier.php";

$cashier = new Cashier();

$cashier->cashier_name = $_POST['cashier_name'];

$res = array();

if($cashier->create()) {
    $res['error'] = false;
    $res['message'] = "Cashier added successfully";
} else {
    $res['error']   = true;
    $res['message'] = "Cashier insert failed!";
}



echo json_encode($res);