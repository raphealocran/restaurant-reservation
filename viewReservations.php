<?php
// Database connection details
$host = 'localhost';
$dbname = 'restaurant_reservations';
$username = 'root';
$password = '';

// Establish the database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch reservations
    $stmt = $pdo->query("
        SELECT r.reservationId, r.customerId, r.reservationTime, 
               r.numberOfGuests, r.specialRequests 
        FROM reservations r
    ");
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("<h1>Database connection failed: " . htmlspecialchars($e->getMessage()) . "</h1>");
}
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
                <th>Reservation Time</th>
                <th>Number of Guests</th>
                <th>Special Requests</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?= htmlspecialchars($reservation['reservationId']) ?></td>
                    <td><?= htmlspecialchars($reservation['customerId']) ?></td>
                    <td><?= htmlspecialchars($reservation['reservationTime']) ?></td>
                    <td><?= htmlspecialchars($reservation['numberOfGuests']) ?></td>
                    <td><?= htmlspecialchars($reservation['specialRequests']) ?></td>
                    <td>
                        <a href="index.php?action=updateReservation&id=<?= htmlspecialchars($reservation['reservationId']) ?>">Update</a>
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
    <a href="home.php">Back to Home</a>
</body>
</html>
