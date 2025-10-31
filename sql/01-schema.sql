DROP TABLE IF EXISTS service_detail;
DROP TABLE IF EXISTS service;
DROP TABLE IF EXISTS receipt;
DROP TABLE IF EXISTS payment;
DROP TABLE IF EXISTS booking;
DROP TABLE IF EXISTS vehicle;
DROP TABLE IF EXISTS vehicle_type;
DROP TABLE IF EXISTS Membership;
DROP TABLE IF EXISTS employee;
DROP TABLE IF EXISTS role;
DROP TABLE IF EXISTS branch;
DROP TABLE IF EXISTS customer;
DROP TABLE IF EXISTS Service_type;

USE washflow; 

CREATE TABLE branch (
    branch_ID INT PRIMARY KEY AUTO_INCREMENT,
    branch_name VARCHAR(100) NOT NULL,
    branch_address VARCHAR(255)
);

CREATE TABLE customer (
    cust_ID INT PRIMARY KEY AUTO_INCREMENT,
    cust_fname VARCHAR(100) NOT NULL,
    cust_lname VARCHAR(100) NOT NULL,
    cust_tel VARCHAR(20),
    cust_address VARCHAR(255),
    cust_username VARCHAR(50) NOT NULL UNIQUE,
    cust_password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE role (
    role_ID INT PRIMARY KEY AUTO_INCREMENT,
    role_name VARCHAR(100) NOT NULL UNIQUE,
    salary DECIMAL(10,2)
);

CREATE TABLE employee (
    emp_ID INT PRIMARY KEY AUTO_INCREMENT,
    emp_fname VARCHAR(100) NOT NULL,
    emp_lname VARCHAR(100) NOT NULL,
    emp_address VARCHAR(255),
    emp_username VARCHAR(50) NOT NULL UNIQUE,
    emp_password VARCHAR(255) NOT NULL,
    branch_ID INT NOT NULL,
    role_ID INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (branch_ID) REFERENCES branch(branch_ID),
    FOREIGN KEY (role_ID) REFERENCES role(role_ID)
);


CREATE TABLE vehicle_type (
    vtype_ID INT PRIMARY KEY AUTO_INCREMENT,
    vtype_name VARCHAR(50) NOT NULL,
    vtype_multiplier DECIMAL(3,2)
);

CREATE TABLE service_type (
    Type_serviceID INT PRIMARY KEY AUTO_INCREMENT,
    Type_serviceName VARCHAR(100) NOT NULL,
    Type_serviceBasePrice DECIMAL(10,2) NOT NULL
);

CREATE TABLE membership (
    ID_Membership INT PRIMARY KEY AUTO_INCREMENT,
    membership_name VARCHAR(100) NOT NULL,
    membership_description TEXT,
    membership_point INT DEFAULT 0,
    customer_cust_ID INT NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (customer_cust_ID) REFERENCES customer(cust_ID)
);

CREATE TABLE vehicle (
    vehicle_ID INT PRIMARY KEY AUTO_INCREMENT,
    vehicle_plate VARCHAR(20) UNIQUE,
    vehicle_color VARCHAR(50),
    customer_cust_ID INT NOT NULL,
    vehicle_type_vtype_ID INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (customer_cust_ID) REFERENCES customer(cust_ID),
    FOREIGN KEY (vehicle_type_vtype_ID) REFERENCES vehicle_type(vtype_ID)
);

CREATE TABLE booking (
    booking_ID INT PRIMARY KEY AUTO_INCREMENT,
    booking_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    booking_status VARCHAR(50) DEFAULT 'pending',
    customer_cust_ID INT NOT NULL,
    branch_ID INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (customer_cust_ID) REFERENCES customer(cust_ID),
    FOREIGN KEY (branch_ID) REFERENCES branch(branch_ID)
);


CREATE TABLE payment (
    payment_ID INT PRIMARY KEY AUTO_INCREMENT,
    payment_amount DECIMAL(10,2),
    payment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    payment_method VARCHAR(50) NOT NULL,
    booking_ID INT NOT NULL UNIQUE,

    FOREIGN KEY (booking_ID) REFERENCES booking(booking_ID)
);

CREATE TABLE service (
    service_ID INT PRIMARY KEY AUTO_INCREMENT,
    service_status VARCHAR(50) DEFAULT 'in_progress',
    service_startdate DATETIME DEFAULT CURRENT_TIMESTAMP,
    service_finishdate DATETIME,
    booking_ID INT NOT NULL,
    vehicle_ID INT NOT NULL,

    FOREIGN KEY (booking_ID) REFERENCES booking(booking_ID),
    FOREIGN KEY (vehicle_ID) REFERENCES vehicle(vehicle_ID)
);


CREATE TABLE receipt (
    receipt_ID INT PRIMARY KEY AUTO_INCREMENT,
    receipt_number VARCHAR(20) UNIQUE,
    receipt_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    receipt_description TEXT,
    payment_ID INT NOT NULL UNIQUE,

    FOREIGN KEY (payment_ID) REFERENCES payment(payment_ID)
);

CREATE TABLE service_detail (
    sdetail_ID INT PRIMARY KEY AUTO_INCREMENT,
    sdetail_quantity INT DEFAULT 1,
    sdetail_price DECIMAL(10,2),
    service_ID INT NOT NULL,
    service_type_ID INT NOT NULL,
    employee_ID INT NOT NULL,

    FOREIGN KEY (service_ID) REFERENCES service(service_ID),
    FOREIGN KEY (service_type_ID) REFERENCES service_type(Type_serviceID),
    FOREIGN KEY (employee_ID) REFERENCES employee(emp_ID)
);