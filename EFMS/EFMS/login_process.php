<?php
session_start();
include_once('db.php');
// Database connection


// Get user input
$username = $_POST["username"];
$password = $_POST["password"];

// Retrieve hashed password from the database
$sql = "SELECT id, username, password FROM admins WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $hashed_password = $row["password"];
    if (password_verify($password, $hashed_password)) {
        $_SESSION["admin_id"] = $row["id"];
        $_SESSION["admin_username"] = $row["username"];
        header("Location: dashboard.php"); // Redirect to admin dashboard
    } else {
        echo "Invalid password.";
        header("Location: login.php");
    }
} else {
    echo "Admin not found.";
    header("Location: login.php");
}

$stmt->close();
$conn->close();
?>
