<?php
session_start();
include 'config.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$adhar_card = $_POST['adhar_card'];
$pan_card = $_POST['pan_card'];
$salary = $_POST['salary'];
$role = $_POST['role'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Handle Photo Upload
$photo = $_FILES['photo']['name'];
$photo_tmp = $_FILES['photo']['tmp_name'];
$photo_folder = 'uploads/' . $photo;

if (move_uploaded_file($photo_tmp, $photo_folder)) {
    // Insert into users table
    $user_query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'employee')";
    if ($conn->query($user_query)) {
        $user_id = $conn->insert_id;

        // Insert into employees table
        $employee_query = "INSERT INTO employees 
            (user_id, name, address, phone, email, adhar_card, pan_card, salary, role, photo) 
            VALUES 
            ('$user_id', '$name', '$address', '$phone', '$email', '$adhar_card', '$pan_card', '$salary', '$role', '$photo')";

        if ($conn->query($employee_query)) {
            header("Location: manage_employees.php");
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Failed to upload photo.";
}
?>
