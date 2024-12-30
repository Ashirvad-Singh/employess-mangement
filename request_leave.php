<?php
session_start();
include 'config.php';

if ($_SESSION['role'] != 'employee') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$employee = $conn->query("SELECT * FROM employees WHERE user_id = '$user_id'")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $reason = $_POST['reason'];
    $employee_id = $employee['id']; // Get employee ID

    // Insert leave request into the database
    $query = "INSERT INTO leave_requests (employee_id, start_date, end_date, reason, status) 
              VALUES ('$employee_id', '$start_date', '$end_date', '$reason', 'pending')";
    
    if ($conn->query($query)) {
        // Redirect back to the dashboard with a success message
        header("Location: employee_dashboard.php?message=Leave request submitted successfully.");
        exit();
    } else {
        // Show error if the query fails
        echo "Error: " . $conn->error;
    }
}
?>
