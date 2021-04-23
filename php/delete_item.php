<?php
/*
  Author:   Robert Zaranek
  Date:     November 21, 2020

  Purpose:  Deletes a specified Item from the database and returns an updated list of Items.
*/

include "connect.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (
    $id !== null && $id !== false && $id >= 0
) {
    $command = "DELETE FROM shopping_list WHERE ID = ?";
    $stmt = $dbh->prepare($command);
    $params = [$id];
    $success = $stmt->execute($params);

    if ($success) {
        include "get_list.php";
    } else {
        echo "DELETE statement failed";
    }
} else {
    echo "DELETE Parameters Invalid";
}
