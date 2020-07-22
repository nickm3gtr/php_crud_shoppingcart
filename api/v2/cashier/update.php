<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once "../../../config/Database.php";
include_once "../../../models/Cashier.php";

$cashier = new Cashier();

$cashier->id = (int)$_POST['id'];
$cashier->cashier_name = $_POST['cashier_name'];

$res = array();

if($cashier->update()) {
    $res['error'] = false;
    $res['message'] = "Cashier updated successfully";
} else {
    $res['error']   = true;
    $res['message'] = "Cashier update failed!";
}



echo json_encode($res);