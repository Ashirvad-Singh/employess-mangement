<?php
session_start();
include 'config.php';

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Ensure the 'id' and 'status' are present in the URL
if (isset($_GET['id']) && isset($_GET['status'])) {
    $leave_id = $_GET['id'];  // Get the leave request ID
    $status = $_GET['status'];  // Get the status (approved or rejected)

    // Validate the status
    if ($status != 'approved' && $status != 'rejected') {
        echo "Invalid status.";
        exit();
    }

    // Update the leave status in the database
    $query = "UPDATE leave_requests SET status = '$status' WHERE id = '$leave_id'";

    if ($conn->query($query)) {
        // Redirect back to the leave requests page with a success message
        header("Location: request_leave.php?message=Leave request updated successfully.");
    } else {
        echo "Error updating status: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
