<?php
//Create connection
include 'connect.php';

// Create database
$sql = "CREATE DATABASE my5edb";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully";
} else {
  echo "Error creating database: " . $conn->error;
}

$conn->close();
?>