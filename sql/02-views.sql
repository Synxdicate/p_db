DROP VIEW IF EXISTS service_detail_summary_view;
DROP VIEW IF EXISTS service_progress_view;
DROP VIEW IF EXISTS payment_receipt_view;
DROP VIEW IF EXISTS active_services_view;
DROP VIEW IF EXISTS booking_summary_view;
DROP VIEW IF EXISTS employee_branch_role_view;
DROP VIEW IF EXISTS customer_vehicles_view;
DROP VIEW IF EXISTS customer_membership_view;
DROP VIEW IF EXISTS branch_booking_count_view;
DROP VIEW IF EXISTS service_type_pricing_view;

USE washflow; 

-- 1. Customer Membership View
CREATE VIEW customer_membership_view AS
SELECT 
    c.cust_ID,
    CONCAT(c.cust_fname, ' ', c.cust_lname) AS customer_name,
    c.cust_tel,
    c.cust_address,
    c.cust_username,
    m.membership_ID,
    m.membership_name,
    m.membership_point,
    m.membership_description
FROM customer c
LEFT JOIN membership m ON c.cust_ID = m.cust_ID;

-- 2. Customer Vehicles View
CREATE VIEW customer_vehicles_view AS
SELECT 
    c.cust_ID,
    CONCAT(c.cust_fname, ' ', c.cust_lname) AS customer_name,
    c.cust_tel,
    v.vehicle_ID,
    v.vehicle_plate,
    v.vehicle_color,
    vt.vehicletype_name,
    vt.vehicletype_multiplier
FROM customer c
JOIN vehicle v ON c.cust_ID = v.cust_ID
JOIN vehicle_type vt ON v.vehicletype_ID = vt.vehicletype_ID;

-- 3. Employee Branch Position View (แก้จาก role เป็น position)
CREATE VIEW employee_branch_role_view AS
SELECT 
    e.emp_ID,
    CONCAT(e.emp_fname, ' ', e.emp_lname) AS employee_name,
    e.emp_address,
    e.emp_username,
    p.pos_name,
    p.pos_salary,
    b.branch_name,
    b.branch_address,
    b.branch_ID
FROM employee e
JOIN branch b ON e.branch_ID = b.branch_ID
JOIN employee_position p ON e.pos_ID = p.pos_ID;

-- 4. Booking Summary View
CREATE VIEW booking_summary_view AS
SELECT 
    b.booking_ID,
    b.booking_date,
    b.booking_status,
    b.created_at,
    b.updated_at,
    CONCAT(c.cust_fname, ' ', c.cust_lname) AS customer_name,
    c.cust_tel,
    c.cust_ID,
    br.branch_name,
    br.branch_address,
    br.branch_ID
FROM booking b
JOIN customer c ON b.cust_ID = c.cust_ID
JOIN branch br ON b.branch_ID = br.branch_ID;

-- 5. Service Progress View
CREATE VIEW service_progress_view AS
SELECT 
    s.service_ID,
    s.service_status,
    s.service_startdate,
    s.service_finishdate,
    v.vehicle_plate,
    v.vehicle_color,
    vt.vehicletype_name,
    b.booking_ID,
    CONCAT(c.cust_fname, ' ', c.cust_lname) AS customer_name,
    c.cust_tel,
    br.branch_name,
    br.branch_ID
FROM service s
JOIN vehicle v ON s.vehicle_ID = v.vehicle_ID
JOIN vehicle_type vt ON v.vehicletype_ID = vt.vehicletype_ID
JOIN booking b ON s.booking_ID = b.booking_ID
JOIN customer c ON b.cust_ID = c.cust_ID
JOIN branch br ON b.branch_ID = br.branch_ID;

