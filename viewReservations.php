<?php
// Include the RestaurantDB class
require_once 'RestaurantDB.php';

// Initialize the database connection
$db = new RestaurantDB();

// Fetch reservations
$reservations = $db->getReservations(); // Fetch all reservations from the database
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Reservations</title>
</head>
<body>
    <h1>All Reservations</h1>
    <?php if (!empty($reservations)): ?>
        <table border="1">
            <tr>
                <th>Reservation ID</th>
                <th>Customer ID</th>
                <th>Customer Name</th>
                <th>Reservation Time</th>
                <th>Number of Guests</th>
                <th>Special Requests</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?= htmlspecialchars($reservation['reservationId']) ?></td>
                    <td><?= htmlspecialchars($reservation['customerId']) ?></td> <!-- customerId should now be available -->
                    <td><?= htmlspecialchars($reservation['customerName']) ?></td>
                    <td><?= htmlspecialchars($reservation['reservationTime']) ?></td>
                    <td><?= htmlspecialchars($reservation['numberOfGuests']) ?></td>
                    <td><?= htmlspecialchars($reservation['specialRequests']) ?></td>
                    <td>
                        <!-- Link to update reservation -->
                        <a href="updateReservation.php?id=<?= htmlspecialchars($reservation['reservationId']) ?>">Update</a>

                        <!-- Form to cancel reservation -->
                        <form method="POST" action="index.php?action=cancelReservation" style="display:inline;">
                            <input type="hidden" name="reservation_id" value="<?= htmlspecialchars($reservation['reservationId']) ?>">
                            <button type="submit" onclick="return confirm('Are you sure you want to cancel this reservation?');">Cancel</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No reservations found.</p>
    <?php endif; ?>
</body>
</html>
