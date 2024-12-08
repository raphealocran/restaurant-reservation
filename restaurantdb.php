<?php
class RestaurantDatabase {
    private $host = "localhost";
    private $port = "3306";
    private $database = "restaurant_reservations";
    private $user = "root";
    private $password = "YourPassword";
    private $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database, $this->port);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
        echo "Successfully connected to the database";
    }

    public function addReservation($customerId, $reservationTime, $numberOfGuests, $specialRequests) {
        $stmt = $this->connection->prepare(
            "INSERT INTO reservations (customerId, reservationTime, numberOfGuests, specialRequests) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("isis", $customerId, $reservationTime, $numberOfGuests, $specialRequests);
        $stmt->execute();
        $stmt->close();
        echo "Reservation added successfully";
    }

    public function getAllReservations() {
        $result = $this->connection->query("SELECT * FROM reservations");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getReservationById($reservationId) {
        $stmt = $this->connection->prepare("SELECT * FROM reservations WHERE reservationId = ?");
        $stmt->bind_param("i", $reservationId);
        $stmt->execute();
        $result = $stmt->get_result();
        $reservation = $result->fetch_assoc();
        $stmt->close();
        return $reservation;
    }

    public function addCustomer($customerName, $contactInfo) {
        $stmt = $this->connection->prepare(
            "INSERT INTO customers (customerName, contactInfo) VALUES (?, ?)"
        );
        $stmt->bind_param("ss", $customerName, $contactInfo);
        $stmt->execute();
        $stmt->close();
        echo "Customer added successfully";
    }

    public function getCustomerPreferences($customerId) {
        $stmt = $this->connection->prepare(
            "SELECT * FROM customer_preferences WHERE customerId = ?"
        );
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $preferences = $result->fetch_assoc();
        $stmt->close();
        return $preferences;
    }

    public function updateReservation($reservationId, $reservationTime, $numberOfGuests, $specialRequests) {
        $stmt = $this->connection->prepare(
            "UPDATE reservations SET reservationTime = ?, numberOfGuests = ?, specialRequests = ? WHERE reservationId = ?"
        );
        $stmt->bind_param("sisi", $reservationTime, $numberOfGuests, $specialRequests, $reservationId);
        $stmt->execute();
        $stmt->close();
        echo "Reservation updated successfully";
    }

    public function cancelReservation($reservationId) {
        $stmt = $this->connection->prepare(
            "DELETE FROM reservations WHERE reservationId = ?"
        );
        $stmt->bind_param("i", $reservationId);
        $stmt->execute();
        $stmt->close();
        echo "Reservation cancelled successfully";
    }

    public function updateCustomerPreferences($customerId, $preferences) {
        $stmt = $this->connection->prepare(
            "INSERT INTO customer_preferences (customerId, preferences) VALUES (?, ?) 
             ON DUPLICATE KEY UPDATE preferences = ?"
        );
        $stmt->bind_param("iss", $customerId, $preferences, $preferences);
        $stmt->execute();
        $stmt->close();
        echo "Customer preferences updated successfully";
    }
}