<?php
/*
  Author:   Robert Zaranek
  Date:     November 21, 2020

  Purpose:  Returns an updated list of Items from the database.
*/

include "connect.php";
include "item.php";

$items = [];
$command = "SELECT ID, item, quantity, done FROM shopping_list ORDER BY done, item, quantity DESC";
$stmt = $dbh->prepare($command);
$success = $stmt->execute();

if ($success) {
    while ($row = $stmt->fetch()) {
        $item = new Item($row["ID"], $row["item"], $row["quantity"], $row["done"]);
        $idArray = [$item->getName(), $item->getQuantity(), $item->getID(), $item->isDone()];
        array_push($items, $idArray);
    }
    echo json_encode($items);
} else {
    echo "SELECT statement failed";
}
