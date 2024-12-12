<?php
// Include the RestaurantDB class
require_once 'RestaurantDB.php';

// Handle different actions based on the query parameter 'action'
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    // Adding a reservation
    case 'addReservation':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validate and process the reservation data
            $customerName = isset($_POST['customerName']) ? trim($_POST['customerName']) : '';
            $contactInfo = isset($_POST['contactInfo']) ? trim($_POST['contactInfo']) : '';
            $reservationTime = isset($_POST['reservationTime']) ? trim($_POST['reservationTime']) : '';
            $numberOfGuests = isset($_POST['numberOfGuests']) ? (int) $_POST['numberOfGuests'] : 0;
            $specialRequests = isset($_POST['specialRequests']) ? trim($_POST['specialRequests']) : '';

            // Basic validation
            if (empty($customerName) || empty($contactInfo) || empty($reservationTime) || $numberOfGuests <= 0) {
                echo "<p>Please provide valid data for all fields.</p>";
                break;
            }

            // Create a new RestaurantDB object to interact with the database
            $db = new RestaurantDB();

            // Call the addReservation method to insert the reservation
            $reservationId = $db->addReservation($customerName, $contactInfo, $reservationTime, $numberOfGuests, $specialRequests);

            if ($reservationId) {
                // Redirect to avoid resubmission
                header("Location: index.php?action=viewReservations");
                exit;
            } else {
                echo "<p>Error adding reservation. Please try again.</p>";
            }
        }
        break;

    // Cancel Reservation
    case 'cancelReservation':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the reservation ID from the form
            $reservationId = isset($_POST['reservation_id']) ? (int) $_POST['reservation_id'] : 0;

            if ($reservationId > 0) {
                // Create a new RestaurantDB object to interact with the database
                $db = new RestaurantDB();

                // Call the cancelReservation method to delete the reservation
                $success = $db->cancelReservation($reservationId);

                if ($success) {
                    echo "<p>Reservation cancelled successfully!</p>";
                } else {
                    echo "<p>Error cancelling reservation. Please try again.</p>";
                }
            } else {
                echo "<p>Invalid reservation ID.</p>";
            }
        }
        break;

    // Update Customer Preferences
    case 'updatePreferences':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Your logic to update customer preferences
            echo "Customer preferences updated successfully!";
        } else {
            include('updatecustomerpreferences.php');
        }
        break;

    // View Reservations (Optional - You can add an action for this if needed)
    case 'viewReservations':
        include('viewReservations.php');
        break;

    // Default case (home page)
    default:
        include('home.php');
        break;
}
?>

