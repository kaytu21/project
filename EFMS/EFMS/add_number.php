<?php
// Database connection details
include_once('db.php');

if (isset($_POST['Add'])) {
    $name = $_POST['name'];
    $number = $_POST['number'];

    $insert = mysqli_query($conn, "INSERT INTO phonenumber (name, number) VALUES ('$name','$number')");

    if (!$insert) {
        echo mysqli_error($conn);
    } else {
        echo ("Data Successfully Added");
        header('Location: phone.php');
    }
}
?>