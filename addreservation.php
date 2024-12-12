<?php
// Include the RestaurantDB class
require_once 'RestaurantDB.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $customerName = $_POST['customerName'];
    $contactInfo = $_POST['contactInfo'];
    $reservationTime = $_POST['reservationTime'];
    $numberOfGuests = $_POST['numberOfGuests'];
    $specialRequests = $_POST['specialRequests'];

    // Create a new RestaurantDB object to interact with the database
    $db = new RestaurantDB();

    // Call the addReservation method to insert the reservation
    $reservationId = $db->addReservation($customerName, $contactInfo, $reservationTime, $numberOfGuests, $specialRequests);

    if ($reservationId) {
        echo "<p>Reservation added successfully with ID: $reservationId</p>";
    } else {
        echo "<p>Error adding reservation. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Add Reservation</title></head>
<body>
    <h1>Add Reservation</h1>
    <form method="POST" action="addreservation.php">
        Customer Name: <input type="text" name="customerName" required><br>
        Contact Info: <input type="email" name="contactInfo" required><br>
        Reservation Time: <input type="datetime-local" name="reservationTime" required><br>
        Number of Guests: <input type="number" name="numberOfGuests" required><br>
        Special Requests: <textarea name="specialRequests"></textarea><br>
        <button type="submit">Submit</button>
    </form>
    <a href="home.php">Back to Home</a>
</body>
</html>

