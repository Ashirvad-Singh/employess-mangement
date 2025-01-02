<?php
session_start();
include 'config.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $leave_id = $_GET['id'];  
    $status = $_GET['status']; 

    // Validate the status
    if ($status != 'approved' && $status != 'rejected') {
        echo "Invalid status.";
        exit();
    }

    $query = "UPDATE leave_requests SET status = '$status' WHERE id = '$leave_id'";

    if ($conn->query($query)) {
        header("Location: request_leave.php?message=Leave request updated successfully.");
    } else {
        echo "Error updating status: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
