<?php

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once "../../../config/Database.php";
include_once "../../../models/Cashier.php";

$cashier = new Cashier();

$res = array();
$res['error'] = false;
$res['cashiers'] = $cashier->read();
$res['message'] = 'Cashiers fetched successfully';

echo json_encode($res);


