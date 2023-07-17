<?php
include("../connections/connection.php");

$create_user_table = "CREATE TABLE IF NOT EXISTS user_data (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_name TEXT(255),
  user_email TEXT(255),
  user_password VARCHAR(255) NOT NULL,
  user_type TEXT(255),
  ip DOUBLE NOT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL)";

$create_cities_table = "CREATE TABLE IF NOT EXISTS cities (
  id INT PRIMARY KEY AUTO_INCREMENT,
  city TEXT(255),
  code TEXT(255),
  state TEXT(255),
  created_at DATE UNIQUE NOT NULL)";
  
$conn->query($create_user_table);
$conn->query($create_cities_table);

if (mysqli_query($conn, $create_user_table) and mysqli_query($conn, $create_cities_table)) {
  echo "TABLE CREATED SUCCESSFULLY";
} else {
  echo "TABLE CREATED UNSUCCESSFULLY";
}
