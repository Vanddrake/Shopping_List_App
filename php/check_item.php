<?php
/*
  Author:   Robert Zaranek
  Date:     November 21, 2020

  Purpose:  Updates a specified Item from the database, changing it to either done or not done.
            Then returns an updated list of Items.
*/

include "connect.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$done = filter_input(INPUT_GET, "done", FILTER_VALIDATE_INT);

if (
    $id !== null && $id !== false && $id >= 0 &&
    $done !== null && $done !== false && ($done === 0 || $done === 1)
) {
    $command = "UPDATE shopping_list SET done = ? WHERE id = ?";
    $stmt = $dbh->prepare($command);
    $params = [$done, $id];
    $success = $stmt->execute($params);

    if ($success) {
        include "get_list.php";
    } else {
        echo "UPDATE statement failed";
    }
} else {
    echo "UPDATE Parameters Invalid";
}
