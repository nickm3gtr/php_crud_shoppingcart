<?php

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once "../../../config/Database.php";
include_once "../../../models/Transaction.php";

$transaction = new Transaction();

$transaction->cart_id = (int)$_POST['cart_id'];

$res = array();
$res['error'] = false;
$res['transaction_details'] = $transaction->show();
$res['message'] = 'Transactions details fetched successfully';

echo json_encode($res);