-- 6. Payment Receipt View
CREATE VIEW payment_receipt_view AS
SELECT 
    p.payment_ID,
    p.payment_amount,
    p.payment_date,
    p.payment_method,
    p.booking_ID,
    r.receipt_ID,
    r.receipt_number,
    r.receipt_date,
    r.receipt_description,
    br.branch_name,
    br.branch_ID,
    CONCAT(c.cust_fname, ' ', c.cust_lname) AS customer_name
FROM payment p
LEFT JOIN receipt r ON p.payment_ID = r.payment_ID
JOIN booking b ON p.booking_ID = b.booking_ID
JOIN branch br ON b.branch_ID = br.branch_ID
JOIN customer c ON b.cust_ID = c.cust_ID;

-- 7. Service Detail Summary View
CREATE VIEW service_detail_summary_view AS
SELECT 
    sd.sdetail_ID,
    s.service_ID,
    st.serviceType_Name,
    st.serviceType_BasePrice,
    sd.sdetail_quantity,
    sd.sdetail_price,
    CONCAT(e.emp_fname, ' ', e.emp_lname) AS employee_name,
    v.vehicle_plate,
    v.vehicle_color,
    vt.vehicletype_name,
    br.branch_name,
    br.branch_ID,
    CONCAT(c.cust_fname, ' ', c.cust_lname) AS customer_name
FROM service_detail sd
JOIN service_type st ON sd.serviceType_ID = st.serviceType_ID
JOIN employee e ON sd.emp_ID = e.emp_ID
JOIN service s ON sd.service_ID = s.service_ID
JOIN vehicle v ON s.vehicle_ID = v.vehicle_ID
JOIN vehicle_type vt ON v.vehicletype_ID = vt.vehicletype_ID
JOIN booking b ON s.booking_ID = b.booking_ID
JOIN branch br ON b.branch_ID = br.branch_ID
JOIN customer c ON b.cust_ID = c.cust_ID;

-- 8. Branch Booking Count View
CREATE VIEW branch_booking_count_view AS
SELECT 
    b.branch_ID,
    b.branch_name,
    b.branch_address,
    COUNT(bk.booking_ID) AS total_bookings,
    SUM(CASE WHEN bk.booking_status = 'completed' THEN 1 ELSE 0 END) AS completed_bookings,
    SUM(CASE WHEN bk.booking_status = 'pending' THEN 1 ELSE 0 END) AS pending_bookings,
    SUM(CASE WHEN bk.booking_status = 'cancelled' THEN 1 ELSE 0 END) AS cancelled_bookings
FROM branch b
LEFT JOIN booking bk ON b.branch_ID = bk.branch_ID
GROUP BY b.branch_ID, b.branch_name, b.branch_address;

-- 9. Service Type Pricing View
CREATE VIEW service_type_pricing_view AS
SELECT 
    st.serviceType_ID,
    st.serviceType_Name,
    st.serviceType_BasePrice,
    vt.vehicletype_ID,
    vt.vehicletype_name,
    vt.vehicletype_multiplier,
    ROUND(st.serviceType_BasePrice * vt.vehicletype_multiplier, 2) AS calculated_price
FROM service_type st
CROSS JOIN vehicle_type vt
ORDER BY st.serviceType_Name, vt.vehicletype_name;

-- 10. Active Services View
CREATE VIEW active_services_view AS
SELECT 
    s.service_ID,
    CONCAT(c.cust_fname, ' ', c.cust_lname) AS customer_name,
    c.cust_tel,
    v.vehicle_plate,
    v.vehicle_color,
    vt.vehicletype_name,
    s.service_status,
    s.service_startdate,
    br.branch_name,
    br.branch_ID
FROM service s
JOIN vehicle v ON s.vehicle_ID = v.vehicle_ID
JOIN vehicle_type vt ON v.vehicletype_ID = vt.vehicletype_ID
JOIN booking b ON s.booking_ID = b.booking_ID
JOIN customer c ON b.cust_ID = c.cust_ID
JOIN branch br ON b.branch_ID = br.branch_ID
WHERE s.service_status = 'in_progress';
