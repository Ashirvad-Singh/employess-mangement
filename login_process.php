<?php
session_start();
include 'config.php';  // Include your database connection

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];  // User input password

    // Fetch user details from the database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Directly compare the entered password with the stored password (plain text)
        if ($password == $user['password']) {
            // Password is correct, login successful
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'];

            // Redirect user based on their role
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: employee_dashboard.php");
            }
            exit();
        } else {
            // Incorrect password
            echo "Invalid password.";
        }
    } else {
        // User not found
        echo "No user found with that username.";
    }
}
?>
