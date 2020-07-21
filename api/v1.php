<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

//DB conn
$conn = new mysqli("localhost", "root", "", "shopping_cart");
if ($conn->connect_error) {
  die("Database connection failed!");
}
$res = array('error' => false);

// Read data from DB
$action = 'read-items';

if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

if ($action == 'read-items') {
  $result = $conn->query("SELECT * FROM `item` ORDER BY `id` DESC");
  $items = array();

  while ($row = $result->fetch_assoc()) {
    array_push($items, $row);
  }
  $res['items'] = $items;
}
// cashiers
if ($action == 'read-cashiers') {
  $result = $conn->query("SELECT * FROM `cashier`");
  $cashiers = array();

  while ($row = $result->fetch_assoc()) {
    array_push($cashiers, $row);
  }
  $res['cashiers'] = $cashiers;
}

// cart
if ($action == 'read-transactions') {
  $result = $conn->query("SELECT `cart`.`id`, `cashier`.`cashier_name`, `cart`.`date_time` FROM `cashier` INNER JOIN `cart` ON `cashier`.`id`=`cart`.`cashier_id` ORDER BY `cart`.`id` DESC");
  $transactions = array();

  while ($row = $result->fetch_assoc()) {
    array_push($transactions, $row);
  }
  $res['transactions'] = $transactions;
}

// Transaction details
if ($action == 'read-transaction-details') {
  $cart_id = (int)$_POST['cart_id'];
  $result = $conn->query("SELECT `cart`.`id`, `cashier`. `cashier_name`, `cart`.`date_time`, `item`.`item_name`, `item`.`item_price`, `item_cart`.`item_qty`
  FROM `cashier` RIGHT JOIN `cart` ON `cashier`.`id`=`cart`.`cashier_id` 
    RIGHT JOIN `item_cart` ON `cart`.`id`=`item_cart`.`cart_id`
    LEFT JOIN `item` ON `item_cart`.`item_id`=`item`.`id`
  WHERE `cart`.`id` = $cart_id");
  $transactions = array();

  while ($row = $result->fetch_assoc()) {
    array_push($transactions, $row);
  }
  $res['transaction_details'] = $transactions;
}


// Insert data into database
if ($action == 'create-item') {
  $item_name = $_POST['item_name'];
  $item_price = (float)$_POST['item_price'];

  $result = $conn->query("INSERT INTO `item` (`item_name`, `item_price`) VALUES('$item_name', $item_price)");

  if ($result) {
    $res['message'] = "Item added successfully";
  } else {
    $res['error']   = true;
    $res['message'] = "Item insert failed!" . $conn->error;
  }
}

//Insert cashier
if ($action == 'create-cashier') {
  $cashier_name = $_POST['cashier_name'];

  $result = $conn->query("INSERT INTO `cashier` (`cashier_name`) VALUES('$cashier_name')");

  if ($result) {
    $res['message'] = "Cashier added successfully";
  } else {
    $res['error']   = true;
    $res['message'] = "Cashier insert failed!" . $conn->error;
  }
}

// Delete data in the database
if ($action == 'delete-item') {
  $id = (int) $_POST['id'];

  $result = $conn->query("DELETE FROM `item` WHERE `id`='$id'");

  if ($result) {
    $res['message'] = "Item delete success";
  } else {
    $res['error']   = true;
    $res['message'] = "Item delete failed!";
  }
}

// delete cashier
if ($action == 'delete-cashier') {
  $id = (int) $_POST['id'];

  $result = $conn->query("DELETE FROM `cashier` WHERE `id`='$id'");

  if ($result) {
    $res['message'] = "Cashier delete success";
  } else {
    $res['error']   = true;
    $res['message'] = "Cashier delete failed!";
  }
}

// Update data 
if ($action == 'update-item') {
  $id = (int)$_POST['id'];
  $item_name = $_POST['item_name'];
  $item_price = (float)$_POST['item_price'];


  $result = $conn->query("UPDATE `item` SET `item_name`='$item_name', `item_price`=$item_price WHERE `id`=$id");

  if ($result) {
    $res['message'] = "Item updated successfully";
  } else {
    $res['error']   = true;
    $res['message'] = "Item update failed!";
  }
}

// Update cashier 
if ($action == 'update-cashier') {
  $id = (int)$_POST['id'];
  $cashier_name = $_POST['cashier_name'];


  $result = $conn->query("UPDATE `cashier` SET `cashier_name`='$cashier_name' WHERE `id`=$id");

  if ($result) {
    $res['message'] = "Cashier updated successfully";
  } else {
    $res['error']   = true;
    $res['message'] = "Cashier update failed!";
  }
}

// Get latest id from cart
if ($action == 'get-latest-id') {
  $result = $conn->query("SELECT `id` FROM `cart` ORDER BY `id` DESC LIMIT 1");

  if ($result->num_rows == 0) {
    $res['id'] = [1];
  } else {
    $res['id'] = $result->fetch_row();
  }
}

// Add cart transaction
if ($action == 'add-cart') {
  $cashier_id = (int)$_POST['cashier_id'];
  $date_time = date("Y-m-d H:i:s");

  $result = $conn->query("INSERT INTO `cart` (`cashier_id`, `date_time`) VALUES('$cashier_id', '$date_time')");

  if ($result) {
    $res['message'] = "Cart added successfully";
  } else {
    $res['error']   = true;
    $res['message'] = "Cart insert failed!" . $conn->error;
  }
}

// Add to Item_Cart
if ($action == 'add-item-cart') {
  $item_id = (int)$_POST['item_id'];
  $cart_id = (int)$_POST['cart_id'];
  $item_qty = (int)$_POST['item_qty'];

  $result = $conn->query("INSERT INTO `item_cart` (`item_id`, `cart_id`, `item_qty`) VALUES($item_id, $cart_id, $item_qty);");

  if ($result) {
    $res['message'] = "Item_Cart added successfully";
  } else {
    $res['error']   = true;
    $res['message'] = "Item_Cart insert failed!" . $conn->error;
  }
}



$conn->close();
echo json_encode($res);
die();
