<?php

define('ROOT_PATH', dirname(__DIR__) . '/shopping_cart');

$host = 'localhost';
$username = 'root';
$password = '';
$db = 'shopping_cart';


$mysqli = new mysqli($host, $username, $password, $db);

if ($mysqli->connect_errno) {
  echo "Error: Failed to make a MySQL connection, here is why: \n";
  echo "Errno: " . $mysqli->connect_errno . "\n";
  echo "Error: " . $mysqli->connect_error . "\n";
  exit();
}

$sql = "CREATE TABLE IF NOT EXISTS Item(
  id int(11) AUTO_INCREMENT PRIMARY KEY,
  item_name varchar(255) NOT NULL,
  item_price DECIMAL(13,2) NOT NULL
);
CREATE TABLE IF NOT EXISTS Cashier(
  id int(11) AUTO_INCREMENT PRIMARY KEY,
  cashier_name varchar(255) NOT NULL
);
CREATE TABLE IF NOT EXISTS Cart(
  id int(11) AUTO_INCREMENT PRIMARY KEY,
  cashier_id int(11) NOT NULL,
  date_time DATETIME NOT NULL,
  CONSTRAINT FK_cashier_cart FOREIGN KEY (cashier_id) REFERENCES Cashier(id)
);
CREATE TABLE IF NOT EXISTS Item_Cart(
  id int(11) AUTO_INCREMENT PRIMARY KEY,
  item_id int(11) NOT NULL,
  cart_id int(11) NOT NULL,
  item_qty int(11) NOT NULL,
  CONSTRAINT FK_item_item_cart FOREIGN KEY (item_id) REFERENCES Item(id),
  CONSTRAINT FK_cart_item_cart FOREIGN KEY (cart_id) REFERENCES Cart(id)
);
";

if ($mysqli->multi_query($sql)) {

  if ($result = $mysqli->store_result()) {
    while ($row = $result->fetch_row()) {
      printf("%s\n", $row[0]);
    }
    $result->free_result();
  }
}
$mysqli->close();
