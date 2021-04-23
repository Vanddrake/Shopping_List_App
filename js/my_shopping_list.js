/*
  Author:   Robert Zaranek
  Date:     November 21, 2020

  Purpose:  The JavaScript portion of the shopping list web application.
*/

/**
 * The 'Main' method, activates upon DOM load completion.
 */
window.addEventListener("load", function () {

  // Displays the list from the database upon webpage loading
  let loadURL = "php/get_list.php";
  console.log(loadURL); // debug
  fetch(loadURL, {
      credentials: 'include'
    })
    .then(response => response.json())
    .then(success)

  // Event listener for adding an item
  document.forms.main_form.addEventListener("submit", addItemEvent);

  /**
   * Function for submitting an item into the shopping list.
   * 
   * @param {*} event 
   */
  function addItemEvent(event) {
    event.preventDefault();
    let itemName = document.getElementById("item_name").value;
    let quantity = document.getElementById("quantity").value;
    document.getElementById("item_name").value = "";
    document.getElementById("quantity").value = "";

    let insertURL = "php/insert_item.php?item_name=" + itemName + "&quantity=" + quantity;
    console.log(insertURL); // debug
    fetch(insertURL, {
        credentials: 'include'
      })
      .then(response => response.json())
      .then(success)
  }

  let currentIndex = 0;       // Stores the current index for the editItemEvent function
  let currentItemArray = [];  // Stores the current item array for the editItemEvent function

  /**
   * Function for editting and item on the list
   * 
   * @param {*} event 
   */
  function editItemEvent(event) {
    event.preventDefault();
    let itemName = document.getElementById("item_name").value;
    let quantity = document.getElementById("quantity").value;

    let updateURL = "php/update_item.php?id=" + currentItemArray[currentIndex][2] +
      "&item_name=" + itemName + "&quantity=" + quantity;
    console.log(updateURL); // debug
    fetch(updateURL, {
        credentials: 'include'
      })
      .then(response => response.json())
      .then(success)

    resetForm();
  }

  /**
   * Function for clicking the cancel button that appears after clicking the edit button
   */
  document.getElementById("cancel_edit_button").addEventListener("click", function () {
    resetForm();
  });

  /**
   * Function for resetting the form back to its original state for adding items
   */
  function resetForm() {
    document.forms.main_form.removeEventListener("submit", editItemEvent);
    document.getElementById("cancel_edit_button").style.display = "none";
    document.getElementById("item_name").value = "";
    document.getElementById("quantity").value = "";
    document.getElementById("submit_button").value = "Add";
    document.forms.main_form.addEventListener("submit", addItemEvent);
  }

  /**
   * This function should be called when the AJAX call is complete
   * and the text has been extracted from the response.
   * @param {String} itemArray 
   */
  function success(itemArray) {

    currentItemArray = itemArray;

    console.log(itemArray); // debug
    let mainList = document.getElementById("main_list");
    mainList.querySelectorAll('*').forEach(node => node.remove());

    // Adds HTML Element for each Item in list
    for (let i = 0; i < itemArray.length; i++) {

      // Create Line Split
      let lineSplit = document.createElement("hr");

      // Create Text Contents
      let listItem = document.createElement("li");
      let node = document.createTextNode(itemArray[i][0] + " (" + itemArray[i][1] + ")");
      listItem.appendChild(node);

      // Create 'Done' Checkbox
      let checkBox = document.createElement("input");
      let isDoneInverse = 1;
      checkBox.type = "checkbox";
      if(itemArray[i][3] === true) {
        checkBox.setAttribute("checked", "true");
        isDoneInverse = 0;
      }
      listItem.insertBefore(checkBox, node);
      /**
       * Event listener for click this checkbox
       */
      checkBox.addEventListener("click", function () {
        let checkItemURL = "php/check_item.php?id=" + itemArray[i][2] + "&done=" + isDoneInverse;
        console.log(checkItemURL); // debug
        fetch(checkItemURL, {
            credentials: 'include'
          })
          .then(response => response.json())
          .then(success)

        resetForm();
      });

      // Create Edit Button
      let editButton = document.createElement("img");
      editButton.src = "img/pencil.png";
      editButton.className = "edit_button";
      listItem.insertBefore(editButton, checkBox);
      /**
       * Event listener for click this edit button
       */
      editButton.addEventListener("click", function () {
        currentIndex = i;
        isChecked = 0;
        document.forms.main_form.removeEventListener("submit", editItemEvent);
        document.forms.main_form.removeEventListener("submit", addItemEvent);

        document.getElementById("item_name").value = itemArray[i][0];
        document.getElementById("quantity").value = itemArray[i][1];
        document.getElementById("submit_button").value = "Edit";
        document.getElementById("cancel_edit_button").style.display = "inline";

        document.forms.main_form.addEventListener("submit", editItemEvent);

      });

      // Create Delete Button
      let deleteButton = document.createElement("img");
      deleteButton.src = "img/remove.png";
      deleteButton.className = "delete_button";
      listItem.insertBefore(deleteButton, editButton);
      /**
       * Event listener for click this delete button
       */
      deleteButton.addEventListener("click", function () {
        let deleteURL = "php/delete_item.php?id=" + itemArray[i][2];
        console.log(deleteURL); // debug
        fetch(deleteURL, {
            credentials: 'include'
          })
          .then(response => response.json())
          .then(success)

        resetForm();
      });

      // Add Elements to DOM
      mainList.appendChild(lineSplit);
      mainList.appendChild(listItem);
    }
  }
});