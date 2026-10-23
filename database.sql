-- CarePulse Hospital Database Schema

DROP DATABASE IF EXISTS hospital_db;
CREATE DATABASE hospital_db;
USE hospital_db;

-- Roles Table
CREATE TABLE roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL
);

INSERT INTO roles (role_id, role_name) VALUES
(1, 'Admin'),
(2, 'Doctor'),
(3, 'Nurse'),
(4, 'Patient'),
(5, 'Accountant');

-- Users Table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(role_id) ON DELETE SET NULL
);

-- Departments Table
CREATE TABLE departments (
    department_id INT AUTO_INCREMENT PRIMARY KEY,
    department_name VARCHAR(100) NOT NULL
);

INSERT INTO departments (department_id, department_name) VALUES
(1, 'General Medicine'),
(2, 'Cardiology'),
(3, 'Pediatrics'),
(4, 'Neurology'),
(5, 'Orthopedics'),
(6, 'Surgery');

-- Doctors Table
CREATE TABLE doctors (
    doctor_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    specialty VARCHAR(100),
    phone VARCHAR(20),
    email VARCHAR(100),
    department_id INT,
    FOREIGN KEY (department_id) REFERENCES departments(department_id) ON DELETE SET NULL
);

INSERT INTO doctors (name, specialty, phone, email, department_id) VALUES
('Dr. Alexander Wright', 'Cardiology Specialist', '+1 (555) 234-5678', 'a.wright@carepulse.com', 2),
('Dr. Elena Rostova', 'Pediatric Medicine', '+1 (555) 876-5432', 'e.rostova@carepulse.com', 3),
('Dr. Marcus Vance', 'Orthopedic Surgery', '+1 (555) 345-6789', 'm.vance@carepulse.com', 5),
('Dr. Sophia Chen', 'Neurological Science', '+1 (555) 987-6543', 's.chen@carepulse.com', 4);

-- Nurses Table
CREATE TABLE nurses (
    nurse_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    specialty VARCHAR(100),
    phone VARCHAR(20),
    email VARCHAR(100),
    department_id INT,
    FOREIGN KEY (department_id) REFERENCES departments(department_id) ON DELETE SET NULL
);

-- Patients Table
CREATE TABLE patients (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    gender VARCHAR(10),
    date_of_birth DATE,
    phone VARCHAR(20),
    address TEXT,
    blood_group VARCHAR(5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO patients (first_name, last_name, gender, date_of_birth, phone, address, blood_group) VALUES
('James', 'Wilson', 'Male', '1985-04-12', '+1 (555) 111-2233', '742 Evergreen Terrace, Springfield', 'O+'),
('Sarah', 'Jenkins', 'Female', '1992-08-25', '+1 (555) 444-5566', '123 Maple Street, Medical District', 'A+'),
('Michael', 'Brown', 'Male', '1978-11-30', '+1 (555) 777-8899', '456 Oak Avenue, Cityville', 'B-');

-- Appointments Table
CREATE TABLE appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    appointment_date DATETIME,
    status VARCHAR(50) DEFAULT 'Scheduled',
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id) ON DELETE CASCADE
);

INSERT INTO appointments (patient_id, doctor_id, appointment_date, status) VALUES
(1, 1, '2026-09-20 10:00:00', 'Scheduled'),
(2, 2, '2026-09-21 14:30:00', 'Scheduled'),
(3, 3, '2026-09-19 09:15:00', 'Completed');

-- Bills Table
CREATE TABLE bills (
    bill_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    amount DECIMAL(10,2),
    status VARCHAR(50) DEFAULT 'Unpaid',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE
);

INSERT INTO bills (patient_id, amount, status) VALUES
(1, 250.00, 'Paid'),
(2, 480.50, 'Unpaid'),
(3, 120.00, 'Paid');

-- Medicines Table
CREATE TABLE medicines (
    medicine_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    price DECIMAL(10,2),
    stock INT
);

-- Pharmacy Sales Table
CREATE TABLE pharmacy_sales (
    sale_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    medicine_id INT,
    quantity INT,
    total_price DECIMAL(10,2),
    sale_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (medicine_id) REFERENCES medicines(medicine_id) ON DELETE CASCADE
);