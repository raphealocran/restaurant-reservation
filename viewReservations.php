<?php
// Database connection details
$host = 'localhost';      // Database host 
$dbname = 'restaurant_reservations'; 
$username = 'root'; 
$password = '';
?>

<html>
<head><title>View Reservations</title></head>
<body>
    <h1>All Reservations</h1>
    <table border="1">
        <tr>
            <th>Reservation ID</th>
            <th>Customer ID</th>
            <th>Reservation Time</th>
            <th>Number of Guests</th>
            <th>Special Requests</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($reservations as $reservation): ?>
        <tr>
            <td><?= htmlspecialchars($reservation['reservationId']) ?></td>
            <td><?= htmlspecialchars($reservation['customer_id']) ?></td>
            <td><?= htmlspecialchars($reservation['reservation_time']) ?></td>
            <td><?= htmlspecialchars($reservation['number_of_guests']) ?></td>
            <td><?= htmlspecialchars($reservation['special_requests']) ?></td>
            <td>
                <a href="index.php?action=updateReservation&id=<?= $reservation['reservationId'] ?>">Update</a>
                <form method="POST" action="index.php?action=cancelReservation" style="display:inline;">
                    <input type="hidden" name="reservation_id" value="<?= $reservation['reservationId'] ?>">
                    <button type="submit" onclick="return confirm('Are you sure you want to cancel this reservation?');">Cancel</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="home.php">Back to Home</a>
</body>
</html>
