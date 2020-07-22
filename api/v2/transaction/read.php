<?php

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once "../../../config/Database.php";
include_once "../../../models/Transaction.php";

$transaction = new Transaction();

$res = array();
$res['error'] = false;
$res['transactions'] = $transaction->read();
$res['message'] = 'Transactions fetched successfully';

echo json_encode($res);