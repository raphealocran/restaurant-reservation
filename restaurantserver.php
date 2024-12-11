<?php
require_once 'restaurantdb.php';

class RestaurantPortal {
    private $db;

    public function __construct() {
        $this->db = new RestaurantDatabase();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'home';

        switch ($action) {
            case 'addReservation':
                $this->addReservation();
                break;
            case 'viewReservations':
                $this->viewReservations();
                break;
            case 'updateReservation':
                $this->updateReservation();
                break;
            case 'cancelReservation':
                $this->cancelReservation();
                break;
            case 'addCustomer':
                $this->addCustomer();
                break;
            case 'updatePreferences':
                $this->updateCustomerPreferences();
                break;
            default:
                $this->home();
        }
    }

    private function addReservation() {
        if ($_SERVER['REQUEST_METHOD']== "POST"){
            $customerId = $_POST['customer_id'];
            $reservationTime = $_POST['reservation_time'];
            $numberOfGuests = $_POST['number_of_guests'];
            $specialRequests = $_POST['special_requests'];

            $this->db->addReservation($customerId, $reservationTime, $numberOfGuests, $specialRequests);
            header("Location: index.php?action=viewReservations&message=Reservation Added");
        } else {
            include 'addreservation.php';
        }
    }

    private function viewReservations() {
        // Fetch all reservations from the database
        $reservations = $this->db->getAllReservations();
        
        // Check if there are any reservations to display
        if ($reservations) {
            // Pass the reservations to the view template
            include 'viewReservations.php';
        } else {
            // If no reservations are found, show a message
            echo "No reservations available at the moment.";
        }
    }

    private function updateReservation() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reservationId = $_POST['reservation_id'];
            $reservationTime = $_POST['reservation_time'];
            $numberOfGuests = $_POST['number_of_guests'];
            $specialRequests = $_POST['special_requests'];

            $this->db->updateReservation($reservationId, $reservationTime, $numberOfGuests, $specialRequests);
            header("Location: index.php?action=viewReservations&message=Reservation Updated");
        } else {
            // Load the reservation details and display the update form
            // You'll need to create an updateReservation.php template
            include 'templates/updateReservation.php';
        }
    }

    private function cancelReservation() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reservationId = $_POST['reservation_id'];
            $this->db->cancelReservation($reservationId);
            header("Location: index.php?action=viewReservations&message=Reservation Cancelled");
        }
    }

    private function addCustomer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customerName = $_POST['customer_name'];
            $contactInfo = $_POST['contact_info'];
            $this->db->addCustomer($customerName, $contactInfo);
            header("Location: index.php?message=Customer Added");
        } else {
            include 'addCustomer.php';
        }
    }


    private function updateCustomerPreferences() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customerId = $_POST['customer_id'];
            $preferences = $_POST['preferences'];
            $this->db->updateCustomerPreferences($customerId, $preferences);
            header("Location: index.php?message=Preferences Updated");
        } else {
            include 'updatePreferences.php';
        }
    }
}