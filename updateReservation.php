<?php
$reservation = isset($reservation) ? $reservation : null;
?>
<html>
<head><title>Update Reservation</title></head>
<body>
    <h1>Update Reservation</h1>
    <form method="POST" action="updateReservation.php">
        <input type="hidden" name="reservation_id" value="<?= htmlspecialchars($reservation['reservationId'] ?? '') ?>">
        Customer ID: <input type="text" name="customer_id" value="<?= htmlspecialchars($reservation['customerId'] ?? '') ?>" readonly><br>
        Reservation Time: <input type="datetime-local" name="reservation_time" value="<?= htmlspecialchars($reservation['reservationTime'] ?? '') ?>"><br>
        Number of Guests: <input type="number" name="number_of_guests" value="<?= htmlspecialchars($reservation['numberOfGuests'] ?? '') ?>"><br>
        Special Requests: <textarea name="special_requests"><?= htmlspecialchars($reservation['specialRequests'] ?? '') ?></textarea><br>
        <button type="submit">Update Reservation</button>
    </form>
    <a href="viewReservations.php">Back to Reservations</a>
</body>
</html>
