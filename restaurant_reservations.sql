CREATE DATABASE restaurant_reservations;
USE restaurant_reservations;

-- Creating Customers Table
CREATE TABLE customers (
    customerId INT NOT NULL AUTO_INCREMENT,
    customerName VARCHAR(45) NOT NULL,
    contactInfo VARCHAR(200),
    PRIMARY KEY (customerId)
);

-- Creating Reservations Table
CREATE TABLE reservations (
    reservationId INT NOT NULL AUTO_INCREMENT,
    customerId INT NOT NULL,
    reservationTime DATETIME NOT NULL,
    numberOfGuests INT NOT NULL,
    specialRequests VARCHAR(200) DEFAULT '',
    PRIMARY KEY (reservationId),
    FOREIGN KEY (customerId) REFERENCES customers(customerId)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Creating Dining Preferences Table
CREATE TABLE dining_preferences (
    preferenceId INT NOT NULL AUTO_INCREMENT,
    customerId INT NOT NULL,
    favoriteTable VARCHAR(45),
    dietaryRestrictions VARCHAR(200),
    PRIMARY KEY (preferenceId),
    FOREIGN KEY (customerId) REFERENCES customers(customerId)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Creating Stored Procedures
DELIMITER //

CREATE PROCEDURE findReservations(IN inCustId INT)
BEGIN
    SELECT * 
    FROM reservations 
    WHERE customerId = inCustId;
END //

CREATE PROCEDURE addSpecialRequest(IN inResId INT, IN inRequests VARCHAR(200))
BEGIN
    UPDATE reservations 
    SET specialRequests = inRequests 
    WHERE reservationId = inResId;
END //

CREATE PROCEDURE addReservation(
    IN inCustomerName VARCHAR(45),
    IN inContactInfo VARCHAR(200),
    IN inReservationTime DATETIME,
    IN inNumberOfGuests INT,
    IN inSpecialRequests VARCHAR(200)
)
BEGIN
    DECLARE custId INT;

    -- Check if customer exists
    SELECT customerId INTO custId 
    FROM customers 
    WHERE customerName = inCustomerName 
      AND contactInfo = inContactInfo;

    -- If customer does not exist, insert a new customer
    IF custId IS NULL THEN
        INSERT INTO customers (customerName, contactInfo) 
        VALUES (inCustomerName, inContactInfo);
        SET custId = LAST_INSERT_ID();
    END IF;

    -- Add the reservation
    INSERT INTO reservations (customerId, reservationTime, numberOfGuests, specialRequests)
    VALUES (custId, inReservationTime, inNumberOfGuests, inSpecialRequests);
END //
DELIMITER ;

