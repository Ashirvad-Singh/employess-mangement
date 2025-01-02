<?php
session_start();
include 'config.php'; 

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    $query = "UPDATE leave_requests SET status = 'rejected' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        header("Location: admin_leave_requests.php?message=Leave request rejected successfully.");
        exit();
    } else {
        header("Location: admin_leave_requests.php?message=Error rejecting leave request.");
        exit();
    }
} else {    header("Location: admin_leave_requests.php?message=Invalid leave request ID.");
    exit();
}
?>
