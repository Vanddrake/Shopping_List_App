<?php
/*
  Author:   Robert Zaranek
  Date:     November 21, 2020

  Purpose:  Updates a specified Item with a new name and quantity from the database 
            and returns an updated list of Items.
*/

include "connect.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$item_name = filter_input(INPUT_GET, "item_name", FILTER_SANITIZE_STRING);
$quantity = filter_input(INPUT_GET, "quantity", FILTER_VALIDATE_INT);

if (
    $id !== null && $id !== false && $id >= 0 &&
    $item_name !== null && $item_name !== "" && strlen($item_name) <= 40 &&
    $quantity !== null && $quantity !== false && ($quantity >= 1 && $quantity <= 1000)
) {
    $command = "UPDATE shopping_list SET item = ?, quantity = ? WHERE id = ?";
    $stmt = $dbh->prepare($command);
    $params = [$item_name, $quantity, $id];
    $success = $stmt->execute($params);

    if ($success) {
        include "get_list.php";
    } else {
        echo "UPDATE statement failed";
    }
} else {
    echo "UPDATE Parameters Invalid";
}
