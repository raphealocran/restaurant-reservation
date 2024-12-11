CREATE DATABASE IF NOT EXISTS restaurant_reservations;

USE restaurant_reservations;

-- Create the customers table
CREATE TABLE IF NOT EXISTS customers (
    customerId INT AUTO_INCREMENT PRIMARY KEY,
    customerName VARCHAR(255) NOT NULL,
    contactInfo VARCHAR(255) NOT NULL
);

-- Create the reservations table
CREATE TABLE IF NOT EXISTS reservations (
    reservationId INT AUTO_INCREMENT PRIMARY KEY,
    customerId INT,
    reservationTime DATETIME NOT NULL,
    numberOfGuests INT NOT NULL,
    specialRequests TEXT,
    FOREIGN KEY (customerId) REFERENCES customers(customerId)
);

-- Create the customer preferences table
CREATE TABLE IF NOT EXISTS customer_preferences (
    preferenceId INT AUTO_INCREMENT PRIMARY KEY,
    customerId INT,
    preferences TEXT,
    FOREIGN KEY (customerId) REFERENCES customers(customerId)
);
