<?php
/*
  Author:   Robert Zaranek
  Date:     November 21, 2020

  Purpose:  Inserts a new Item into the database and returns an updated list of Items.
*/

include "connect.php";

$item_name = filter_input(INPUT_GET, "item_name", FILTER_SANITIZE_STRING);
$quantity = filter_input(INPUT_GET, "quantity", FILTER_VALIDATE_INT);

if (
    $item_name !== null && $item_name !== "" && strlen($item_name) <= 40 &&
    $quantity !== null && $quantity !== false && ($quantity >= 1 && $quantity <= 1000)
) {
    $command = "INSERT into shopping_list (item, quantity) VALUES (?, ?)";
    $stmt = $dbh->prepare($command);
    $params = [$item_name, $quantity];
    $success = $stmt->execute($params);

    if ($success) {
        include "get_list.php";
    } else {
        echo "INSERT statement failed";
    }
} else {
    echo "INSERT Parameters Invalid";
}
