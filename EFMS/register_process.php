<?php
// Database connection
include_once('db.php');


// Get user input
$username = $_POST["username"];
$password = password_hash($_POST["password"], PASSWORD_BCRYPT);

// Insert data into the 'admins' table
$sql = "INSERT INTO admins (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Registration failed: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
