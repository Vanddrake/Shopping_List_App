<?php
/*
  Author:   Robert Zaranek
  Date:     November 21, 2020

  Purpose:  A class for a single Item in the 'My Shopping List' web app.
*/
class Item
{
    private $id;                // The database ID of this Item
    private $item_name;         // The name of this Item
    private $item_quantity;     // The quantity of this Item
    private $item_checked;      // Whether this Item is checked as 'done' (0 = not done, 1 = done)

    /**
     * Constructor for an Item object
     * 
     * @peram {$id} The database ID of this Item
     * @peram {$item_name} The name of this Item
     * @peram {$item_quantity} The quantity of this Item
     * @peram {$item_checked} Whether this Item is checked as 'done' (0 = not done, 1 = done)
     */
    function __construct($id, $item_name, $item_quantity, $item_checked)
    {
        $this->id = (int)$id;
        $this->item_name = $item_name;
        $this->item_quantity = (int)$item_quantity;
        $this->item_checked = (int)$item_checked;
    }

    /**
     * Returns a boolean of whether this item is 'done' or not
     * 
     * @returns Boolean of whether this item is 'done' or not
     */
    function isDone()
    {
        if($this->item_checked === 1) return true;
        else if($this->item_checked === 0) return false;
    }

    /**
     * Returns the database ID of this Item
     * 
     * @returns The database ID of this Item
     */
    function getID() 
    {
        return $this->id;
    }

    /**
     * Returns the name of this Item
     * 
     * @returns The name of this Item
     */
    function getName() 
    {
        return $this->item_name;
    }

    /**
     * Returns the quantity of this Item
     * 
     * @returns The quantity of this Item
     */
    function getQuantity() 
    {
        return $this->item_quantity;
    }
}
