DROP TABLE IF EXISTS service_detail;
DROP TABLE IF EXISTS service;
DROP TABLE IF EXISTS receipt;
DROP TABLE IF EXISTS payment;
DROP TABLE IF EXISTS booking;
DROP TABLE IF EXISTS vehicle;
DROP TABLE IF EXISTS vehicle_type;
DROP TABLE IF EXISTS Membership;
DROP TABLE IF EXISTS employee;
DROP TABLE IF EXISTS position;
DROP TABLE IF EXISTS branch;
DROP TABLE IF EXISTS customer;
DROP TABLE IF EXISTS Service_type;

USE washflow; 

CREATE TABLE branch (
    branch_ID INT PRIMARY KEY AUTO_INCREMENT,
    branch_name VARCHAR(100) NOT NULL,
    branch_address VARCHAR(255) NOT NULL  
);

CREATE TABLE customer (
    cust_ID INT PRIMARY KEY AUTO_INCREMENT,
    cust_fname VARCHAR(100) NOT NULL,
    cust_lname VARCHAR(100) NOT NULL,
    cust_tel VARCHAR(20) NOT NULL, 
    cust_address VARCHAR(255),
    cust_username VARCHAR(50) NOT NULL UNIQUE,
    cust_password VARCHAR(255) NOT NULL
);

CREATE TABLE employee_position (
    pos_ID INT PRIMARY KEY AUTO_INCREMENT,
    pos_name VARCHAR(100) NOT NULL UNIQUE,
    pos_salary DECIMAL(10,2) NOT NULL  
);

CREATE TABLE employee (
    emp_ID INT PRIMARY KEY AUTO_INCREMENT,
    emp_fname VARCHAR(100) NOT NULL,
    emp_lname VARCHAR(100) NOT NULL,
    emp_address VARCHAR(255),
    emp_username VARCHAR(50) NOT NULL UNIQUE,
    emp_password VARCHAR(255) NOT NULL,
    branch_ID INT NOT NULL,
    pos_ID INT NOT NULL,

    FOREIGN KEY (branch_ID) REFERENCES branch(branch_ID),
    FOREIGN KEY (pos_ID) REFERENCES employee_position(pos_ID)
);

CREATE TABLE vehicle_type (
    vehicletype_ID INT PRIMARY KEY AUTO_INCREMENT,
    vehicletype_name VARCHAR(50) NOT NULL,
    vehicletype_multiplier DECIMAL(3,2) NOT NULL 
);

CREATE TABLE service_type (
    serviceType_ID INT PRIMARY KEY AUTO_INCREMENT,
    serviceType_Name VARCHAR(100) NOT NULL,
    serviceType_BasePrice DECIMAL(10,2) NOT NULL
);

CREATE TABLE membership (
    membership_ID INT PRIMARY KEY AUTO_INCREMENT,
    membership_name VARCHAR(100) NOT NULL,
    membership_description TEXT,
    membership_point INT DEFAULT 0 NOT NULL, 
    cust_ID INT NOT NULL UNIQUE,

    FOREIGN KEY (cust_ID) REFERENCES customer(cust_ID)
);


CREATE TABLE vehicle (
    vehicle_ID INT PRIMARY KEY AUTO_INCREMENT,
    vehicle_plate VARCHAR(20) NOT NULL UNIQUE, 
    vehicle_color VARCHAR(50),
    cust_ID INT NOT NULL,
    vehicletype_ID INT NOT NULL,

    FOREIGN KEY (cust_ID) REFERENCES customer(cust_ID),
    FOREIGN KEY (vehicletype_ID ) REFERENCES vehicle_type(vehicletype_ID)
);


CREATE TABLE booking (
    booking_ID INT PRIMARY KEY AUTO_INCREMENT,
    booking_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
    booking_status VARCHAR(50) DEFAULT 'pending' NOT NULL, 
    cust_ID INT NOT NULL,
    branch_ID INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (cust_ID) REFERENCES customer(cust_ID),
    FOREIGN KEY (branch_ID) REFERENCES branch(branch_ID)
);


CREATE TABLE payment (
    payment_ID INT PRIMARY KEY AUTO_INCREMENT,
    payment_amount DECIMAL(10,2) NOT NULL, 
    payment_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,  
    payment_method VARCHAR(50) NOT NULL,
    booking_ID INT NOT NULL UNIQUE,

    FOREIGN KEY (booking_ID) REFERENCES booking(booking_ID)
);


CREATE TABLE service (
    service_ID INT PRIMARY KEY AUTO_INCREMENT,
    service_status VARCHAR(50) DEFAULT 'in_progress' NOT NULL, 
    service_startdate DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,  
    service_finishdate DATETIME,
    booking_ID INT NOT NULL,
    vehicle_ID INT NOT NULL,

    FOREIGN KEY (booking_ID) REFERENCES booking(booking_ID),
    FOREIGN KEY (vehicle_ID) REFERENCES vehicle(vehicle_ID)
);


CREATE TABLE receipt (
    receipt_ID INT PRIMARY KEY AUTO_INCREMENT,
    receipt_number VARCHAR(20) NOT NULL UNIQUE,  
    receipt_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
    receipt_description TEXT,
    payment_ID INT NOT NULL UNIQUE,

    FOREIGN KEY (payment_ID) REFERENCES payment(payment_ID)
);


CREATE TABLE service_detail (
    sdetail_ID INT PRIMARY KEY AUTO_INCREMENT,
    sdetail_quantity INT DEFAULT 1 NOT NULL, 
    sdetail_price DECIMAL(10,2) NOT NULL,  

    service_ID INT NOT NULL,
    serviceType_ID INT NOT NULL,
    emp_ID INT NOT NULL,

    FOREIGN KEY (service_ID) REFERENCES service(service_ID),
    FOREIGN KEY (serviceType_ID) REFERENCES service_type(serviceType_ID),
    FOREIGN KEY (emp_ID) REFERENCES employee(emp_ID)
);
