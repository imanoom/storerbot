<?php
$servername = "27.254.82.220";
$username = "alicornt_417";
$password = "Qjk7Gbd9gQ";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
?>