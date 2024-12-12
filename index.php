<?php
// Handle different actions based on the query parameter 'action'
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'addCustomer':
        // Handle adding a new customer
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //logic to add a customer
            echo "Customer added successfully!";
        } else {
            include('addCustomer.php');
        }
        break;

    case 'updatePreferences':
        // Handle updating customer preferences
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Your logic to update customer preferences
            echo "Customer preferences updated successfully!";
        } else {
            include('updatecustomerpreferences.php');
        }
        break;

    default:
        // Default to the homepage if no action is provided
        include('home.php');
        break;
}
?>