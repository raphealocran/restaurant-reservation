<?php
class RestaurantDB {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "restaurant_reservations";
    private $conn;

    // Constructor: Initialize database connection
    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Function to add a customer or return existing customerId
    public function addOrGetCustomer($name, $contact) {
        // Check if customer already exists
        $stmt = $this->conn->prepare("SELECT customerId FROM Customers WHERE customerName = ? AND contactInfo = ?");
        $stmt->bind_param("ss", $name, $contact);
        $stmt->execute();
        $stmt->bind_result($customerId);
        $stmt->fetch();
        $stmt->close();

        if ($customerId) {
            return $customerId; // Return existing customerId
        }

        // Add new customer
        $stmt = $this->conn->prepare("INSERT INTO Customers (customerName, contactInfo) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $contact);

        if ($stmt->execute()) {
            $newCustomerId = $this->conn->insert_id;
            $stmt->close();
            return $newCustomerId; // Return new customerId
        } else {
            error_log("Error adding customer: " . $stmt->error);
            $stmt->close();
            return false;
        }
    }

    // Function to add a reservation
    public function addReservation($name, $contact, $reservationTime, $numberOfGuests, $specialRequests) {
        // Get or add customerId
        $customerId = $this->addOrGetCustomer($name, $contact);

        if (!$customerId) {
            return false; // Unable to retrieve or add customer
        }

        $stmt = $this->conn->prepare(
            "INSERT INTO Reservations (customerId, reservationTime, numberOfGuests, specialRequests) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("isis", $customerId, $reservationTime, $numberOfGuests, $specialRequests);

        if ($stmt->execute()) {
            $reservationId = $this->conn->insert_id;
            $stmt->close();
            return $reservationId; // Return new reservationId
        } else {
            error_log("Error adding reservation: " . $stmt->error);
            $stmt->close();
            return false;
        }
    }

    // Function to update dining preferences
    public function updatePreferences($customerId, $favoriteTable, $dietaryRestrictions) {
        $stmt = $this->conn->prepare(
            "REPLACE INTO DiningPreferences (customerId, favoriteTable, dietaryRestrictions) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("iss", $customerId, $favoriteTable, $dietaryRestrictions);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            error_log("Error updating preferences: " . $stmt->error);
            $stmt->close();
            return false;
        }
    }

    // Function to get all reservations
    public function getReservations() {
        $result = $this->conn->query(
            "SELECT r.reservationId, c.customerName, c.contactInfo, r.reservationTime, r.numberOfGuests, r.specialRequests 
             FROM Reservations r 
             JOIN Customers c ON r.customerId = c.customerId"
        );

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            error_log("Error retrieving reservations: " . $this->conn->error);
            return [];
        }
    }

    // Destructor: Close database connection
    public function __destruct() {
        $this->conn->close();
    }
}
?>
