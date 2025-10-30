<?php
//Create connection
include 'connect.php';

// sql to create table users
$sql_users = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL UNIQUE,         -- gunakan email sebagai username
        password VARCHAR(255) NOT NULL,                -- simpan hash password (password_hash)
        full_name VARCHAR(150) NOT NULL,
        role VARCHAR(50) NOT NULL,
        status ENUM('active','inactive') NOT NULL DEFAULT 'inactive',
        activation_token VARCHAR(128) DEFAULT NULL,
        reset_token VARCHAR(128) DEFAULT NULL,
        reg_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        modified TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";


if ($conn->query($sql_users) === TRUE) {
  echo "Table users successfully";
  echo "<br>";
} else {
  echo "Error creating table: " . $conn->error;
}

// Tabel products
    $sql_products = " CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        price DECIMAL(13,2) NOT NULL DEFAULT 0.00,
        stock INT NOT NULL DEFAULT 0,
        created_by INT DEFAULT NULL,
        created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        modified TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        CONSTRAINT fk_products_users FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE
    ) ";

if ($conn->query($sql_products) === TRUE) {
  echo "Table products successfully";
} else {
  echo "Error creating table: " . $conn->error;
}
$conn->close();
?>