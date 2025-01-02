<?php
session_start();
include 'config.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $leave_id = $_GET['id'];

    $query = "UPDATE leave_requests SET status = 'approved' WHERE id = '$leave_id'";

    if ($conn->query($query)) {
        header("Location: request_leave.php?message=Leave approved successfully!");
    } else {
        header("Location: request_leave.php?message=Failed to approve leave. Please try again.");
    }
} else {
    header("Location: request_leave.php?message=Invalid leave request.");
}
?>
